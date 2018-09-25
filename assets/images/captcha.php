<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author       XOOPS Development Team,
 */

use XoopsModules\Extgallery;

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/mainfile.php';

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

//require_once dirname(dirname(__DIR__)) . '/class/php-captcha.inc.php';

$aFonts         = dirname(__DIR__) . '/fonts/AllStarResort.ttf';
$oVisualCaptcha = new Extgallery\PhpCaptcha($aFonts, 200, 60);
$oVisualCaptcha->Create();
