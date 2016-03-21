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
 * @version     $Id: public-download.php 8088 2011-11-06 09:38:12Z beckmi $
 */

require dirname(dirname(__DIR__)) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';

if (!isset($_GET['id'])) {
    $photoId = 0;
} else {
    $photoId = (int)$_GET['id'];
}

$photoHandler = xoops_getModuleHandler('publicphoto', 'extgallery');
$photo        = $photoHandler->get($photoId);

$permHandler = ExtgalleryPublicPermHandler::getHandler();
if (!$permHandler->isAllowed($xoopsUser, 'public_download', $photo->getVar('cat_id'))) {
    redirect_header('index.php');
    exit;
}

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
    case '.jpeg':
        $type = 'image/jpeg';
        break;
    default:
        $type = 'application/octet-stream';
        break;
}

header('Content-Type: ' . $type . '');
header("Content-Disposition: attachment; filename=\"" . $photo->getVar('photo_name') . "\"");

//if ($photo->getVar('photo_havelarge')) {
//    if ($permHandler->isAllowed($xoopsUser, 'public_download_original', $photo->getVar('cat_id')) && $photo->getVar('photo_orig_name') != "") {
//        $photoName = "original/".$photo->getVar('photo_orig_name');
//    } else {
//        $photoName = "large/large_".$photo->getVar('photo_name');
//    }
//} else {
//    $photoName = "medium/".$photo->getVar('photo_name');
//}

if ($permHandler->isAllowed($xoopsUser, 'public_download_original', $photo->getVar('cat_id')) && $photo->getVar('photo_orig_name') != '') {
    $photoName = 'original/' . $photo->getVar('photo_orig_name');
} else {
    if ($photo->getVar('photo_havelarge')) {
        $photoName = 'large/large_' . $photo->getVar('photo_name');
    } else {
        $photoName = 'medium/' . $photo->getVar('photo_name');
    }
}

$photoHandler->updateDownload($photoId);

if ($photo->getVar('photo_serveur') == '') {
    readfile(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/' . $photoName);
} else {
    readfile($photo->getVar('photo_serveur') . $photoName);
}
