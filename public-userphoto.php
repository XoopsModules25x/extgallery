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

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-userphoto.tpl';
include XOOPS_ROOT_PATH . '/header.php';

if (!isset($_GET['photoId'])) {
    $photoId = 0;
} else {
    $photoId = (int)$_GET['photoId'];
}
/** @var Extgallery\CategoryHandler $catHandler */
$catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
/** @var Extgallery\PublicPhotoHandler $photoHandler */
$photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
/** @var Extgallery\PublicRatingHandler $ratingHandler */
$ratingHandler = Extgallery\Helper::getInstance()->getHandler('PublicRating');
$permHandler   = Extgallery\PublicPermHandler::getInstance();

$photoObj = $photoHandler->getPhoto($photoId);

// Check is the photo exist
if (!$photoObj) {
    redirect_header('index.php', 3, _NOPERM);
}

$photo = $photoHandler->objectToArray($photoObj, ['cat_id', 'uid']);

// Check the category access permission
$permHandler = Extgallery\PublicPermHandler::getInstance();
if (!$permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_access', $photo['cat']['cat_id'])) {
    redirect_header('index.php', 3, _NOPERM);
}

// Don't update counter if user come from rating page
if (isset($_SERVER['HTTP_REFERER']) && basename($_SERVER['HTTP_REFERER']) != 'public-rating.php?photoId=' . $photoId) {
    $photoHandler->updateHits($photoId);
}

$photo['photo_date'] = date(_MEDIUMDATESTRING, $photo['photo_date']);
$xoopsTpl->assign('photo', $photo);

$photosIds = $photoHandler->getUserPhotoAlbumId($photoObj->getVar('uid'));

$nbPhoto           = count($photosIds);
$currentPhotoPlace = array_search($photoId, $photosIds);

if (1 == $nbPhoto) {
    $prev = 0;
    $next = 0;
} elseif (0 == $currentPhotoPlace) {
    $prev = 0;
    $next = $photosIds[$currentPhotoPlace + 1];
} elseif (($currentPhotoPlace + 1) == $nbPhoto) {
    $prev = $photosIds[$currentPhotoPlace - 1];
    $next = 0;
} else {
    $prev = $photosIds[$currentPhotoPlace - 1];
    $next = $photosIds[$currentPhotoPlace + 1];
}
$xoopsTpl->assign('prevId', $prev);
$xoopsTpl->assign('nextId', $next);
$xoopsTpl->assign('currentPhoto', $currentPhotoPlace + 1);
$xoopsTpl->assign('totalPhoto', $nbPhoto);

$albumName = $photo['user']['uname'] . _MD_EXTGALLERY_USERS_SUB_PHOTO_ALBUM;
$xoopsTpl->assign('xoops_pagetitle', $photo['photo_title'] . ' - ' . $albumName);
$xoTheme->addMeta('meta', 'description', $photo['photo_title'] . ' - ' . $albumName);

$rel                 = 'alternate';
$attributes['rel']   = $rel;
$attributes['type']  = 'application/rss+xml';
$attributes['title'] = _MD_EXTGALLERY_RSS;
$attributes['href']  = XOOPS_URL . '/modules/extgallery/public-rss.php';
$xoTheme->addMeta('link', $rel, $attributes);
$xoTheme->addStylesheet('modules/extgallery/assets/css/style.css');

$xoopsTpl->assign('rating', $ratingHandler->getRate($photoId));

$lang = [
    'preview'      => _MD_EXTGALLERY_PREVIEW,
    'next'         => _MD_EXTGALLERY_NEXT,
    'of'           => _MD_EXTGALLERY_OF,
    'voteFor'      => _MD_EXTGALLERY_VOTE_FOR_THIS_PHOTO,
    'photoInfo'    => _MD_EXTGALLERY_PHOTO_INFORMATION,
    'resolution'   => _MD_EXTGALLERY_RESOLUTION,
    'pixels'       => _MD_EXTGALLERY_PIXELS,
    'view'         => _MD_EXTGALLERY_VIEW,
    'hits'         => _MD_EXTGALLERY_HITS,
    'fileSize'     => _MD_EXTGALLERY_FILE_SIZE,
    'added'        => _MD_EXTGALLERY_ADDED,
    'score'        => _MD_EXTGALLERY_SCORE,
    'votes'        => _MD_EXTGALLERY_VOTES,
    'downloadOrig' => _MD_EXTGALLERY_DOWNLOAD_ORIG,
    'donwloads'    => _MD_EXTGALLERY_DOWNLOADS,
    'sendEcard'    => _MD_EXTGALLERY_SEND_ECARD,
    'sends'        => _MD_EXTGALLERY_SENDS,
    'submitter'    => _MD_EXTGALLERY_SUBMITTER,
    'allPhotoBy'   => _MD_EXTGALLERY_ALL_PHOTO_BY,
    'albumName'    => $albumName
];
$xoopsTpl->assign('lang', $lang);

if ($xoopsModuleConfig['enable_rating']) {
    $xoopsTpl->assign('canRate', $permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_rate', $cat['cat_id']));
} else {
    $xoopsTpl->assign('canRate', false);
    //DNPROSSI - added preferences option - enable_rating
    $xoopsTpl->assign('enable_rating', $xoopsModuleConfig['enable_rating']);
}

//DNPROSSI - added preferences option
//  enable_info, enable_resolution, enable_download, enable_date
//  enable_ecards, enable_submitter_lnk, enable_photo_hits
if ('photo' === $xoopsModuleConfig['info_view'] || 'both' === $xoopsModuleConfig['info_view']) {
    if ('user' === $xoopsModuleConfig['pubusr_info_view'] || 'both' === $xoopsModuleConfig['pubusr_info_view']) {
        if (0 == $xoopsModuleConfig['enable_info']) {
            $enable_info = $xoopsModuleConfig['enable_info'];
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
$xoopsTpl->assign('enable_resolution', $xoopsModuleConfig['enable_resolution']);
$xoopsTpl->assign('enable_download', $xoopsModuleConfig['enable_download']);
$xoopsTpl->assign('enable_date', $xoopsModuleConfig['enable_date']);
$xoopsTpl->assign('enable_ecards', $xoopsModuleConfig['enable_ecards']);
$xoopsTpl->assign('enable_submitter_lnk', $xoopsModuleConfig['enable_submitter_lnk']);
$xoopsTpl->assign('enable_photo_hits', $xoopsModuleConfig['enable_photo_hits']);

$xoopsTpl->assign('enableExtra', $xoopsModuleConfig['display_extra_field']);
$xoopsTpl->assign('canSendEcard', $permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_ecard', $photo['cat']['cat_id']));
$xoopsTpl->assign('canDownload', $permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_download', $photo['cat']['cat_id']));

$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));
$xoopsTpl->assign('disp_ph_title', $xoopsModuleConfig['disp_ph_title']);
$xoopsTpl->assign('show_rss', $xoopsModuleConfig['show_rss']);

// For xoops tag
if ((1 == $xoopsModuleConfig['usetag']) && is_dir('../tag')) {
    require_once XOOPS_ROOT_PATH . '/modules/tag/include/tagbar.php';
    $xoopsTpl->assign('tagbar', tagBar($photo['photo_id'], $catid = 0));
    $xoopsTpl->assign('tags', true);
} else {
    $xoopsTpl->assign('tags', false);
}

include XOOPS_ROOT_PATH . '/include/comment_view.php';
include XOOPS_ROOT_PATH . '/footer.php';
