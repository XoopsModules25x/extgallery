<?php
/**
 * ExtGallery Admin settings
 * Manage admin pages
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   {@link http://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */
// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

$moduleDirName = basename(dirname(__DIR__));

/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname($moduleDirName);
$pathIcon32    = '../../' . $module->getInfo('systemIcons32');
$pathModIcon32 = '/../' . $module->getInfo('moduleIcons32');
xoops_loadLanguage('modinfo', $moduleDirName);

//xoops_loadLanguage('admin', $dirname);

$xoopsModuleAdminPath = XOOPS_ROOT_PATH . '/' . $module->getInfo('dirmoduleadmin');


if (!file_exists($fileinc = $xoopsModuleAdminPath . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/' . 'main.php')) {
    $fileinc = $xoopsModuleAdminPath . '/language/english/main.php';
}
include_once $fileinc;

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png'
);

$adminmenu[] = array(
    'title' => _MI_EXTGALLERY_PUBLIC_CAT,
    'link'  => 'admin/public-category.php',
    'icon'  => $pathIcon32 . '/category.png'
);

$adminmenu[] = array(
    'title' => _MI_EXTGALLERY_PHOTO,
    'link'  => 'admin/photo.php',
    'icon'  => $pathIcon32 . '/photo.png'
);

$adminmenu[] = array(
    'title' => _MI_EXTGALLERY_PERMISSIONS,
    'link'  => 'admin/perm-quota.php',
    'icon'  => $pathIcon32 . '/permissions.png'
);

$adminmenu[] = array(
    'title' => _MI_EXTGALLERY_WATERMARK_BORDER,
    'link'  => 'admin/watermark-border.php',
    'icon'  => $pathIcon32 . '/watermark.png'
);

$adminmenu[] = array(
    'title' => _MI_EXTGALLERY_SLIDESHOW,
    'link'  => 'admin/slideshow.php',
    'icon'  => $pathIcon32 . '/slideshow.png'
);

$adminmenu[] = array(
    'title' => _MI_EXTGALLERY_EXTENSION,
    'link'  => 'admin/extension.php',
    'icon'  => $pathModIcon32 . '/extension.png'
);

$adminmenu[] = array(
    'title' => _MI_EXTGALLERY_ALBUM,
    'link'  => 'admin/album.php',
    'icon'  => $pathIcon32 . '/album.png'
);

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
);
