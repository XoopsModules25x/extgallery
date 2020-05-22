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

require_once __DIR__ . '/header.php';
//require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-slideshow.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

/** @var Extgallery\Helper $helper */
$helper = Extgallery\Helper::getInstance();

$catId = \Xmf\Request::getInt('id', 0, 'GET');

// Check the access permission
$permHandler = Extgallery\PublicPermHandler::getInstance();
if (!$permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_access', $catId)) {
    redirect_header('index.php', 3, _NOPERM);
}
/** @var Extgallery\CategoryHandler $catHandler */
$catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
/** @var Extgallery\PublicPhotoHandler $photoHandler */
$photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

$catObj = $catHandler->getCat($catId);

if (null === $catObj) {
    require_once XOOPS_ROOT_PATH . '/footer.php';
    exit;
}
$ajaxeffect = $helper->getConfig('use_slideshow_effects');
$xoopsTpl->assign('use_slideshow_effects', $ajaxeffect);

$cat = $catHandler->objectToArray($catObj);
$xoopsTpl->assign('cat', $cat);

$catPath = $photoHandler->objectToArray($catHandler->getPath($catId));
$xoopsTpl->assign('catPath', $catPath);

$photos = $photoHandler->getSlideshowAlbumPhoto($catId);
$xoopsTpl->assign('photos', $photos);
$xoopsTpl->assign('xoops_pagetitle', $catObj->getVar('cat_name'));
$xoTheme->addMeta('meta', 'description', $catObj->getVar('cat_desc'));

$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));

$rel                 = 'alternate';
$attributes['rel']   = $rel;
$attributes['type']  = 'application/rss+xml';
$attributes['title'] = _MD_EXTGALLERY_RSS;
$attributes['href']  = XOOPS_URL . '/modules/extgallery/public-rss.php';
$xoTheme->addMeta('link', $rel, $attributes);
$xoTheme->addStylesheet('modules/extgallery/assets/css/style.css');

$jquery = $helper->getConfig('enable_jquery');
$xoopsTpl->assign('jquery', $jquery);
if (1 == $jquery) {
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
    switch ($ajaxeffect) {
        case 'galleryview':
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleryview/galleryview.js');
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleryview/timers.js');
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleryview/easing.js');
            $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/galleryview/galleryview.css');
            break;
        case 'galleria':
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleria/galleria.js');
            break;
        case 'microgallery':
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/microgallery/jquery.microgallery.js');
            $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/microgallery/style.css');
            break;
        case 'galleriffic':
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleriffic/jquery.galleriffic.js');
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleriffic/jquery.history.js');
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleriffic/jquery.opacityrollover.js');
            $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/galleriffic/galleriffic2.css');
            break;
    }
}

$xoopsTpl->assign('show_rss', $helper->getConfig('show_rss'));

//for galleryview
$xoopsTpl->assign('galleryview_panelwidth', $helper->getConfig('galleryview_panelwidth'));
$xoopsTpl->assign('galleryview_panelheight', $helper->getConfig('galleryview_panelheight'));
$xoopsTpl->assign('galleryview_framewidth', $helper->getConfig('galleryview_framewidth'));
$xoopsTpl->assign('galleryview_frameheight', $helper->getConfig('galleryview_frameheight'));
$xoopsTpl->assign('galleryview_backgroundcolor', $helper->getConfig('galleryview_bgcolor'));
$xoopsTpl->assign('galleryview_transitionspeed', $helper->getConfig('galleryview_tspeed'));
$xoopsTpl->assign('galleryview_transitioninterval', $helper->getConfig('galleryview_tterval'));
$xoopsTpl->assign('galleryview_overlayheight', $helper->getConfig('galleryview_overlayheight'));
$xoopsTpl->assign('galleryview_overlaycolor', $helper->getConfig('galleryview_overlaycolor'));
$xoopsTpl->assign('galleryview_overlaytextcolor', $helper->getConfig('galleryview_overlaytc'));
$xoopsTpl->assign('galleryview_captiontextcolor', $helper->getConfig('galleryview_captiontc'));
$xoopsTpl->assign('galleryview_borderwidth', $helper->getConfig('galleryview_borderwidth'));
$xoopsTpl->assign('galleryview_bordercolor', $helper->getConfig('galleryview_bordercolor'));
$xoopsTpl->assign('galleryview_overlayopacity', $helper->getConfig('galleryview_opacity'));
$xoopsTpl->assign('galleryview_overlayfontsize', $helper->getConfig('galleryview_overlayfs'));
$xoopsTpl->assign('galleryview_navtheme', $helper->getConfig('galleryview_navtheme'));
$xoopsTpl->assign('galleryview_position', $helper->getConfig('galleryview_position'));
$xoopsTpl->assign('galleryview_easing', $helper->getConfig('galleryview_easing'));

//for galleria
$xoopsTpl->assign('galleria_height', $helper->getConfig('galleria_height'));
$xoopsTpl->assign('galleria_panelwidth', $helper->getConfig('galleria_panelwidth'));
$xoopsTpl->assign('galleria_bgcolor', $helper->getConfig('galleria_bgcolor'));
$xoopsTpl->assign('galleria_bcolor', $helper->getConfig('galleria_bcolor'));
$xoopsTpl->assign('galleria_bgimg', $helper->getConfig('galleria_bgimg'));
if (1 == $helper->getConfig('galleria_autoplay')) {
    $xoopsTpl->assign('galleria_autoplay', 'true');
} else {
    $xoopsTpl->assign('galleria_autoplay', 'false');
}
$xoopsTpl->assign('galleria_transition', $helper->getConfig('galleria_transition'));
$xoopsTpl->assign('galleria_tspeed', $helper->getConfig('galleria_tspeed'));

//for galleriffic
$xoopsTpl->assign('galleriffic_nb_thumbs', $helper->getConfig('galleriffic_nb_thumbs'));
$xoopsTpl->assign('galleriffic_nb_colthumbs', $helper->getConfig('galleriffic_nb_colthumbs'));
$xoopsTpl->assign('galleriffic_nb_preload', $helper->getConfig('galleriffic_nb_preload'));
if (1 == $helper->getConfig('galleriffic_autoplay')) {
    $xoopsTpl->assign('galleriffic_autoplay', 'true');
} else {
    $xoopsTpl->assign('galleriffic_autoplay', 'false');
}
$xoopsTpl->assign('galleriffic_tdelay', $helper->getConfig('galleriffic_tdelay'));
$xoopsTpl->assign('galleriffic_tspeed', $helper->getConfig('galleriffic_tspeed'));

$var_width       = 0;
$var_nav_width   = 0;
$var_nav_visible = 'hidden';

switch ($helper->getConfig('galleriffic_nb_colthumbs')) {
    case 1:
        $var_nav_width   = 130;
        $var_nav_visible = 'visible';
        break;
    case 2:
        $var_nav_width   = 200;
        $var_nav_visible = 'visible';
        break;
    case 3:
        $var_nav_width   = 280;
        $var_nav_visible = 'visible';
        break;
    case 'default':
        break;
}
$xoopsTpl->assign('nav_width', $var_nav_width);
$xoopsTpl->assign('nav_visibility', $var_nav_visible);
$xoopsTpl->assign('galleriffic_bordercolor', $helper->getConfig('galleriffic_bordercolor'));
$xoopsTpl->assign('galleriffic_bgcolor', $helper->getConfig('galleriffic_bgcolor'));
$xoopsTpl->assign('galleriffic_fontcolor', $helper->getConfig('galleriffic_fontcolor'));
$var_width = $helper->getConfig('galleriffic_width');
$xoopsTpl->assign('content_width', $var_width + 10);
$var_width = $helper->getConfig('galleriffic_width') + $var_nav_width + 100;
$xoopsTpl->assign('page_width', $var_width);

$xoopsTpl->assign('pic_height', $helper->getConfig('galleriffic_height'));
$xoopsTpl->assign('pic_width', $helper->getConfig('galleriffic_width'));
$xoopsTpl->assign('galleriffic_show_descr', $helper->getConfig('galleriffic_show_descr'));
$xoopsTpl->assign('galleriffic_download', $helper->getConfig('galleriffic_download'));

require_once XOOPS_ROOT_PATH . '/footer.php';
