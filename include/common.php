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
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */


$moduleDirName = basename(dirname(__DIR__));
$capsDirName   = strtoupper($moduleDirName);

if (!defined($capsDirName . '_DIRNAME')) {
    //if (!defined($moduleDirName)) {
    define($capsDirName . '_DIRNAME', $GLOBALS['xoopsModule']->dirname());
    define($capsDirName . '_PATH', XOOPS_ROOT_PATH . '/modules/' . $moduleDirName);
    define($capsDirName . '_URL', XOOPS_URL . '/modules/' . $moduleDirName);

    define($capsDirName . '_IMAGE_URL', XOOPS_URL . '/modules/' . $moduleDirName . '/assets/images');
    define($capsDirName . '_IMAGE_PATH', XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/assets/images');
    define($capsDirName . '_ADMIN_URL', XOOPS_URL . '/modules/' . $moduleDirName . '/admin');
    
    define($capsDirName . '_ADMIN', constant($capsDirName . '_URL') . '/admin/index.php');
    define($capsDirName . '_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . $moduleDirName);
    define($capsDirName . '_AUTHOR_LOGOIMG', constant($capsDirName . '_URL') . '/assets/images/logoModule.png');
    define($capsDirName . '_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . $moduleDirName); // WITHOUT Trailing slash
    define($capsDirName . '_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . $moduleDirName); // WITHOUT Trailing slash
}

//if (!defined('EXTGALLERY_MODULE_PATH')) {
//    define('EXTGALLERY_DIRNAME', basename(dirname(__DIR__)));
//    define('EXTGALLERY_URL', XOOPS_URL . '/modules/' . EXTGALLERY_DIRNAME);
//    define('EXTGALLERY_IMAGE_URL', EXTGALLERY_URL . '/assets/images/');
//    define('EXTGALLERY_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . EXTGALLERY_DIRNAME);
//    define('EXTGALLERY_IMAGE_PATH', EXTGALLERY_ROOT_PATH . '/assets/images');
//    define('EXTGALLERY_ADMIN_URL', EXTGALLERY_URL . '/admin/');
//    define('EXTGALLERY_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . EXTGALLERY_DIRNAME);
//    define('EXTGALLERY_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . EXTGALLERY_DIRNAME);
//}
//xoops_loadLanguage('common', EXTGALLERY_DIRNAME);

//require_once EXTGALLERY_ROOT_PATH . '/class/utility.php';
//require_once EXTGALLERY_ROOT_PATH . '/include/constants.php';
//require_once EXTGALLERY_ROOT_PATH . '/include/seo_functions.php';
//require_once EXTGALLERY_ROOT_PATH . '/class/metagen.php';
//require_once EXTGALLERY_ROOT_PATH . '/class/session.php';
//require_once EXTGALLERY_ROOT_PATH . '/class/xoalbum.php';
//require_once EXTGALLERY_ROOT_PATH . '/class/request.php';

require_once EXTGALLERY_ROOT_PATH . '/class/helper.php';

xoops_load('constants', EXTGALLERY_DIRNAME);
xoops_load('utility', EXTGALLERY_DIRNAME);


$extgallery = Extgallery::getInstance();
$extgallery->loadLanguage('common');

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new XoopsTpl();
}

$moduleDirName = basename(dirname(__DIR__));
$xoopsTpl->assign('mod_url',  XOOPS_URL . '/modules/' . $moduleDirName);
