<?php
/**
 * ExtGallery User area
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
 * @version     $Id: public-categories.php 10874 2013-01-23 17:23:02Z beckmi $
 */


require '../../mainfile.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-categories.html';
include XOOPS_ROOT_PATH.'/header.php';

if(!isset($_GET['id'])) {
	$catId = 0;
} else {
	$catId = intval($_GET['id']);
}

$catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

$catObj = $catHandler->getCat($catId);

if(is_null($catObj)) {
	include(XOOPS_ROOT_PATH."/footer.php");
	exit;
}

$cat = $catHandler->objectToArrayWithoutExternalKey($catObj);
$xoopsTpl->assign('cat', $cat);

$catPath = $catHandler->objectToArray($catHandler->getPath($catId));
$xoopsTpl->assign('catPath', $catPath);

$catChild = $catHandler->objectToArray($catHandler->getChildren($catId),array('photo_id'));
$xoopsTpl->assign('catChild', $catChild);


if(isset($catObj)) {
	$xoopsTpl->assign('xoops_pagetitle', $catObj->getVar('cat_name'));
	$xoTheme->addMeta('meta','description',$catObj->getVar('cat_desc'));
}

$rel = "alternate";
$attributes['rel'] = $rel;
$attributes['type'] = "application/rss+xml";
$attributes['title'] = _MD_EXTGALLERY_RSS;
$attributes['href'] = XOOPS_URL."/modules/extgallery/public-rss.php";
$xoTheme->addMeta('link', $rel, $attributes);
$xoTheme->addStylesheet('modules/extgallery/include/style.css');

$lang = array(
			'categoriesAlbums'=>_MD_EXTGALLERY_CATEGORIESALBUMS,
			'nbAlbums'=>_MD_EXTGALLERY_NBALBUMS,
			'nbPhotos'=>_MD_EXTGALLERY_NBPHOTOS
		);
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));
$xoopsTpl->assign('disp_cat_img', $xoopsModuleConfig['disp_cat_img']);
$xoopsTpl->assign('display_type', $xoopsModuleConfig['display_type']);
$xoopsTpl->assign('show_rss', $xoopsModuleConfig['show_rss']);

include(XOOPS_ROOT_PATH."/footer.php");

?>