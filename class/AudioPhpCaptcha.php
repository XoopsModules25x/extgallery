<?php

namespace XoopsModules\Extgallery;

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
        $iLength = mb_strlen($sText);

        // loop through characters in code and format
        $sFormattedText = '';
        foreach ($sText as $i => $iValue) {
            // comma separate all but first and last characters
            if ($i > 0 && $i < $iLength - 1) {
                $sFormattedText .= ', ';
            } elseif ($i == $iLength - 1) {
                // precede last character with "and"
                $sFormattedText .= ' and ';
            }
            $sFormattedText .= $sText[$i];
        }

        $aPhrases = [
            'The %1$s characters are as follows: %2$s',
            '%2$s, are the %1$s letters',
            'Here are the %1$s characters: %2$s',
            '%1$s characters are: %2$s',
            '%1$s letters: %2$s',
        ];

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
