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
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
//require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';

/** @var Extgallery\Helper $helper */
$helper = Extgallery\Helper::getInstance();

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-album.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

if (!isset($_GET['id'])) {
    $catId = 0;
} else {
    $catId = \Xmf\Request::getInt('id', 0, 'GET');
}
if (!isset($_GET['start'])) {
    $start = 0;
} else {
    $start = \Xmf\Request::getInt('start', 0, 'GET');
}

// HACK BLUETEEN TO SORT PHOTO BY USERS
//photo_date - photo_title - photo_hits - photo_rating
if (\Xmf\Request::hasVar('sortby', 'GET')
    && ('photo_date' === $_GET['sortby']
        || 'photo_title' === $_GET['sortby']
        || 'photo_hits' === $_GET['sortby']
        || 'photo_rating' === $_GET['sortby'])) {
    $sortby = $_GET['sortby'];
} else {
    $sortby = 'photo_date';
}

//ASC ou DESC
if (\Xmf\Request::hasVar('orderby', 'GET') && ('DESC' === $_GET['orderby'] || 'ASC' === $_GET['orderby'])) {
    $orderby = $_GET['orderby'];
} else {
    $orderby = $GLOBALS['xoopsModuleConfig']['display_set_order'];
}

$SortbyOrderby = $sortby . ' ' . $orderby;

/**
 * @param $SortbyOrderby
 *
 * @return array|string
 */
function convertorderbytrans($SortbyOrderby)
{
    $orderbyTrans = [];
    if ('photo_date DESC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_DATEASC;
    }
    if ('photo_date ASC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_DATEDESC;
    }
    if ('photo_title ASC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_TITREASC;
    }
    if ('photo_title DESC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_TITREDESC;
    }
    if ('uid ASC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_DESIGNERASC;
    }
    if ('uid DESC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_DESIGNERDESC;
    }
    if ('photo_hits DESC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_HITSASC;
    }
    if ('photo_hits ASC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_HITSDESC;
    }
    if ('photo_rating DESC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_NOTEASC;
    }
    if ('photo_rating ASC' === $SortbyOrderby) {
        $orderbyTrans = _MD_EXTGALLERY_ORDERBY_NOTEDESC;
    }

    return $orderbyTrans;
}

// Check the access permission
$permHandler = Extgallery\PublicPermHandler::getInstance();
if ((null === $GLOBALS['xoopsUser'] || !is_object($GLOBALS['xoopsUser'])) || !$permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_access', $catId)) {
    redirect_header('index.php', 3, _NOPERM);
}
/** @var Extgallery\PublicCategoryHandler $catHandler */
$catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
/** @var Extgallery\PublicPhotoHandler $photoHandler */
$photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

$catObj = $catHandler->getCat($catId);

if (null === $catObj) {
    require_once XOOPS_ROOT_PATH . '/footer.php';
    exit;
}

$ajaxeffect = $helper->getConfig('use_ajax_effects');
$xoopsTpl->assign('use_ajax_effects', $ajaxeffect);

$cat = $catHandler->objectToArray($catObj);
$xoopsTpl->assign('cat', $cat);

$catPath = $photoHandler->objectToArray($catHandler->getPath($catId));
$xoopsTpl->assign('catPath', $catPath);

$photos = $photoHandler->objectToArray($photoHandler->getAlbumPhotoPage($catId, $start, $sortby, $orderby), ['uid']); //xoops - blueteen - tri de l'affichage

// Plugin traitement
$plugin  = Extgallery\Helper::getInstance()->getHandler('Plugin');
$nbPhoto = count($photos);
foreach ($photos as $i => $iValue) {
    $params = ['catId' => $catId, 'photoId' => $photos[$i]['photo_id'], 'link' => []];
    $plugin->triggerEvent('photoAlbumLink', $params);
    $photos[$i]['link'] = $params['link'];
}

$k = $helper->getConfig('nb_column') - (count($photos) % $helper->getConfig('nb_column'));
if ($k != $helper->getConfig('nb_column')) {
    for ($i = 0; $i < $k; ++$i) {
        $photos[] = [];
    }
}

// HACK DATE BY MAGE : DISPLAY PUBLICATION DATE
foreach (array_keys($photos) as $i) {
    if (isset($photos[$i]['photo_date'])) {
        $photos[$i]['photo_date'] = date(_SHORTDATESTRING, $photos[$i]['photo_date']);
    }
}
// END HACK DATE BY MAGE : DISPLAY PUBLICATION DATE

$xoopsTpl->assign('photos', $photos);
/** @var xos_opal_Theme $xoTheme */
$pageNav = new \XoopsPageNav($photoHandler->getAlbumCount($catId), $helper->getConfig('nb_column') * $helper->getConfig('nb_line'), $start, 'start', 'id=' . $catId . '&orderby=' . $orderby . '&sortby=' . $sortby); //xoops - blueteen - tri de l'affichage
$xoopsTpl->assign('pageNav', $pageNav->renderNav());
if (isset($catObj)) {
    $xoopsTpl->assign('xoops_pagetitle', $catObj->getVar('cat_name'));
    $xoTheme->addMeta('meta', 'description', $catObj->getVar('cat_desc'));
}

$jquery = $helper->getConfig('enable_jquery');
$xoopsTpl->assign('jquery', $jquery);
if (1 == $jquery && 'none' !== $ajaxeffect) {
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
    switch ($ajaxeffect) {
        case 'lightbox':
            $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.lightbox.js');
            $xoTheme->addStylesheet('browse.php?modules/system/css/lightbox.css');

            break;
        case 'tooltip':
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/tooltip/image.tooltip.js');
            $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/tooltip/image.tooltip.css');

            break;
        case 'overlay':
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/overlay/overlay.jquery.tools.min.js');
            $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/overlay/overlay.css');

            break;
        case 'fancybox':
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/fancybox/mousewheel.js');
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/fancybox/fancybox.pack.js');
            $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/fancybox/fancybox.css');

            break;
        case 'prettyphoto':
            $xoTheme->addScript('browse.php?modules/extgallery/assets/js/prettyphoto/jquery.prettyPhoto.js');
            $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/prettyphoto/prettyPhoto.css');

            break;
    }
}

$rel                 = 'alternate';
$attributes['rel']   = $rel;
$attributes['type']  = 'application/rss+xml';
$attributes['title'] = _MD_EXTGALLERY_RSS;
$attributes['href']  = XOOPS_URL . '/modules/extgallery/public-rss.php';
$xoTheme->addMeta('link', $rel, $attributes);
$xoTheme->addStylesheet('modules/extgallery/assets/css/style.css');

$lang = [
    'hits'       => _MD_EXTGALLERY_HITS,
    'comments'   => _MD_EXTGALLERY_COMMENTS,
    'rate_score' => _MD_EXTGALLERY_RATING_SCORE,
];
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('enableExtra', $helper->getConfig('display_extra_field'));
$xoopsTpl->assign('enableRating', $helper->getConfig('enable_rating'));
$xoopsTpl->assign('nbColumn', $helper->getConfig('nb_column'));
$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));
$xoopsTpl->assign('disp_ph_title', $helper->getConfig('disp_ph_title'));

$xoopsTpl->assign('extgalleryID', $catId); //xoops - blueteen - tri de l'affichage
$xoopsTpl->assign('extgalleryStart', $start); //xoops -blueteen - tri de l'affichage
$xoopsTpl->assign('extgallerySortbyOrderby', _MD_EXTGALLERY_ORDERBY . convertorderbytrans($SortbyOrderby)); //xoops - blueteen - tri de l'affichage

//DNPROSSI - VOLTAN - added preferences option
//  enable_info, enable_submitter_lnk, enable_photo_hits
if ('album' === $helper->getConfig('info_view') || 'both' === $helper->getConfig('info_view')) {
    if ('public' === $helper->getConfig('pubusr_info_view') || 'both' === $helper->getConfig('pubusr_info_view')) {
        if (0 == $helper->getConfig('enable_info')) {
            $enable_info = $helper->getConfig('enable_info');
        } else {
            $enable_info = 1;
        }
    } else {
        $enable_info = 1;
    }
} else {
    $enable_info = 1;
}
$xoopsTpl->assign('enable_info', $enable_info);
$xoopsTpl->assign('enable_photo_hits', $helper->getConfig('enable_photo_hits'));
$xoopsTpl->assign('enable_submitter_lnk', $helper->getConfig('enable_submitter_lnk'));
$xoopsTpl->assign('enable_show_comments', $helper->getConfig('enable_show_comments'));
$xoopsTpl->assign('enable_date', $helper->getConfig('enable_date'));
$xoopsTpl->assign('show_rss', $helper->getConfig('show_rss'));

//for tooltip
$xoopsTpl->assign('album_tooltip_borderwidth', $helper->getConfig('album_tooltip_borderwidth'));
$xoopsTpl->assign('album_tooltip_bordercolor', $helper->getConfig('album_tooltip_bordercolor'));
$xoopsTpl->assign('album_tooltip_width', $helper->getConfig('album_tooltip_width'));

//for overlay
$xoopsTpl->assign('album_overlay_bg', $helper->getConfig('album_overlay_bg'));
$xoopsTpl->assign('album_overlay_width', $helper->getConfig('album_overlay_width'));
$xoopsTpl->assign('album_overlay_height', $helper->getConfig('album_overlay_height'));

//for fancybox
$xoopsTpl->assign('album_fancybox_color', $helper->getConfig('album_fancybox_color'));
$xoopsTpl->assign('album_fancybox_opacity', $helper->getConfig('album_fancybox_opacity'));
$xoopsTpl->assign('album_fancybox_tin', $helper->getConfig('album_fancybox_tin'));
$xoopsTpl->assign('album_fancybox_tout', $helper->getConfig('album_fancybox_tout'));
$xoopsTpl->assign('album_fancybox_title', $helper->getConfig('album_fancybox_title'));
$xoopsTpl->assign('album_fancybox_showtype', $helper->getConfig('album_fancybox_showtype'));

//for prettyphoto
$xoopsTpl->assign('album_prettyphoto_speed', $helper->getConfig('album_prettyphoto_speed'));
$xoopsTpl->assign('album_prettyphoto_theme', $helper->getConfig('album_prettyphoto_theme'));
$xoopsTpl->assign('album_prettyphoto_slidspeed', $helper->getConfig('album_prettyphoto_slidspe'));
$xoopsTpl->assign('album_prettyphoto_autoplay', $helper->getConfig('album_prettyphoto_autopla'));

require_once XOOPS_ROOT_PATH . '/footer.php';
