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

include __DIR__ . '/header.php';
include_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';

if (!isset($_GET['id'])) {
    $photoId = 0;
} else {
    $photoId = (int)$_GET['id'];
}
/** @var ExtgalleryPhotoHandler $photoHandler */
$photoHandler = xoops_getModuleHandler('publicphoto', 'extgallery');
$photoHandler->updateHits($photoId);
$photo = $photoHandler->get($photoId);

switch (strtolower(strrchr($photo->getVar('photo_name'), '.'))) {
    case '.png':
        $type = 'image/png';
        break;
    case '.gif':
        $type = 'image/gif';
        break;
    case '.jpg':
        $type = 'image/jpeg';
        break;
    default:
        $type = 'application/octet-stream';
        break;
}

$permHandler = ExtgalleryPublicPermHandler::getInstance();

// If require image don't exist
if ($photo->getVar('cat_id') == 0) {
    header('Content-type: image/jpeg');
    readfile(__DIR__ . '/assets/images/dont-exist.jpg');

    // If user is allowed to view this picture
} elseif ($permHandler->isAllowed($xoopsUser, 'public_access', $photo->getVar('cat_id'))) {
    $photo = $photoHandler->objectToArray($photo);
    header('Content - type: ' . $type . '');
    readfile(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/ medium/' . $photo['photo_name']);

    // If user isn't allowed to view this picture
} else {
    header('Content-type: image/jpeg');
    readfile(__DIR__ . '/assets/images/not-allowed.jpg');
}
