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
