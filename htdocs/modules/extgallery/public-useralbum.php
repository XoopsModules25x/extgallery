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
 * @version     $Id: public-useralbum.php 10875 2013-01-23 17:25:30Z beckmi $
 */

require '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-useralbum.html';
include XOOPS_ROOT_PATH.'/header.php';


if(!isset($_GET['id'])) {
	$userId = 0;
} else {
	$userId = intval($_GET['id']);
}
if(!isset($_GET['start'])) {
	$start = 0;
} else {
	$start = intval($_GET['start']);
}

$ajaxeffect = $xoopsModuleConfig['use_ajax_effects'];
$xoopsTpl->assign('use_ajax_effects', $ajaxeffect);

//HACK BLUETEEN TO SORT PHOTOS BY USERS
//photo_date - photo_title - photo_hits - photo_rating
if((isset($_GET['sortby']) && ($_GET['sortby']=="photo_date" || $_GET['sortby']=="photo_title" || $_GET['sortby']=="photo_hits" || $_GET['sortby']=="photo_rating")  )) {
        $sortby = $_GET['sortby'];
} else {
        $sortby = "photo_date";
}

//ASC ou DESC
if((isset($_GET['orderby']) && ($_GET['orderby']=="DESC" || $_GET['orderby']=="ASC")  )) {
        $orderby = $_GET['orderby'];
} else {
        $orderby = $GLOBALS['xoopsModuleConfig']['display_set_order'];
}

$SortbyOrderby = $sortby." ".$orderby;

function convertorderbytrans($SortbyOrderby) {
	         $orderbyTrans = array();
            if ($SortbyOrderby == "photo_date DESC")   $orderbyTrans = _MD_EXTGALLERY_ORDERBY_DATEASC;
            if ($SortbyOrderby == "photo_date ASC")    $orderbyTrans = _MD_EXTGALLERY_ORDERBY_DATEDESC;
            if ($SortbyOrderby == "photo_title ASC")    $orderbyTrans = _MD_EXTGALLERY_ORDERBY_TITREASC;
            if ($SortbyOrderby == "photo_title DESC")   $orderbyTrans = _MD_EXTGALLERY_ORDERBY_TITREDESC;
            if ($SortbyOrderby == "uid ASC")    $orderbyTrans = _MD_EXTGALLERY_ORDERBY_DESIGNERASC;
            if ($SortbyOrderby == "uid DESC")   $orderbyTrans = _MD_EXTGALLERY_ORDERBY_DESIGNERDESC;
            if ($SortbyOrderby == "photo_hits DESC") $orderbyTrans = _MD_EXTGALLERY_ORDERBY_HITSASC;
            if ($SortbyOrderby == "photo_hits ASC")   $orderbyTrans = _MD_EXTGALLERY_ORDERBY_HITSDESC;
            if ($SortbyOrderby == "photo_rating DESC")  $orderbyTrans = _MD_EXTGALLERY_ORDERBY_NOTEASC;
            if ($SortbyOrderby == "photo_rating ASC") $orderbyTrans = _MD_EXTGALLERY_ORDERBY_NOTEDESC;
            return $orderbyTrans;
}

$photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

$photos = $photoHandler->objectToArray($photoHandler->getUserAlbumPhotoPage($userId, $start, $sortby, $orderby), array('uid'));
$k = $xoopsModuleConfig['nb_column'] - (count($photos)%$xoopsModuleConfig['nb_column']);
if($k != $xoopsModuleConfig['nb_column']) {
	for($i=0;$i<$k;$i++) {
		$photos[] = array();
	}
}

// HACK DATE BY MAGE : DISPLAY PUBLICATION DATE
foreach (array_keys($photos) as $i) {
	if(isset($photos[$i]['photo_date'])){
		$photos[$i]['photo_date'] = date(_SHORTDATESTRING, $photos[$i]['photo_date']);
	}
}
// END HACK DATE BY MAGE : DISPLAY PUBLICATION DATE

$xoopsTpl->assign('photos', $photos);

$pageNav = new XoopsPageNav($photoHandler->getUserAlbumCount($userId), $xoopsModuleConfig['nb_column']*$xoopsModuleConfig['nb_line'], $start, "start", "id=".$userId."&orderby=".$orderby."&sortby=".$sortby);//xoops - blueteen - tri de l'affichage
$xoopsTpl->assign('pageNav', $pageNav->renderNav());

$albumName = '';
if(count($photos) > 0) {
	$albumName = $photos[0]['user']['uname']._MD_EXTGALLERY_USERS_SUB_PHOTO_ALBUM;
	$xoopsTpl->assign('xoops_pagetitle', $albumName);
	$xoTheme->addMeta('meta','description', $albumName);
}

$jquery = $xoopsModuleConfig['enable_jquery'];
$xoopsTpl->assign('jquery', $jquery);
if($jquery == 1 && $ajaxeffect != 'none'){
	$xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
	switch($ajaxeffect) {
		case 'lightbox':
			$xoTheme->addScript("browse.php?Frameworks/jquery/plugins/jquery.lightbox.js");
			$xoTheme->addStylesheet('browse.php?modules/system/css/lightbox.css');
		break;
		
		case 'tooltip':
			$xoTheme->addScript("browse.php?modules/extgallery/include/tooltip/image.tooltip.js");
			$xoTheme->addStylesheet('browse.php?modules/extgallery/include/tooltip/image.tooltip.css');
		break;
		
		case 'overlay':
			$xoTheme->addScript("browse.php?modules/extgallery/include/overlay/overlay.jquery.tools.min.js");
			$xoTheme->addStylesheet('browse.php?modules/extgallery/include/overlay/overlay.css');
		break;
		
		case 'fancybox':
			$xoTheme->addScript("browse.php?modules/extgallery/include/fancybox/mousewheel.js");
			$xoTheme->addScript("browse.php?modules/extgallery/include/fancybox/fancybox.pack.js");
			$xoTheme->addStylesheet('browse.php?modules/extgallery/include/fancybox/fancybox.css');
		break;
		
		case 'prettyphoto':
			$xoTheme->addScript("browse.php?modules/extgallery/include/prettyphoto/jquery.prettyPhoto.js");
			$xoTheme->addStylesheet('browse.php?modules/extgallery/include/prettyphoto/prettyPhoto.css');
		break;
	}
}

$rel = "alternate";
$attributes['rel'] = $rel;
$attributes['type'] = "application/rss+xml";
$attributes['title'] = _MD_EXTGALLERY_RSS;
$attributes['href'] = XOOPS_URL."/modules/extgallery/public-rss.php";
$xoTheme->addMeta('link', $rel, $attributes);
$xoTheme->addStylesheet('modules/extgallery/include/style.css');

$lang = array('hits'=>_MD_EXTGALLERY_HITS,'comments'=>_MD_EXTGALLERY_COMMENTS,'albumName'=>$albumName);
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('enableExtra', $xoopsModuleConfig['display_extra_field']);
$xoopsTpl->assign('enableRating', $xoopsModuleConfig['enable_rating']);
$xoopsTpl->assign('nbColumn', $xoopsModuleConfig['nb_column']);
$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));
$xoopsTpl->assign('disp_ph_title', $xoopsModuleConfig['disp_ph_title']);

$xoopsTpl->assign('extgalleryUID', $userId);//xoops - blueteen - tri de l'affichage
$xoopsTpl->assign('extgalleryStart', $start);//xoops -blueteen - tri de l'affichage
$xoopsTpl->assign('extgallerySortbyOrderby', _MD_EXTGALLERY_ORDERBY.convertorderbytrans($SortbyOrderby));//xoops - blueteen - tri de l'affichage

//DNPROSSI - VOLTAN - added preferences option
//	enable_info, enable_submitter_lnk, enable_photo_hits
if ( $xoopsModuleConfig['info_view'] == "album" || $xoopsModuleConfig['info_view'] == "both" ) 
{
	if ( $xoopsModuleConfig['pubusr_info_view'] == "user" || $xoopsModuleConfig['pubusr_info_view'] == "both" ) 
	{
		if ( $xoopsModuleConfig['enable_info'] == 0 )
		{
			$enable_info = $xoopsModuleConfig['enable_info'];
		} 
		else { $enable_info = 1; }
	} else { $enable_info = 1; }		 	
} else { $enable_info = 1; }
$xoopsTpl->assign('enable_info', $enable_info);
$xoopsTpl->assign('enable_photo_hits', $xoopsModuleConfig['enable_photo_hits']);
$xoopsTpl->assign('enable_submitter_lnk', $xoopsModuleConfig['enable_submitter_lnk']);
$xoopsTpl->assign('enable_show_comments', $xoopsModuleConfig['enable_show_comments']);
$xoopsTpl->assign('enable_date', $xoopsModuleConfig['enable_date']);
$xoopsTpl->assign('show_rss', $xoopsModuleConfig['show_rss']);

//for tooltip
$xoopsTpl->assign('album_tooltip_borderwidth', $xoopsModuleConfig['album_tooltip_borderwidth']);
$xoopsTpl->assign('album_tooltip_bordercolor', $xoopsModuleConfig['album_tooltip_bordercolor']);
$xoopsTpl->assign('album_tooltip_width', $xoopsModuleConfig['album_tooltip_width']);

//for overlay
$xoopsTpl->assign('album_overlay_bg', $xoopsModuleConfig['album_overlay_bg']);
$xoopsTpl->assign('album_overlay_width', $xoopsModuleConfig['album_overlay_width']);
$xoopsTpl->assign('album_overlay_height', $xoopsModuleConfig['album_overlay_height']);

//for fancybox
$xoopsTpl->assign('album_fancybox_color', $xoopsModuleConfig['album_fancybox_color']);
$xoopsTpl->assign('album_fancybox_opacity', $xoopsModuleConfig['album_fancybox_opacity']);
$xoopsTpl->assign('album_fancybox_tin', $xoopsModuleConfig['album_fancybox_tin']);
$xoopsTpl->assign('album_fancybox_tout', $xoopsModuleConfig['album_fancybox_tout']);
$xoopsTpl->assign('album_fancybox_title', $xoopsModuleConfig['album_fancybox_title']);
$xoopsTpl->assign('album_fancybox_showtype', $xoopsModuleConfig['album_fancybox_showtype']);

//for prettyphoto 
$xoopsTpl->assign('album_prettyphoto_speed', $xoopsModuleConfig['album_prettyphoto_speed']);
$xoopsTpl->assign('album_prettyphoto_theme', $xoopsModuleConfig['album_prettyphoto_theme']);
$xoopsTpl->assign('album_prettyphoto_slidspeed', $xoopsModuleConfig['album_prettyphoto_slidspe']);
$xoopsTpl->assign('album_prettyphoto_autoplay', $xoopsModuleConfig['album_prettyphoto_autopla']);

include(XOOPS_ROOT_PATH."/footer.php");

?>