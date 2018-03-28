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

//require_once __DIR__ . '/publicPerm.php';
//require_once __DIR__ . '/Extgallery\PersistableObjectHandler.php';

/**
 * Class Extgallery\Photo
 */
class Photo extends \XoopsObject
{
    public $externalKey = [];

    /**
     * Extgallery\Photo constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('photo_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cat_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_title', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('photo_desc', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('photo_serveur', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('photo_name', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('photo_orig_name', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_size', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_res_x', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_res_y', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_hits', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_comment', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_rating', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_nbrating', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_download', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_ecard', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_date', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_havelarge', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_approved', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_extra', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('photo_weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 0, false);

        $this->externalKey['cat_id'] = [
            'className'      => 'PublicCategory',
            'getMethodeName' => 'getCat',
            'keyName'        => 'cat',
            'core'           => false
        ];
        $this->externalKey['uid']    = [
            'className'      => 'User',
            'getMethodeName' => 'get',
            'keyName'        => 'user',
            'core'           => true
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
