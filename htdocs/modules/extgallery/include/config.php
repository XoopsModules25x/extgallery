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

require_once __DIR__ . '/../../../mainfile.php';
$moduleDirName = basename(dirname(__DIR__));

if (!defined('EXTGALLERY_DIRNAME')) {
    define('EXTGALLERY_DIRNAME', $moduleDirName);
    define('EXTGALLERY_PATH', XOOPS_ROOT_PATH . '/modules/' . EXTGALLERY_DIRNAME);
    define('EXTGALLERY_URL', XOOPS_URL . '/modules/' . EXTGALLERY_DIRNAME);
    define('EXTGALLERY_ADMIN', EXTGALLERY_URL . '/admin/index.php');
    define('EXTGALLERY_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . EXTGALLERY_DIRNAME);
    define('EXTGALLERY_AUTHOR_LOGOIMG', EXTGALLERY_URL . '/assets/images/logoModule.png');
    define('EXTGALLERY_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . EXTGALLERY_DIRNAME); // WITHOUT Trailing slash
    define('EXTGALLERY_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . EXTGALLERY_DIRNAME); // WITHOUT Trailing slash
}

//Configurator
return array(
    'name'          => 'Module Configurator',
    'uploadFolders' => array(
        EXTGALLERY_UPLOAD_PATH,
        EXTGALLERY_UPLOAD_PATH . '/public-photo',
        EXTGALLERY_UPLOAD_PATH . '/public-photo/original',
        EXTGALLERY_UPLOAD_PATH . '/public-photo/large',
        EXTGALLERY_UPLOAD_PATH . '/public-photo/medium',
        EXTGALLERY_UPLOAD_PATH . '/public-photo/thumb',
    ),
    'copyFiles'     => array(
        EXTGALLERY_UPLOAD_PATH,
        EXTGALLERY_UPLOAD_PATH . '/public-photo',
        EXTGALLERY_UPLOAD_PATH . '/public-photo/original',
        EXTGALLERY_UPLOAD_PATH . '/public-photo/large',
        EXTGALLERY_UPLOAD_PATH . '/public-photo/medium',
        EXTGALLERY_UPLOAD_PATH . '/public-photo/thumb',
    ),
    'oldFiles'      => array(
        '/include/update_functions.php',
        '/include/install_functions.php'
    ),
);

// module information
$mod_copyright = "<a href='http://xoops.org' title='XOOPS Project' target='_blank'>
                     <img src='" . EXTGALLERY_AUTHOR_LOGOIMG . "' alt='XOOPS Project' /></a>";
