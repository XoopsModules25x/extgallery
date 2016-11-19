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
/** @var ExtgalleryPublicPhotoHandler $photoHandler */
$photoHandler = xoops_getModuleHandler('publicphoto', 'extgallery');

$result = $photoHandler->postPhotoTraitement('File0');

if ($result == 2) {
    echo 'ERROR: ' . _MD_EXTGALLERY_NOT_AN_ALBUM;
} elseif ($result == 4 || $result == 5) {
    echo 'ERROR: ' . $photoHandler->photoUploader->getError();
} elseif ($result == 0) {
    echo "SUCCESS\n";
} elseif ($result == 1) {
    echo "SUCCESS\n";
}
