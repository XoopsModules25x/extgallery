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
 * @version     $Id: hook-photo.php 8088 2011-11-06 09:38:12Z beckmi $
 */

use XoopsModules\Extgallery;

require_once __DIR__ . '/header.php';
require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';

$photoId = \Xmf\Request::getInt('id', 0, 'GET');

/** @var Extgallery\PublicPhotoHandler $photoHandler */
/** @var Extgallery\Photo $photo */
$photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
$photoHandler->updateHits($photoId);
$photo = $photoHandler->get($photoId);

switch (mb_strtolower(mb_strrchr($photo->getVar('photo_name'), '.'))) {
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

$permHandler = Extgallery\PublicPermHandler::getInstance();

// If require_once image don't exist
if (0 == $photo->getVar('cat_id')) {
    header('Content-type: image/jpeg');
    readfile(XOOPS_ROOT_PATH . '/modules/extgallery/assets/images/dont-exist.jpg');

    // If user is allowed to view this picture
} elseif ($permHandler->isAllowed($xoopsUser, 'public_access', $photo->getVar('cat_id'))) {
    $photo = $photoHandler->objectToArray($photo);
    header('Content-type: ' . $type . '');
    readfile(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/medium/' . $photo['photo_name']);

    // If user isn't allowed to view this picture
} else {
    header('Content-type: image/jpeg');
    readfile(XOOPS_ROOT_PATH . '/modules/extgallery/assets/images/not-allowed.jpg');
}
