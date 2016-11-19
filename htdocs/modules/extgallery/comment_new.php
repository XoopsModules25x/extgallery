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

include __DIR__ . '/../../mainfile.php';

$com_itemid = isset($_GET['com_itemid']) ? (int)$_GET['com_itemid'] : 0;
if ($com_itemid > 0) {
    /** @var ExtgalleryPhotoHandler $photoHandler */
    $photoHandler = xoops_getModuleHandler('publicphoto', 'extgallery');
    /** @var ExtgalleryPhoto $photo */
    $photo = $photoHandler->getPhoto($com_itemid);
    if ($photo->getVar('photo_title')) {
        $title = $photo->getVar('photo_title');
    } else {
        $title = $photo->getVar('photo_desc');
    }
    $com_replytitle = $title;
    include_once XOOPS_ROOT_PATH . '/include/comment_new.php';
}
