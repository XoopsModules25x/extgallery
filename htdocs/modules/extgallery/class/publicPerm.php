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
 * @version     $Id: publicPerm.php 8088 2011-11-06 09:38:12Z beckmi $
 */

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

class ExtgalleryPublicPermHandler {

	function &getHandler()
	{
		static $permHandler;
		if(!isset($permHandler)) {
			$permHandler = new ExtgalleryPublicPermHandler();
		}
		return $permHandler;
	}

	function _getUserGroup(&$user) {
		if(is_a($user,'XoopsUser')) {
			return $user->getGroups();
		} else {
			return XOOPS_GROUP_ANONYMOUS;
		}
	}

	function getAuthorizedPublicCat(&$user, $perm) {
		static $authorizedCat;
		$userId = ($user) ? $user->getVar('uid') : 0;
		if(!isset($authorizedCat[$perm][$userId])) {
			$groupPermHandler =& xoops_gethandler('groupperm');
			$moduleHandler =& xoops_gethandler('module');
			$module = $moduleHandler->getByDirname('extgallery');
			$authorizedCat[$perm][$userId] = $groupPermHandler->getItemIds($perm, $this->_getUserGroup($user), $module->getVar("mid"));
		}
		return $authorizedCat[$perm][$userId];
	}

	function isAllowed(&$user, $perm, $catId) {
		$autorizedCat = $this->getAuthorizedPublicCat($user, $perm);
		return in_array($catId, $autorizedCat);
	}

}

?>