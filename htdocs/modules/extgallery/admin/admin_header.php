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
 * @copyright    XOOPS Project (http://xoops.org)
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

include_once __DIR__ . '/../../../include/cp_header.php';
include_once $GLOBALS['xoops']->path('www/class/xoopsformloader.php');

if (!isset($moduleDirName)) {
    $moduleDirName = basename(dirname(__DIR__));
}

include_once __DIR__ . '/../include/config.php';

xoops_load('XoopsRequest');

//$moduleDirName = $GLOBALS['xoopsModule']->getVar('dirname');

$pathIcon16           = $GLOBALS['xoops']->url('www/' . $GLOBALS['xoopsModule']->getInfo('systemIcons16'));
$pathIcon32           = $GLOBALS['xoops']->url('www/' . $GLOBALS['xoopsModule']->getInfo('systemIcons32'));
$xoopsModuleAdminPath = $GLOBALS['xoops']->path('www/' . $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin'));
require_once $xoopsModuleAdminPath . '/moduleadmin.php';

$myts = MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    include_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new XoopsTpl();
}

//Module specific elements
//include_once $GLOBALS['xoops']->path("modules/{$moduleDirName}/include/functions.php");
//include_once $GLOBALS['xoops']->path("modules/{$moduleDirName}/include/config.php");

//Handlers
//$XXXHandler = xoops_getModuleHandler('XXX', $moduleDirName);

// Load language files
xoops_loadLanguage('admin', $moduleDirName);
xoops_loadLanguage('modinfo', $moduleDirName);
xoops_loadLanguage('main', $moduleDirName);

//xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
