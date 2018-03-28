<?php
/**
 * ExtGallery functions
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

// defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * @param $photoId
 * @param $nbCom
 */
function extgalleryComUpdate($photoId, $nbCom)
{
    /** @var Extgallery\PhotoHandler $photoHandler */
    $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
    $photoHandler->modifyPhoto($photoId, ['photo_comment' => $nbCom]);
}
