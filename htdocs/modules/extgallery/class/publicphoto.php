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
 * @version     $Id: publicphoto.php 8088 2011-11-06 09:38:12Z beckmi $
 */

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once 'photoHandler.php';
include_once 'publicPerm.php';

class ExtgalleryPublicphoto extends ExtgalleryPhoto
{

	function ExtgalleryPublicphoto() {
		parent::ExtgalleryPhoto();
	}

}

class ExtgalleryPublicphotoHandler extends ExtgalleryPhotoHandler {

	function ExtgalleryPublicphotoHandler(&$db)
	{
		$this->ExtgalleryPhotoHandler($db, 'public');
	}

	function deleteFile(&$photo) {
		if(file_exists(XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/thumb/thumb_".$photo->getVar('photo_name')))
			unlink(XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/thumb/thumb_".$photo->getVar('photo_name'));

		if(file_exists(XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/medium/".$photo->getVar('photo_name')))
			unlink(XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/medium/".$photo->getVar('photo_name'));

		if(file_exists(XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/large/large_".$photo->getVar('photo_name')))
			unlink(XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/large/large_".$photo->getVar('photo_name'));

		if($photo->getVar('photo_orig_name') != "" && file_exists(XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/original/".$photo->getVar('photo_orig_name')))
			unlink(XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/original/".$photo->getVar('photo_orig_name'));
	}

	function getAllSize() {
		return $this->getSum(null,'photo_size');
	}

	function _getUploadPhotoPath() {
		return XOOPS_ROOT_PATH.'/uploads/extgallery/public-photo/';
	}

	function getUserAlbumPhotoPage($userId, $start, $sortby, $orderby) {
		$catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
		
		$criteria = new CriteriaCompo();
		$criteria->add($catHandler->getCatRestrictCriteria());
		$criteria->add(new Criteria('photo_approved',1));
		$criteria->add(new Criteria('uid',$userId));
      $criteria->setSort($sortby);
      $criteria->setOrder($orderby);
		$criteria->setStart($start);
		$criteria->setLimit($GLOBALS['xoopsModuleConfig']['nb_column']*$GLOBALS['xoopsModuleConfig']['nb_line']);
		return $this->getObjects($criteria);
	}

     function getUserAlbumPrevPhoto($userId, $photoDate) {
        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->add(new Criteria('uid',$userId));
        $criteria->add(new Criteria('photo_date',$photoDate,'>'));
        $criteria->setSort('photo_date');
        $criteria->setOrder('ASC');
        $criteria->setLimit(1);
        return $this->getObjects($criteria);
     }

    function getUserAlbumNextPhoto($userId, $photoDate) {
        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->add(new Criteria('uid',$userId));
        $criteria->add(new Criteria('photo_date',$photoDate,'<'));
        $criteria->setSort('photo_date');
        $criteria->setOrder('DESC');
        $criteria->setLimit(1);
        return $this->getObjects($criteria);
    }

    function getUserAlbumCurrentPhotoPlace($userId, $photoDate) {
        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->add(new Criteria('uid',$userId));
        $criteria->add(new Criteria('photo_date',$photoDate,'>='));
        $criteria->setSort('photo_date');
        $criteria->setOrder('ASC');
        return $this->getCount($criteria);
    }

    function getUserAlbumCount($userId) {
        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->add(new Criteria('uid',$userId));
        return $this->getCount($criteria);
    }

    function getUserPhotoAlbumId($userId) {

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('uid',$userId));
        $criteria->add(new Criteria('photo_approved',1));

        $sql = 'SELECT photo_id FROM '.$this->db->prefix('extgallery_publicphoto').' '.$criteria->renderWhere().' ORDER BY photo_date, photo_id DESC;';

        $result = $this->db->query($sql);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[] = $myrow['photo_id'];
        }

        return $ret;

    }

}

?>