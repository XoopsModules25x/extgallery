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

require_once __DIR__   . '/header.php';
//require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';

/** @var Extgallery\Helper $helper */
$helper = Extgallery\Helper::getInstance();

$catId = \Xmf\Request::getInt('id', 0, 'GET');

$rate = \Xmf\Request::getInt('rate', 0, 'GET');

/** @var Extgallery\PublicPhotoHandler $photoHandler */
$photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
$photo        = $photoHandler->get($photoId);

$permHandler = Extgallery\PublicPermHandler::getInstance();
if ($helper->getConfig('enable_rating')
    && !$permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_rate', $photo->getVar('cat_id'))) {
    redirect_header('index.php', 3, _MD_EXTGALLERY_NOPERM);
}

$ratingHandler = Extgallery\Helper::getInstance()->getHandler('PublicRating');

if ($ratingHandler->rate($photoId, $rate)) {
    $rating = $ratingHandler->getRate($photoId);
    $photoHandler->modifyPhoto($photoId, ['photo_rating' => $rating]);

    redirect_header('public-photo.php?photoId=' . $photoId . '#photoNav', 3, _MD_EXTGALLERY_VOTE_THANKS);
} else {
    redirect_header('public-photo.php?photoId=' . $photoId . '#photoNav', 3, _MD_EXTGALLERY_ALREADY_VOTED);
}
