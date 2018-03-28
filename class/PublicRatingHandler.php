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
            'core'           => false
        ];
        $this->externalKey['uid']      = [
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

/**
 * Class Extgallery\PublicRatingHandler
 */
class PublicRatingHandler extends Extgallery\PersistableObjectHandler
{
    /**
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'extgallery_publicrating', 'PublicRating', 'rating_id');
    }

    /**
     * @param $photoId
     * @param $rating
     *
     * @return bool
     */
    public function rate($photoId, $rating)
    {
        /** @var Extgallery\PublicPhotoHandler $photoHandler */
        $photoHandler = xoops_getModuleHandler('publicphoto', 'extgallery');

        $userId = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
        $rate   = $this->create();
        $rate->assignVar('photo_id', $photoId);
        $rate->assignVar('uid', $userId);
        $rate->assignVar('rating_rate', $rating);

        if ($this->hasRated($rate)) {
            return false;
        }

        if (!$this->insert($rate, true)) {
            return false;
        }

        return $photoHandler->updateNbRating($photoId);
    }

    /**
     * @param $photoId
     *
     * @return float
     */
    public function getRate($photoId)
    {
        $criteria = new \Criteria('photo_id', $photoId);
        $avg      = $this->getAvg($criteria, 'rating_rate');

        return round($avg);
    }

    /**
     * @param $rate
     *
     * @return bool
     */
    public function hasRated(&$rate)
    {
        // If the user is annonymous
        if (0 == $rate->getVar('uid')) {
            return false;
        }

        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('photo_id', $rate->getVar('photo_id')));
        $criteria->add(new \Criteria('uid', $rate->getVar('uid')));

        return $this->getCount($criteria) > 0;
    }
}
