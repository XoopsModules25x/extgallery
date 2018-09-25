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
 * Class Extgallery\QuotaHandler
 */
class QuotaHandler extends Extgallery\PersistableObjectHandler
{
    /**
     * Extgallery\QuotaHandler constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        parent::__construct($db, 'extgallery_quota', 'Extgallery\Quota', 'quota_id');
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
        $criteria = new \Criteria('quota_name', 'private');

        return $this->deleteAll($criteria);
    }

    /**
     * @param $groupid
     * @param $quotaName
     *
     * @return \XoopsObject
     */
    public function getQuota($groupid, $quotaName)
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('groupid', $groupid));
        $criteria->add(new \Criteria('quota_name', $quotaName));
        $ret = $this->getObjects($criteria);
        if (empty($ret)) {
            return $this->create();
        } else {
            return $ret[0];
        }
    }
}
