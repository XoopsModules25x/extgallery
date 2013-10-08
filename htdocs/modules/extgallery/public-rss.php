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
 * @license GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author  Voltan (djvoltan@gmail.com)
 * @package ExtGallery
 * @version $Id: public-rss.php 10024 2012-08-08 07:32:05Z beckmi $
 */

require '../../mainfile.php';
include XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;

include_once XOOPS_ROOT_PATH . '/class/template.php';
if (function_exists('mb_http_output')) {
mb_http_output('pass');
}

$catId = isset($_GET['id']) ? $_GET['id'] : 0;

$catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
$photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');
$catObj = $catHandler->getCat($catId);

if ($catId != 0) {
	$permHandler = ExtgalleryPublicPermHandler::getHandler();
	if($permHandler->isAllowed($xoopsUser, 'public_access', $catId)) {
		$catObj = $catHandler->getCat($catId);
		$cat = $catHandler->objectToArray($catObj);
	}
}

header('Content-Type:text/xml; charset=' . _CHARSET);
$xoopsTpl = new XoopsTpl();
$xoopsTpl->caching=2;
$xoopsTpl->xoops_setCacheTime($xoopsModuleConfig['timecache_rss']*60);
$myts = MyTextSanitizer::getInstance();
if (!$xoopsTpl->is_cached('db:extgallery_public-rss.html')) {
	$channel_category = $xoopsModule->getVar('dirname');
	// Check if ML Hack is installed, and if yes, parse the $content in formatForML
	if (method_exists($myts, 'formatForML')) {
		$xoopsConfig['sitename'] = $myts->formatForML($xoopsConfig['sitename']);
		$xoopsConfig['slogan'] = $myts->formatForML($xoopsConfig['slogan']);
		$channel_category = $myts->formatForML($channel_category);
	}
	
	$xoopsTpl->assign('channel_charset', _CHARSET);
	$xoopsTpl->assign('channel_title', htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES));
	$xoopsTpl->assign('channel_link', PUBLISHER_URL);
	$xoopsTpl->assign('channel_desc', htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES));
	$xoopsTpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
	$xoopsTpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
	$xoopsTpl->assign('channel_editor', $xoopsConfig['adminmail']);

	if ($catId != 0) {
		$channel_category .= " > " . $catObj->getVar('cat_name');
		$categories = $catId;
	} else {
		$categories = array();
	}	

	$xoopsTpl->assign('channel_category', htmlspecialchars($channel_category));
	$xoopsTpl->assign('channel_generator', $xoopsModule->getVar('dirname'));
	$xoopsTpl->assign('channel_language', _LANGCODE);
	$xoopsTpl->assign('image_url', XOOPS_URL . $xoopsModuleConfig['logo_rss']);
	$dimention = getimagesize(XOOPS_ROOT_PATH . $xoopsModuleConfig['logo_rss']);
	
	if (empty($dimention[0])) {
		$width = 140;
		$height = 140;
	} else {
		$width = ($dimention[0] > 140) ? 140 : $dimention[0];
		$dimention[1] = $dimention[1] * $width / $dimention[0];
		$height = ($dimention[1] > 140) ? $dimention[1] * $dimention[0] / 140 : $dimention[1];
	}
	
	$xoopsTpl->assign('image_width', $width);
	$xoopsTpl->assign('image_height', $height);


	$param = array(
		'limit' => $xoopsModuleConfig['perpage_rss'],
		'cat' => $categories
	);
	
	$photos = $photoHandler->objectToArray($photoHandler->getLastPhoto($param));
	$xoopsTpl->assign('photos', $photos);
}
$xoopsTpl->display('db:extgallery_public-rss.html');
?>