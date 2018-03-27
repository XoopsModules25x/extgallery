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

//require_once __DIR__ . '/photoHandler.php';
//require_once __DIR__ . '/publicPerm.php';


/**
 * Class Extgallery\PublicPhotoHandler
 */
class PublicPhotoHandler extends Extgallery\PhotoHandler
{
    /**
     * Extgallery\PublicPhotoHandler constructor.
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'public');
    }

    /**
     * @param $photo
     */
    public function deleteFile(\XoopsObject $photo = null)
    {
        if (file_exists(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/thumb/thumb_' . $photo->getVar('photo_name'))) {
            unlink(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/thumb/thumb_' . $photo->getVar('photo_name'));
        }

        if (file_exists(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/medium/' . $photo->getVar('photo_name'))) {
            unlink(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/medium/' . $photo->getVar('photo_name'));
        }

        if (file_exists(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/large/large_' . $photo->getVar('photo_name'))) {
            unlink(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/large/large_' . $photo->getVar('photo_name'));
        }

        if ('' != $photo->getVar('photo_orig_name')
            && file_exists(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/original/' . $photo->getVar('photo_orig_name'))) {
            unlink(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/original/' . $photo->getVar('photo_orig_name'));
        }
    }

    /**
     * @return array|int|string
     */
    public function getAllSize()
    {
        return $this->getSum(null, 'photo_size');
    }

    /**
     * @return string
     */
    public function getUploadPhotoPath()
    {
        return XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/';
    }

    /**
     * @param $userId
     * @param $start
     * @param $sortby
     * @param $orderby
     *
     * @return array
     */
    public function getUserAlbumPhotoPage($userId, $start, $sortby, $orderby)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->add(new \Criteria('uid', $userId));
        $criteria->setSort($sortby);
        $criteria->setOrder($orderby);
        $criteria->setStart($start);
        $criteria->setLimit($GLOBALS['xoopsModuleConfig']['nb_column'] * $GLOBALS['xoopsModuleConfig']['nb_line']);

        return $this->getObjects($criteria);
    }

    /**
     * @param $userId
     * @param $photoDate
     *
     * @return array
     */
    public function getUserAlbumPrevPhoto($userId, $photoDate)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->add(new \Criteria('uid', $userId));
        $criteria->add(new \Criteria('photo_date', $photoDate, '>'));
        $criteria->setSort('photo_date');
        $criteria->setOrder('ASC');
        $criteria->setLimit(1);

        return $this->getObjects($criteria);
    }

    /**
     * @param $userId
     * @param $photoDate
     *
     * @return array
     */
    public function getUserAlbumNextPhoto($userId, $photoDate)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->add(new \Criteria('uid', $userId));
        $criteria->add(new \Criteria('photo_date', $photoDate, '<'));
        $criteria->setSort('photo_date');
        $criteria->setOrder('DESC');
        $criteria->setLimit(1);

        return $this->getObjects($criteria);
    }

    /**
     * @param $userId
     * @param $photoDate
     *
     * @return int
     */
    public function getUserAlbumCurrentPhotoPlace($userId, $photoDate)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->add(new \Criteria('uid', $userId));
        $criteria->add(new \Criteria('photo_date', $photoDate, '>='));
        $criteria->setSort('photo_date');
        $criteria->setOrder('ASC');

        return $this->getCount($criteria);
    }

    /**
     * @param $userId
     *
     * @return int
     */
    public function getUserAlbumCount($userId)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->add(new \Criteria('uid', $userId));

        return $this->getCount($criteria);
    }

    /**
     * @param $userId
     *
     * @return array
     */
    public function getUserPhotoAlbumId($userId)
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('uid', $userId));
        $criteria->add(new \Criteria('photo_approved', 1));

        $sql = 'SELECT photo_id FROM ' . $this->db->prefix('extgallery_publicphoto') . ' ' . $criteria->renderWhere() . ' ORDER BY photo_date, photo_id DESC;';

        $result = $this->db->query($sql);
        $ret    = [];
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $ret[] = $myrow['photo_id'];
        }

        return $ret;
    }
}
