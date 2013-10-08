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
 * @version     $Id: publicrating.php 8088 2011-11-06 09:38:12Z beckmi $
 */


if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once 'ExtgalleryPersistableObjectHandler.php';

class ExtgalleryPublicrating extends XoopsObject
{

	var $externalKey = array();

	function ExtgalleryPublicrating()
	{
		$this->initVar('rating_id', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('photo_id', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('rating_rate', XOBJ_DTYPE_INT, 0, false);
		
		$this->externalKey['photo_id'] = array('className'=>'publicphoto', 'getMethodeName'=>'getPhoto', 'keyName'=>'photo', 'core'=>false);
		$this->externalKey['uid'] = array('className'=>'user', 'getMethodeName'=>'get', 'keyName'=>'user', 'core'=>true);
	}
	
	function getExternalKey($key) {
		return $this->externalKey[$key];
	}
	
}

class ExtgalleryPublicratingHandler extends ExtgalleryPersistableObjectHandler {
	
	function ExtgalleryPublicratingHandler(&$db)
	{
		$this->ExtgalleryPersistableObjectHandler($db, 'extgallery_publicrating', 'ExtgalleryPublicrating', 'rating_id');
	}
	
	function rate($photoId, $rating) {
		
		$photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');
		
		$userId = (is_object($GLOBALS['xoopsUser'])) ? $GLOBALS['xoopsUser']->getVar('uid') : 0 ;
		$rate = $this->create();
		$rate->assignVar('photo_id',$photoId);
		$rate->assignVar('uid',$userId);
		$rate->assignVar('rating_rate',$rating);
		
		if($this->_haveRated($rate)) {
			return false;
		}
		
		if(!$this->insert($rate,true)) {
			return false;
		}
		
		return $photoHandler->updateNbRating($photoId);
	}
	
	function getRate($photoId) {
		$criteria = new Criteria('photo_id',$photoId);
		$avg = $this->getAvg($criteria,'rating_rate');
		return round($avg);
	}
	
	function _haveRated(&$rate) {
		// If the user is annonymous
		if($rate->getVar('uid') == 0) {
			return false;
		}
		
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('photo_id',$rate->getVar('photo_id')));
		$criteria->add(new Criteria('uid',$rate->getVar('uid')));
		
		if($this->getCount($criteria) > 0) {
			return true;
		}
		
		return false;
	}
	
}

?>