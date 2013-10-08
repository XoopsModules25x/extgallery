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
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 * @version     $Id: menu.php 10467 2012-12-19 02:04:40Z beckmi $
 */
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

$dirname = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$module = $module_handler->getByDirname($dirname);
$pathIcon32 = $module->getInfo('icons32');

//xoops_loadLanguage('admin', $dirname);

$i = 1;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_INDEX;
$adminmenu[$i]['link']  = "admin/index.php";
$adminmenu[$i]['icon']  = "images/icons/index.png";
$i++;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_PUBLIC_CAT;
$adminmenu[$i]['link']  = "admin/public-category.php";
$adminmenu[$i]['icon']  = "images/icons/category.png";
$i++;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_PHOTO;
$adminmenu[$i]['link']  = "admin/photo.php";
$adminmenu[$i]['icon']  = "images/icons/photo.png";
$i++;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_PERMISSIONS;
$adminmenu[$i]['link']  = "admin/perm-quota.php";
$adminmenu[$i]['icon']  = "images/icons/perm.png";
$i++;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_WATERMARK_BORDER;
$adminmenu[$i]['link']  = "admin/watermark-border.php";
$adminmenu[$i]['icon']  = "images/icons/watermark.png";
$i++;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_SLIDESHOW;
$adminmenu[$i]['link']  = "admin/slideshow.php";
$adminmenu[$i]['icon']  = "images/icons/slideshow.png";
$i++;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_EXTENSION;
$adminmenu[$i]['link']  = "admin/extension.php";
$adminmenu[$i]['icon'] = "images/icons/extension.png";
$i++;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_ALBUM;
$adminmenu[$i]['link']  = "admin/album.php";
$adminmenu[$i]['icon']  = "images/icons/album.png";
$i++;
$adminmenu[$i]['title'] = _MI_EXTGALLERY_ABOUT;
$adminmenu[$i]['link']  = "admin/about.php";
$adminmenu[$i]['icon']  = "images/icons/about.png";
?>