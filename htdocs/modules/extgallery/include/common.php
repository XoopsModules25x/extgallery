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
 * @copyright    XOOPS Project http://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

if (!defined('EXTGALLERY_MODULE_PATH')) {
    define('EXTGALLERY_DIRNAME', basename(dirname(__DIR__)));
    define('EXTGALLERY_URL', XOOPS_URL . '/modules/' . EXTGALLERY_DIRNAME);
    define('EXTGALLERY_IMAGE_URL', EXTGALLERY_URL . '/assets/images/');
    define('EXTGALLERY_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . EXTGALLERY_DIRNAME);
    define('EXTGALLERY_IMAGE_PATH', EXTGALLERY_ROOT_PATH . '/assets/images');
    define('EXTGALLERY_ADMIN_URL', EXTGALLERY_URL . '/admin/');
    define('EXTGALLERY_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . EXTGALLERY_DIRNAME);
    define('EXTGALLERY_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . EXTGALLERY_DIRNAME);
}
xoops_loadLanguage('common', EXTGALLERY_DIRNAME);

include_once EXTGALLERY_ROOT_PATH . '/class/utility.php';
//include_once EXTGALLERY_ROOT_PATH . '/include/constants.php';
//include_once EXTGALLERY_ROOT_PATH . '/include/seo_functions.php';
//include_once EXTGALLERY_ROOT_PATH . '/class/metagen.php';
//include_once EXTGALLERY_ROOT_PATH . '/class/session.php';
//include_once EXTGALLERY_ROOT_PATH . '/class/xoalbum.php';
//include_once EXTGALLERY_ROOT_PATH . '/class/request.php';

$debug = false;
//$xoalbum = XoalbumXoalbum::getInstance($debug);
