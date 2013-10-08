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
 * @version     $Id: public-upload-extended.php 8088 2011-11-06 09:38:12Z beckmi $
 */

require '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-upload-applet.html';
include XOOPS_ROOT_PATH.'/header.php';

$permHandler = ExtgalleryPublicPermHandler::getHandler();
if(count($permHandler->getAuthorizedPublicCat($xoopsUser, 'public_upload')) < 1) {
	redirect_header("index.php", 3, _MD_EXTGALLERY_NOPERM);
	exit;
}

//echo "<pre>";print_r($xoopsModuleConfig);echo "</pre>";
$_SESSION['juvar.tmpsize'] = 0;
$catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

$xoopsTpl->assign('categorySelect', $catHandler->getLeafSelect('cat_id', false, 0, "", "public_upload"));
$xoopsTpl->assign('imageQuality', $xoopsModuleConfig['medium_quality'] / 100);
$xoopsTpl->assign('appletLang', _MD_EXTGALLERY_APPLET_LANG);
$xoopsTpl->assign('maxphotosize', $xoopsModuleConfig['max_photosize']);

if($xoopsModuleConfig['save_large'] || $xoopsModuleConfig['save_original']) {
 $xoopsTpl->assign('imageWidth', -1);
 $xoopsTpl->assign('imageHeight', -1);
} else {
 $xoopsTpl->assign('imageWidth', $xoopsModuleConfig['medium_width']);
 $xoopsTpl->assign('imageHeight', $xoopsModuleConfig['medium_heigth']);
}

include XOOPS_ROOT_PATH.'/footer.php';

?>