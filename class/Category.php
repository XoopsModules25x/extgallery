<?php namespace XoopsModules\Extgallery;

/**
 * ExtGallery Class Manager
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
 * Class Extgallery\Category
 */
class Category extends \XoopsObject
{
    public $externalKey = [];

    /**
     * Extgallery\Category constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('cat_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('cat_pid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('nleft', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('nright', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('nlevel', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('cat_name', XOBJ_DTYPE_TXTBOX, '', true, 255);
        $this->initVar('cat_desc', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('cat_date', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cat_isalbum', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('cat_weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('cat_nb_album', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('cat_nb_photo', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('cat_imgurl', XOBJ_DTYPE_URL, '', false, 150);
        $this->initVar('photo_id', XOBJ_DTYPE_INT, 0, false);

        $this->externalKey['photo_id'] = [
            'className'      => 'PublicPhoto',
            'getMethodeName' => 'getPhoto',
            'keyName'        => 'photo',
            'core'           => false
        ];
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getExternalKey($key)
    {
        return $this->externalKey[$key];
    }
}
