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
 * @copyright   {@link https://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */

use XoopsModules\Extgallery;

include __DIR__ . '/header.php';
//require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-upload-applet.tpl';
include XOOPS_ROOT_PATH . '/header.php';

$permHandler = Extgallery\PublicPermHandler::getInstance();
if (count($permHandler->getAuthorizedPublicCat($GLOBALS['xoopsUser'], 'public_upload')) < 1) {
    redirect_header('index.php', 3, _MD_EXTGALLERY_NOPERM);
}

//echo "<pre>";print_r($xoopsModuleConfig);echo "</pre>";
$_SESSION['juvar.tmpsize'] = 0;
$catHandler                = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

$xoopsTpl->assign('categorySelect', $catHandler->getLeafSelect('cat_id', false, 0, '', 'public_upload'));
$xoopsTpl->assign('imageQuality', $xoopsModuleConfig['medium_quality'] / 100);
$xoopsTpl->assign('appletLang', _MD_EXTGALLERY_APPLET_LANG);
$xoopsTpl->assign('maxphotosize', $xoopsModuleConfig['max_photosize']);

if ($xoopsModuleConfig['save_large'] || $xoopsModuleConfig['save_original']) {
    $xoopsTpl->assign('imageWidth', -1);
    $xoopsTpl->assign('imageHeight', -1);
} else {
    $xoopsTpl->assign('imageWidth', $xoopsModuleConfig['medium_width']);
    $xoopsTpl->assign('imageHeight', $xoopsModuleConfig['medium_heigth']);
}

include XOOPS_ROOT_PATH . '/footer.php';
