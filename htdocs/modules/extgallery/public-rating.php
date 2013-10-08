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
 * @version     $Id: public-rating.php 8088 2011-11-06 09:38:12Z beckmi $
 */


require '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

if(!isset($_GET['id'])) {
	$photoId = 0;
} else {
	$photoId = intval($_GET['id']);
}
if(!isset($_GET['rate'])) {
	$rate = 0;
} else {
	$rate = intval($_GET['rate']);
}

$photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');
$photo = $photoHandler->get($photoId);

$permHandler = ExtgalleryPublicPermHandler::getHandler();
if($xoopsModuleConfig['enable_rating'] && !$permHandler->isAllowed($xoopsUser, 'public_rate', $photo->getVar('cat_id'))) {
	redirect_header("index.php", 3, _MD_EXTGALLERY_NOPERM);
	exit;
}

$ratingHandler = xoops_getmodulehandler('publicrating', 'extgallery');

if($ratingHandler->rate($photoId, $rate)) {
	$rating = $ratingHandler->getRate($photoId);
	$photoHandler->modifyPhoto($photoId,array('photo_rating'=>$rating));
	
	redirect_header("public-photo.php?photoId=".$photoId."#photoNav", 3, _MD_EXTGALLERY_VOTE_THANKS);
} else {
	redirect_header("public-photo.php?photoId=".$photoId."#photoNav", 3, _MD_EXTGALLERY_ALREADY_VOTED);
}

?>