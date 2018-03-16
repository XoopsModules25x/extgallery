<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author       XOOPS Development Team,
 */

// defined('XOOPS_ROOT_PATH') || die('Restricted access');

use XoopsModules\Extgallery;

/**
 * @param $category
 * @param $item_id
 *
 * @return mixed
 */
function extgalleryNotifyIteminfo($category, $item_id)
{
    /** @var Extgallery\PublicPhotoHandler $photoHandler */
    $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
    $photo        = $photoHandler->getPhoto($item_id);
    $item['name'] = $photo->getVar('photo_desc');
    $item['url']  = XOOPS_URL . '/modules/extgallery/public-album.php?id=' . $photo->getVar('photo_id');

    return $item;
}
