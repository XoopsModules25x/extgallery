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
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 * @version     $Id: publiccat.php 8088 2011-11-06 09:38:12Z beckmi $
 */

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once 'catHandler.php';

class ExtgalleryPubliccat extends ExtgalleryCat {

	function ExtgalleryPubliccat() {
		parent::ExtgalleryCat();
	}

}

class ExtgalleryPubliccatHandler extends ExtgalleryCatHandler {

	function ExtgalleryPubliccatHandler(&$db)
	{
		parent::ExtgalleryCatHandler($db, 'public');
	}

	function createCat($data) {
		$cat = $this->create();
		$cat->setVars($data);

		if(!$this->_haveValidParent($cat)) {
			return false;
		}

		$this->insert($cat,true);
		$this->rebuild();

		$criteria = new CriteriaCompo();
		$criteria->setSort('cat_id');
		$criteria->setOrder('DESC');
		$criteria->setLimit(1);

		$cat = $this->getObjects($criteria);
		$cat = $cat[0];

		$moduleId = $GLOBALS['xoopsModule']->getVar('mid');

		// Retriving permission mask
		$gpermHandler =& xoops_gethandler('groupperm');
		$moduleId = $GLOBALS['xoopsModule']->getVar('mid');
		$groups = $GLOBALS['xoopsUser']->getGroups();

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('gperm_name','extgallery_public_mask'));
		$criteria->add(new Criteria('gperm_modid',$moduleId));
		$permMask = $gpermHandler->getObjects($criteria);


		// Retriving group list
		$memberHandler =& xoops_gethandler('member');
		$glist = $memberHandler->getGroupList();

		// Applying permission mask
		$permArray = include XOOPS_ROOT_PATH.'/modules/extgallery/include/perm.php';
        $modulePermArray = $permArray['modulePerm'];
	    $pluginPermArray = $permArray['pluginPerm'];

		foreach($permMask as $perm) {

		    foreach($modulePermArray as $permMask) {
		        if($perm->getVar('gperm_itemid') == $permMask['maskId']) {
                    $gpermHandler->addRight($permMask['name'], $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
		        }
		    }

		    foreach($pluginPermArray as $permMask) {
		        if($perm->getVar('gperm_itemid') == $permMask['maskId']) {
                    $gpermHandler->addRight($permMask['name'], $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
		        }
		    }

		}

	}

	function _haveValidParent(&$cat) {
		// Check if haven't photo in parent category (parent category isn't an album)
		$parentCat = $this->get($cat->getVar('cat_pid'));
		return !$this->_isAlbum($parentCat);
	}

	function _getPermHandler() {
		return ExtgalleryPublicPermHandler::getHandler();
	}

}

?>