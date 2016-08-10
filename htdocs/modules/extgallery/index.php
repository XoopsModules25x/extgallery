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
 * @copyright   {@link http://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */

require dirname(dirname(__DIR__)) . '/mainfile.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_index.tpl';
include XOOPS_ROOT_PATH . '/header.php';

/** @var ExtgalleryPubliccatHandler $catHandler*/
$catHandler = xoops_getModuleHandler('publiccat', 'extgallery');

$cats = $catHandler->objectToArray($catHandler->getChildren(0), array('photo_id'));
$xoopsTpl->assign('cats', $cats);

$rel                 = 'alternate';
$attributes['rel']   = $rel;
$attributes['type']  = 'application/rss+xml';
$attributes['title'] = _MD_EXTGALLERY_RSS;
$attributes['href']  = XOOPS_URL . '/modules/extgallery/public-rss.php';
$xoTheme->addMeta('link', $rel, $attributes);
$xoTheme->addStylesheet('modules/extgallery/assets/css/style.css');

$lang = array(
    'categoriesAlbums' => _MD_EXTGALLERY_CATEGORIESALBUMS,
    'nbAlbums'         => _MD_EXTGALLERY_NBALBUMS,
    'nbPhotos'         => _MD_EXTGALLERY_NBPHOTOS
);
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));
$xoopsTpl->assign('disp_cat_img', $xoopsModuleConfig['disp_cat_img']);
$xoopsTpl->assign('display_type', $xoopsModuleConfig['display_type']);
$xoopsTpl->assign('show_rss', $xoopsModuleConfig['show_rss']);

include XOOPS_ROOT_PATH . '/footer.php';
