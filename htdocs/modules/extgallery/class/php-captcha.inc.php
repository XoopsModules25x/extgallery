<?php
/***************************************************************/
/* PhpCaptcha - A visual and audio CAPTCHA generation library

   Software License Agreement (BSD License)

   Copyright (C) 2005-2006, Edward Eliot.
   All rights reserved.

   Redistribution and use in source and binary forms, with or without
   modification, are permitted provided that the following conditions are met:

      * Redistributions of source code must retain the above copyright
        notice, this list of conditions and the following disclaimer.
      * Redistributions in binary form must reproduce the above copyright
        notice, this list of conditions and the following disclaimer in the
        documentation and/or other materials provided with the distribution.
      * Neither the name of Edward Eliot nor the names of its contributors
        may be used to endorse or promote products derived from this software
        without specific prior written permission of Edward Eliot.

   THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDER AND CONTRIBUTORS "AS IS" AND ANY
   EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
   WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
   DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY
   DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
   (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
   LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
   ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
   (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
   SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

   Last Updated:  18th April 2006                               */
/***************************************************************/

/************************ Documentation ************************/
/*

Documentation is available at http://www.ejeliot.com/pages/2

*/
/************************ Default Options **********************/

// start a PHP session - this class uses sessions to store the generated
// code. Comment out if you are calling already from your application
//session_start();

// class defaults - change to effect globally

define('CAPTCHA_SESSION_ID', 'php_captcha');
define('CAPTCHA_WIDTH', 200); // max 500
define('CAPTCHA_HEIGHT', 50); // max 200
define('CAPTCHA_NUM_CHARS', 5);
define('CAPTCHA_NUM_LINES', 70);
define('CAPTCHA_CHAR_SHADOW', false);
define('CAPTCHA_OWNER_TEXT', '');
define('CAPTCHA_CHAR_SET', ''); // defaults to A-Z
define('CAPTCHA_CASE_INSENSITIVE', true);
define('CAPTCHA_BACKGROUND_IMAGES', '');
define('CAPTCHA_MIN_FONT_SIZE', 18);
define('CAPTCHA_MAX_FONT_SIZE', 26);
define('CAPTCHA_USE_COLOUR', false);
define('CAPTCHA_FILE_TYPE', 'jpeg');
define('CAPTCHA_FLITE_PATH', '/usr/bin/flite');
define('CAPTCHA_AUDIO_PATH', '/tmp/'); // must be writeable by PHP process

/************************ End Default Options **********************/
// don't edit below this line (unless you want to change the class!)

class PhpCaptcha
{
    public $oImage;
    public $aFonts;
    public $iWidth;
    public $iHeight;
    public $iNumChars;
    public $iNumLines;
    public $iSpacing;
    public $bCharShadow;
    public $sOwnerText;
    public $aCharSet;
    public $bCaseInsensitive;
    public $vBackgroundImages;
    public $iMinFontSize;
    public $iMaxFontSize;
    public $bUseColour;
    public $sFileType;
    public $sCode = '';

    /**
     * PhpCaptcha constructor.
     * @param     $aFonts
     * @param int $iWidth
     * @param int $iHeight
     */
    public function __construct(
        $aFonts, // array of TrueType fonts to use - specify full path
        $iWidth = CAPTCHA_WIDTH, // width of image
        $iHeight = CAPTCHA_HEIGHT // height of image
)
    {
        // get parameters
        $this->aFonts = $aFonts;
        $this->SetNumChars(CAPTCHA_NUM_CHARS);
        $this->SetNumLines(CAPTCHA_NUM_LINES);
        $this->DisplayShadow(CAPTCHA_CHAR_SHADOW);
        $this->SetOwnerText(CAPTCHA_OWNER_TEXT);
        $this->SetCharSet(CAPTCHA_CHAR_SET);
        $this->CaseInsensitive(CAPTCHA_CASE_INSENSITIVE);
        $this->SetBackgroundImages(CAPTCHA_BACKGROUND_IMAGES);
        $this->SetMinFontSize(CAPTCHA_MIN_FONT_SIZE);
        $this->SetMaxFontSize(CAPTCHA_MAX_FONT_SIZE);
        $this->UseColour(CAPTCHA_USE_COLOUR);
        $this->SetFileType(CAPTCHA_FILE_TYPE);
        $this->SetWidth($iWidth);
        $this->SetHeight($iHeight);
    }

    public function CalculateSpacing()
    {
        $this->iSpacing = (int)($this->iWidth / $this->iNumChars);
    }

    /**
     * @param $iWidth
     */
    public function SetWidth($iWidth)
    {
        $this->iWidth = $iWidth;
        if ($this->iWidth > 500) {
            $this->iWidth = 500;
        } // to prevent perfomance impact
        $this->CalculateSpacing();
    }

    /**
     * @param $iHeight
     */
    public function SetHeight($iHeight)
    {
        $this->iHeight = $iHeight;
        if ($this->iHeight > 200) {
            $this->iHeight = 200;
        } // to prevent performance impact
    }

    /**
     * @param $iNumChars
     */
    public function SetNumChars($iNumChars)
    {
        $this->iNumChars = $iNumChars;
        $this->CalculateSpacing();
    }

    /**
     * @param $iNumLines
     */
    public function SetNumLines($iNumLines)
    {
        $this->iNumLines = $iNumLines;
    }

    /**
     * @param $bCharShadow
     */
    public function DisplayShadow($bCharShadow)
    {
        $this->bCharShadow = $bCharShadow;
    }

    /**
     * @param $sOwnerText
     */
    public function SetOwnerText($sOwnerText)
    {
        $this->sOwnerText = $sOwnerText;
    }

    /**
     * @param $vCharSet
     */
    public function SetCharSet($vCharSet)
    {
        // check for input type
        if (is_array($vCharSet)) {
            $this->aCharSet = $vCharSet;
        } else {
            if ($vCharSet != '') {
                // split items on commas
                $aCharSet = explode(',', $vCharSet);

                // initialise array
                $this->aCharSet = array();

                // loop through items
                foreach ($aCharSet as $sCurrentItem) {
                    // a range should have 3 characters, otherwise is normal character
                    if (strlen($sCurrentItem) == 3) {
                        // split on range character
                        $aRange = explode('-', $sCurrentItem);

                        // check for valid range
                        if (count($aRange) == 2 && $aRange[0] < $aRange[1]) {
                            // create array of characters from range
                            $aRange = range($aRange[0], $aRange[1]);

                            // add to charset array
                            $this->aCharSet = array_merge($this->aCharSet, $aRange);
                        }
                    } else {
                        $this->aCharSet[] = $sCurrentItem;
                    }
                }
            }
        }
    }

    /**
     * @param $bCaseInsensitive
     */
    public function CaseInsensitive($bCaseInsensitive)
    {
        $this->bCaseInsensitive = $bCaseInsensitive;
    }

    /**
     * @param $vBackgroundImages
     */
    public function SetBackgroundImages($vBackgroundImages)
    {
        $this->vBackgroundImages = $vBackgroundImages;
    }

    /**
     * @param $iMinFontSize
     */
    public function SetMinFontSize($iMinFontSize)
    {
        $this->iMinFontSize = $iMinFontSize;
    }

    /**
     * @param $iMaxFontSize
     */
    public function SetMaxFontSize($iMaxFontSize)
    {
        $this->iMaxFontSize = $iMaxFontSize;
    }

    /**
     * @param $bUseColour
     */
    public function UseColour($bUseColour)
    {
        $this->bUseColour = $bUseColour;
    }

    /**
     * @param $sFileType
     */
    public function SetFileType($sFileType)
    {
        // check for valid file type
        if (in_array($sFileType, array('gif', 'png', 'jpeg'))) {
            $this->sFileType = $sFileType;
        } else {
            $this->sFileType = 'jpeg';
        }
    }

    public function DrawLines()
    {
        for ($i = 0; $i < $this->iNumLines; ++$i) {
            // allocate colour
            if ($this->bUseColour) {
                $iLineColour = imagecolorallocate($this->oImage, mt_rand(100, 250), mt_rand(100, 250), mt_rand(100, 250));
            } else {
                $iRandColour = mt_rand(100, 250);
                $iLineColour = imagecolorallocate($this->oImage, $iRandColour, $iRandColour, $iRandColour);
            }

            // draw line
            imageline($this->oImage, mt_rand(0, $this->iWidth), mt_rand(0, $this->iHeight), mt_rand(0, $this->iWidth), mt_rand(0, $this->iHeight), $iLineColour);
        }
    }

    public function DrawOwnerText()
    {
        // allocate owner text colour
        $iBlack = imagecolorallocate($this->oImage, 0, 0, 0);
        // get height of selected font
        $iOwnerTextHeight = imagefontheight(2);
        // calculate overall height
        $iLineHeight = $this->iHeight - $iOwnerTextHeight - 4;

        // draw line above text to separate from CAPTCHA
        imageline($this->oImage, 0, $iLineHeight, $this->iWidth, $iLineHeight, $iBlack);

        // write owner text
        imagestring($this->oImage, 2, 3, $this->iHeight - $iOwnerTextHeight - 3, $this->sOwnerText, $iBlack);

        // reduce available height for drawing CAPTCHA
        $this->iHeight = $this->iHeight - $iOwnerTextHeight - 5;
    }

    public function GenerateCode()
    {
        // reset code
        $this->sCode = '';

        // loop through and generate the code letter by letter
        for ($i = 0; $i < $this->iNumChars; ++$i) {
            if (count($this->aCharSet) > 0) {
                // select random character and add to code string
                $this->sCode .= $this->aCharSet[array_rand($this->aCharSet)];
            } else {
                // select random character and add to code string
                $this->sCode .= chr(mt_rand(65, 90));
            }
        }

        // save code in session variable
        if ($this->bCaseInsensitive) {
            $_SESSION[CAPTCHA_SESSION_ID] = strtoupper($this->sCode);
        } else {
            $_SESSION[CAPTCHA_SESSION_ID] = $this->sCode;
        }
    }

    public function DrawCharacters()
    {
        // loop through and write out selected number of characters
        for ($i = 0, $iMax = strlen($this->sCode); $i < $iMax; ++$i) {
            // select random font
            $sCurrentFont = $this->aFonts[array_rand($this->aFonts)];

            // select random colour
            if ($this->bUseColour) {
                $iTextColour = imagecolorallocate($this->oImage, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));

                if ($this->bCharShadow) {
                    // shadow colour
                    $iShadowColour = imagecolorallocate($this->oImage, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));
                }
            } else {
                $iRandColour = mt_rand(0, 100);
                $iTextColour = imagecolorallocate($this->oImage, $iRandColour, $iRandColour, $iRandColour);

                if ($this->bCharShadow) {
                    // shadow colour
                    $iRandColour   = mt_rand(0, 100);
                    $iShadowColour = imagecolorallocate($this->oImage, $iRandColour, $iRandColour, $iRandColour);
                }
            }

            // select random font size
            $iFontSize = mt_rand($this->iMinFontSize, $this->iMaxFontSize);

            // select random angle
            $iAngle = mt_rand(-30, 30);

            // get dimensions of character in selected font and text size
            $aCharDetails = imageftbbox($iFontSize, $iAngle, $sCurrentFont, $this->sCode[$i], array());

            // calculate character starting coordinates
            $iX          = $this->iSpacing / 4 + $i * $this->iSpacing;
            $iCharHeight = $aCharDetails[2] - $aCharDetails[5];
            $iY          = $this->iHeight / 2 + $iCharHeight / 4;

            // write text to image
            imagefttext($this->oImage, $iFontSize, $iAngle, $iX, $iY, $iTextColour, $sCurrentFont, $this->sCode[$i], array());

            if ($this->bCharShadow) {
                $iOffsetAngle = mt_rand(-30, 30);

                $iRandOffsetX = mt_rand(-5, 5);
                $iRandOffsetY = mt_rand(-5, 5);

                imagefttext($this->oImage, $iFontSize, $iOffsetAngle, $iX + $iRandOffsetX, $iY + $iRandOffsetY, $iShadowColour, $sCurrentFont, $this->sCode[$i], array());
            }
        }
    }

    /**
     * @param $sFilename
     */
    public function WriteFile($sFilename)
    {
        if ($sFilename == '') {
            // tell browser that data is jpeg
            header("Content-type: image/$this->sFileType");
        }

        switch ($this->sFileType) {
            case 'gif':
                $sFilename != '' ? imagegif($this->oImage, $sFilename) : imagegif($this->oImage);
                break;
            case 'png':
                $sFilename != '' ? imagepng($this->oImage, $sFilename) : imagepng($this->oImage);
                break;
            default:
                $sFilename != '' ? imagejpeg($this->oImage, $sFilename) : imagejpeg($this->oImage);
        }
    }

    /**
     * @param string $sFilename
     *
     * @return bool
     */
    public function Create($sFilename = '')
    {
        // check for required gd functions
        if (!function_exists('imagecreate') || !function_exists("image$this->sFileType")
            || ($this->vBackgroundImages != '' && !function_exists('imagecreatetruecolor'))
        ) {
            return false;
        }

        // get background image if specified and copy to CAPTCHA
        if (is_array($this->vBackgroundImages) || $this->vBackgroundImages != '') {
            // create new image
            $this->oImage = imagecreatetruecolor($this->iWidth, $this->iHeight);

            // create background image
            if (is_array($this->vBackgroundImages)) {
                $iRandImage       = array_rand($this->vBackgroundImages);
                $oBackgroundImage = imagecreatefromjpeg($this->vBackgroundImages[$iRandImage]);
            } else {
                $oBackgroundImage = imagecreatefromjpeg($this->vBackgroundImages);
            }

            // copy background image
            imagecopy($this->oImage, $oBackgroundImage, 0, 0, 0, 0, $this->iWidth, $this->iHeight);

            // free memory used to create background image
            imagedestroy($oBackgroundImage);
        } else {
            // create new image
            $this->oImage = imagecreate($this->iWidth, $this->iHeight);
        }

        // allocate white background colour
        imagecolorallocate($this->oImage, 255, 255, 255);

        // check for owner text
        if ($this->sOwnerText != '') {
            $this->DrawOwnerText();
        }

        // check for background image before drawing lines
        if (!is_array($this->vBackgroundImages) && $this->vBackgroundImages == '') {
            $this->DrawLines();
        }

        $this->GenerateCode();
        $this->DrawCharacters();

        // write out image to file or browser
        $this->WriteFile($sFilename);

        // free memory used in creating image
        imagedestroy($this->oImage);

        return true;
    }

    // call this method statically
    /**
     * @param      $sUserCode
     * @param bool $bCaseInsensitive
     *
     * @return bool
     */
    public static function Validate($sUserCode, $bCaseInsensitive = true)
    {
        if ($bCaseInsensitive) {
            $sUserCode = strtoupper($sUserCode);
        }

        if (!empty($_SESSION[CAPTCHA_SESSION_ID]) && $sUserCode == $_SESSION[CAPTCHA_SESSION_ID]) {
            // clear to prevent re-use
            unset($_SESSION[CAPTCHA_SESSION_ID]);

            return true;
        }

        return false;
    }
}

// this class will only work correctly if a visual CAPTCHA has been created first using PhpCaptcha
/**
 * Class AudioPhpCaptcha
 */
class AudioPhpCaptcha
{
    public $sFlitePath;
    public $sAudioPath;
    public $sCode;

    /**
     * AudioPhpCaptcha constructor.
     * @param string $sFlitePath
     * @param string $sAudioPath
     */
    public function __construct(
        $sFlitePath = CAPTCHA_FLITE_PATH, // path to flite binary
        $sAudioPath = CAPTCHA_AUDIO_PATH // the location to temporarily store the generated audio CAPTCHA
)
    {
        $this->SetFlitePath($sFlitePath);
        $this->SetAudioPath($sAudioPath);

        // retrieve code if already set by previous instance of visual PhpCaptcha
        if (isset($_SESSION[CAPTCHA_SESSION_ID])) {
            $this->sCode = $_SESSION[CAPTCHA_SESSION_ID];
        }
    }

    /**
     * @param $sFlitePath
     */
    public function SetFlitePath($sFlitePath)
    {
        $this->sFlitePath = $sFlitePath;
    }

    /**
     * @param $sAudioPath
     */
    public function SetAudioPath($sAudioPath)
    {
        $this->sAudioPath = $sAudioPath;
    }

    /**
     * @param $sText
     *
     * @return string
     */
    public function Mask($sText)
    {
        $iLength = strlen($sText);

        // loop through characters in code and format
        $sFormattedText = '';
        for ($i = 0; $i < $iLength; ++$i) {
            // comma separate all but first and last characters
            if ($i > 0 && $i < $iLength - 1) {
                $sFormattedText .= ', ';
            } elseif ($i == $iLength - 1) { // precede last character with "and"
                $sFormattedText .= ' and ';
            }
            $sFormattedText .= $sText[$i];
        }

        $aPhrases = array(
            "The %1\$s characters are as follows: %2\$s",
            "%2\$s, are the %1\$s letters",
            "Here are the %1\$s characters: %2\$s",
            "%1\$s characters are: %2\$s",
            "%1\$s letters: %2\$s"
        );

        $iPhrase = array_rand($aPhrases);

        return sprintf($aPhrases[$iPhrase], $iLength, $sFormattedText);
    }

    public function Create()
    {
        $sText = $this->Mask($this->sCode);
        $sFile = md5($this->sCode . time());

        // create file with flite
        shell_exec("$this->sFlitePath -t \"$sText\" -o $this->sAudioPath$sFile.wav");

        // set headers
        header('Content-type: audio/x-wav');
        header("Content-Disposition: attachment;filename=$sFile.wav");

        // output to browser
        echo file_get_contents("$this->sAudioPath$sFile.wav");

        // delete temporary file
        @unlink("$this->sAudioPath$sFile.wav");
    }
}

// example sub class
/**
 * Class PhpCaptchaColour
 */
class PhpCaptchaColour extends PhpCaptcha
{
    /**
     * PhpCaptchaColour constructor.
     * @param     $aFonts
     * @param int $iWidth
     * @param int $iHeight
     */
    public function __construct($aFonts, $iWidth = CAPTCHA_WIDTH, $iHeight = CAPTCHA_HEIGHT)
    {
        // call parent constructor
        parent::__construct($aFonts, $iWidth, $iHeight);

        // set options
        $this->UseColour(true);
    }
}
