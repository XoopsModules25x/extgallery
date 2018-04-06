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
 * Class Extgallery\PublicCategoryHandler
 */
class PublicCategoryHandler extends Extgallery\CategoryHandler
{
    /**
     * Extgallery\PublicCategoryHandler constructor.
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'public');
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function createCat($data)
    {
        /** @var Extgallery\PublicCategory $cat */
        $cat = $this->create();
        $cat->setVars($data);

        if (!$this->hasValidParent($cat)) {
            return false;
        }

        $this->insert($cat, true);
        $this->rebuild();

        $criteria = new \CriteriaCompo();
        $criteria->setSort('cat_id');
        $criteria->setOrder('DESC');
        $criteria->setLimit(1);

        $cat = $this->getObjects($criteria);
        $cat = $cat[0];

        $moduleId = $GLOBALS['xoopsModule']->getVar('mid');

        // Retriving permission mask
        /** @var \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');
        $moduleId     = $GLOBALS['xoopsModule']->getVar('mid');
        $groups       = $GLOBALS['xoopsUser']->getGroups();

        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('gperm_name', 'extgallery_public_mask'));
        $criteria->add(new \Criteria('gperm_modid', $moduleId));
        $permMask = $grouppermHandler->getObjects($criteria);

        // Retriving group list
        /** @var \XoopsMemberHandler $memberHandler */
        $memberHandler = xoops_getHandler('member');
        $glist         = $memberHandler->getGroupList();

        // Applying permission mask
        $permArray       = include XOOPS_ROOT_PATH . '/modules/extgallery/include/perm.php';
        $modulePermArray = $permArray['modulePerm'];
        $pluginPermArray = $permArray['pluginPerm'];

        foreach ($permMask as $perm) {
            foreach ($modulePermArray as $permMask) {
                if ($perm->getVar('gperm_itemid') == $permMask['maskId']) {
                    $grouppermHandler->addRight($permMask['name'], $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
                }
            }

            foreach ($pluginPermArray as $permMask) {
                if ($perm->getVar('gperm_itemid') == $permMask['maskId']) {
                    $grouppermHandler->addRight($permMask['name'], $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
                }
            }
        }
        return true;
    }

    /**
     * @param \XoopsObject $cat
     *
     * @return bool
     */
    public function hasValidParent(\XoopsObject $cat = null)
    {
        // Check if haven't photo in parent category (parent category isn't an album)
        $parentCat = $this->get($cat->getVar('cat_pid'));

        return !$this->_isAlbum($parentCat);
    }

    /**
     * @return Extgallery\PublicPermHandler
     */
    public function getPermHandler()
    {
        return Extgallery\PublicPermHandler::getInstance();
    }
}
