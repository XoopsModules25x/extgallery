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
$moduleDirName = basename(__DIR__);

$GLOBALS['xoopsOption']['template_main'] = $moduleDirName . '_index.tpl';
include XOOPS_ROOT_PATH . '/header.php';

/** @var Extgallery\PublicCategoryHandler $catHandler */
$catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

$cats = $catHandler->objectToArray($catHandler->getChildren(0), ['photo_id']);
$xoopsTpl->assign('cats', $cats);

$rel                 = 'alternate';
$attributes['rel']   = $rel;
$attributes['type']  = 'application/rss+xml';
$attributes['title'] = _MD_EXTGALLERY_RSS;
$attributes['href']  = XOOPS_URL . '/modules/extgallery/public-rss.php';
/** @var \xos_opal_Theme $xoTheme */
$xoTheme->addMeta('link', $rel, $attributes);
$xoTheme->addStylesheet('modules/extgallery/assets/css/style.css');

$lang = [
    'categoriesAlbums' => _MD_EXTGALLERY_CATEGORIESALBUMS,
    'nbAlbums'         => _MD_EXTGALLERY_NBALBUMS,
    'nbPhotos'         => _MD_EXTGALLERY_NBPHOTOS
];
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));
$xoopsTpl->assign('disp_cat_img', $xoopsModuleConfig['disp_cat_img']);
$xoopsTpl->assign('display_type', $xoopsModuleConfig['display_type']);
$xoopsTpl->assign('show_rss', $xoopsModuleConfig['show_rss']);

// pk ------------------- add upload and view-my-album links to main page
if (null !== $GLOBALS['xoopsUser'] && is_object($GLOBALS['xoopsUser'])) {
    if (isset($GLOBALS['xoopsModule']) && $GLOBALS['xoopsModule']->getVar('dirname') == $moduleDirName) {
        if (null != $GLOBALS['xoopsUser']) {
            $albumlinkname = _MD_EXTGALLERY_USERALBUM;
            $albumurl      = 'public-useralbum.php?id=' . $GLOBALS['xoopsUser']->uid();
        }

//        require_once XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/publicPerm.php";

        $permHandler = Extgallery\PublicPermHandler::getInstance();
        if (count($permHandler->getAuthorizedPublicCat($GLOBALS['xoopsUser'], 'public_upload')) > 0) {
            $uploadlinkname = _MD_EXTGALLERY_PUBLIC_UPLOAD;
            if ('html' === $GLOBALS['xoopsModuleConfig']['use_extended_upload']) {
                $uploadurl = 'public-upload.php';
            } else {
                $uploadurl = 'public-upload-extended.php';
            }
        }
    }
}
$xoopsTpl->assign('albumlinkname', $albumlinkname);
$xoopsTpl->assign('albumurl', $albumurl);
if (isset($uploadlinkname)) {
    $xoopsTpl->assign('uploadlinkname', $uploadlinkname);
}
if (isset($uploadurl)) {
    $xoopsTpl->assign('uploadurl', $uploadurl);
}

// end pk mod ------------------------------

include XOOPS_ROOT_PATH . '/footer.php';
