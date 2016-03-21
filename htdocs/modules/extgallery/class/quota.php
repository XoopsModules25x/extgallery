<?php
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
 * @copyright   {@link http://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 * @version     $Id: quota.php 8088 2011-11-06 09:38:12Z beckmi $
 */

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once 'ExtgalleryPersistableObjectHandler.php';

/**
 * Class ExtgalleryQuota
 */
class ExtgalleryQuota extends XoopsObject
{
    public $externalKey = array();

    /**
     * ExtgalleryQuota constructor.
     */
    public function __construct()
    {
        $this->initVar('quota_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('groupid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('quota_name', XOBJ_DTYPE_TXTBOX, 0, false);
        $this->initVar('quota_value', XOBJ_DTYPE_INT, 0, false);
    }

    /**
     * @return array
     */
    public function getExternalKey()
    {
        return $this->externalKey;
    }
}

/**
 * Class ExtgalleryQuotaHandler
 */
class ExtgalleryQuotaHandler extends ExtgalleryPersistableObjectHandler
{
    /**
     * @param $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'extgallery_quota', 'ExtgalleryQuota', 'quota_id');
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function createQuota($data)
    {
        $quota = $this->create();
        $quota->setVars($data);

        return $this->insert($quota, true);
    }

    /**
     * @return bool
     */
    public function deleteQuota()
    {
        $criteria = new Criteria('quota_name', 'private');

        return $this->deleteAll($criteria);
    }

    /**
     * @param $groupid
     * @param $quotaName
     *
     * @return object
     */
    public function getQuota($groupid, $quotaName)
    {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('groupid', $groupid));
        $criteria->add(new Criteria('quota_name', $quotaName));
        $ret =& $this->getObjects($criteria);
        if (empty($ret)) {
            return $this->create();
        } else {
            return $ret[0];
        }
    }
}
