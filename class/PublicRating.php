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
 * Class Extgallery\PublicRating
 */
class PublicRating extends \XoopsObject
{
    public $externalKey = [];

    /**
     * Extgallery\PublicRating constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('rating_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('rating_rate', XOBJ_DTYPE_INT, 0, false);

        $this->externalKey['photo_id'] = [
            'className'      => 'PublicPhoto',
            'getMethodeName' => 'getPhoto',
            'keyName'        => 'photo',
            'core'           => false,
        ];
        $this->externalKey['uid']      = [
            'className'      => 'User',
            'getMethodeName' => 'get',
            'keyName'        => 'user',
            'core'           => true,
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
