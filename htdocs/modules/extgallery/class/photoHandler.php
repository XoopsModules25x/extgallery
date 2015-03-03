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
 * @version     $Id: photoHandler.php 11938 2013-08-19 18:29:38Z beckmi $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once 'publicPerm.php';
include_once 'ExtgalleryPersistableObjectHandler.php';

class ExtgalleryPhoto extends XoopsObject
{

    var $externalKey = array();

    function ExtgalleryPhoto()
    {
        $this->initVar('photo_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cat_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_title', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('photo_desc', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('photo_serveur', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('photo_name', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('photo_orig_name', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_size', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_res_x', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_res_y', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_hits', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_comment', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_rating', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_nbrating', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_download', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_ecard', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_date', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_havelarge', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_approved', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('photo_extra', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('photo_weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 0, false);

        $this->externalKey['cat_id'] = array('className'=>'publiccat', 'getMethodeName'=>'getCat', 'keyName'=>'cat', 'core'=>false);
        $this->externalKey['uid'] = array('className'=>'user', 'getMethodeName'=>'get', 'keyName'=>'user', 'core'=>true);
    }

    function getExternalKey($key) {
        return $this->externalKey[$key];
    }

}

class ExtgalleryPhotoHandler extends ExtgalleryPersistableObjectHandler {

    var $photoUploader = null;

    function ExtgalleryPhotoHandler(&$db, $type)
    {
        $this->ExtgalleryPersistableObjectHandler($db, 'extgallery_'.$type.'photo', 'Extgallery'.ucfirst($type).'photo', 'photo_id');
    }

    function createPhoto($data) {
        $photo = $this->create();
        $photo->setVars($data);

        return $this->insert($photo, true);
    }

    function modifyPhoto($photoId,$data) {
        $photo = $this->get($photoId);
        $photo->setVars($data);

        return $this->insert($photo,true);
    }

    function deletePhoto(&$photo) {
        if($photo->getVar('photo_serveur') == "") {
            $this->deleteFile($photo);
        }
        $this->delete($photo->getVar('photo_id'), true);
    }

    function deletePhotoByCat($catId) {
        $criteria = new Criteria('cat_id',$catId);
        $photos = $this->getObjects($criteria);
        foreach($photos as $photo) {
            $this->deletePhoto($photo);
        }
    }

    function deleteFile() {
        exit("deleteFile() method must be defined on sub classes");
    }

    function getPhoto($photoId) {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('photo_id',$photoId));
        $criteria->add(new Criteria('photo_approved',1));

        $photo =  $this->getObjects($criteria);
        if(count($photo) != 1) {
            return false;
        }

        return $photo[0];
    }

    function nbPhoto(&$cat) {
        $criteria = new Criteria('cat_id',$cat->getVar('cat_id'));

        return $this->getCount($criteria);
    }
    
    function getAlbumPhotoPage($catId, $start, $sortby, $orderby) {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('cat_id',$catId));
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->setStart($start);
        $criteria->setLimit($GLOBALS['xoopsModuleConfig']['nb_column']*$GLOBALS['xoopsModuleConfig']['nb_line']);
        if ($criteria->getSort() == '') {
            $criteria->setSort($sortby);
            $criteria->setOrder($orderby);
        }

        return $this->getObjects($criteria);
    }

 function getAlbumPhotoAdminPage($catId, $start) {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('cat_id',$catId));
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->setStart($start);
        $criteria->setLimit($GLOBALS['xoopsModuleConfig']['admin_nb_photo']);
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder($GLOBALS['xoopsModuleConfig']['display_set_order']);

        return $this->getObjects($criteria);
    }

 function getSlideshowAlbumPhoto($catId) {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('cat_id',$catId));
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder($GLOBALS['xoopsModuleConfig']['display_set_order']);

        return $this->getObjects($criteria, false, false);
    }

 function getPhotoAlbumId($catId) {

  $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('cat_id',$catId));
        $criteria->add(new Criteria('photo_approved',1));

  $sql = 'SELECT photo_id FROM '.$this->db->prefix('extgallery_publicphoto').' '.$criteria->renderWhere().' ORDER BY photo_weight, photo_id ASC;';

  $result = $this->db->query($sql);
  $ret = array();
  while ($myrow = $this->db->fetchArray($result)) {
   $ret[] = $myrow['photo_id'];
  }

  return $ret;

 }

 function getAlbumPrevPhoto($catId, $photoId) {
  $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->add(new Criteria('cat_id',$catId));
  $criteria->add(new Criteria('photo_id',$photoId,'<'));
  $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder('DESC');
  $criteria->setLimit(1);

        return $this->getObjects($criteria);
 }

 function getAlbumNextPhoto($catId, $photoId) {
  $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->add(new Criteria('cat_id',$catId));
  $criteria->add(new Criteria('photo_id',$photoId,'>'));
  $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder('ASC');
  $criteria->setLimit(1);

        return $this->getObjects($criteria);
 }

 function getAlbumCurrentPhotoPlace($catId, $photoId) {
        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $criteria->add(new Criteria('cat_id',$catId));
        $criteria->add(new Criteria('photo_id',$photoId,'<='));
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder('DESC');

        return $this->getCount($criteria);
 }

    function getAlbumPhoto($catId) {
        $criteria = new Criteria('cat_id',$catId);
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder('ASC');

        return $this->getObjects($criteria);
    }

    function getCatPhoto(&$category) {

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('nleft', $category->getVar('nleft'), '>='));
        $criteria->add(new Criteria('nright', $category->getVar('nright'), '<='));

        $cats = $catHandler->getObjects($criteria);

        $count = count($cats);
        if($count > 0) {
            $in = '('.$cats[0]->getVar('cat_id');
            array_shift($cats);
            foreach($cats as $cat) {
                $in .= ','.$cat->getVar('cat_id');
            }
            $in .= ')';
            $criteria = new Criteria('cat_id', $in, 'IN');
        } else {
            $criteria = new Criteria('cat_id', '(0)', 'IN');
        }

        return $this->getObjects($criteria);
    }

    function getAlbumCount($catId) {
        $criteria = new Criteria('cat_id',$catId);

        return $this->getCount($criteria);
    }

    function updateHits($photoId) {
        $criteria = new Criteria('photo_id',$photoId);

        return $this->updateCounter('photo_hits',$criteria);
    }

    function updateNbRating($photoId) {
        $criteria = new Criteria('photo_id',$photoId);

        return $this->updateCounter('photo_nbrating',$criteria);
    }

    function updateDownload($photoId) {
        $criteria = new Criteria('photo_id',$photoId);

        return $this->updateCounter('photo_download',$criteria);
    }

    function updateEcard($photoId) {
        $criteria = new Criteria('photo_id',$photoId);

        return $this->updateCounter('photo_ecard',$criteria);
    }

    function getAllSize() {
        exit("getAllSize() method must be defined on sub classes");
    }

    function _makeWatermark(&$imageTransform) {

        if(!function_exists('imagettfbbox'))
            return;

        global $xoopsModuleConfig;

        /*	Text position param
        /
        /	0 : orig
        /	-1 : opposit
        /	1 : center
        /
        */
        if($xoopsModuleConfig['watermark_position'] == "tl") {
            $x = 0;
            $y = 0;
        } elseif($xoopsModuleConfig['watermark_position'] == "tr") {
            $x = -1;
            $y = 0;
        } elseif($xoopsModuleConfig['watermark_position'] == "bl") {
            $x = 0;
            $y = -1;
        } elseif($xoopsModuleConfig['watermark_position'] == "br") {
            $x = -1;
            $y = -1;
        } elseif($xoopsModuleConfig['watermark_position'] == "tc") {
            $x = 1;
            $y = 0;
        } elseif($xoopsModuleConfig['watermark_position'] == "bc") {
            $x = 1;
            $y = -1;
        } elseif($xoopsModuleConfig['watermark_position'] == "lc") {
            $x = 0;
            $y = 1;
        } elseif($xoopsModuleConfig['watermark_position'] == "rc") {
            $x = -1;
            $y = 1;
        } elseif($xoopsModuleConfig['watermark_position'] == "cc") {
            $x = 1;
            $y = 1;
        }

        $text = ($xoopsModuleConfig['watermark_type'] == 0) ? $GLOBALS['xoopsUser']->getVar('uname') : $xoopsModuleConfig['watermark_text'];

        $watermarkParams = array(
            'text'=>$text,
            'x'=>$x,
            'y'=>$y,
            'color'=>$xoopsModuleConfig['watermark_color'],
            'font'=>XOOPS_ROOT_PATH."/modules/extgallery/fonts/".$xoopsModuleConfig['watermark_font'],
            'size'=>$xoopsModuleConfig['watermark_fontsize'],
            'resize_first'=>false,
            'padding'=>$xoopsModuleConfig['watermark_padding']
        );
        $imageTransform->addText($watermarkParams);
    }

    function _makeBorder(&$imageTransform) {

        global $xoopsModuleConfig;

        $borders = array();
        $borders[] = array('borderWidth'=>$xoopsModuleConfig['inner_border_size'], 'borderColor'=>$xoopsModuleConfig['inner_border_color']);
        $borders[] = array('borderWidth'=>$xoopsModuleConfig['outer_border_size'], 'borderColor'=>$xoopsModuleConfig['outer_border_color']);
        $imageTransform->addBorders($borders);
    }

    function _getUploadPhotoPath() {
        exit("_getUploadPhotoPath() method must be defined on sub classes");
    }

    function _largePhotoTreatment($photoName) {

        global $xoopsModuleConfig;

        // Check if must save large photo
        if($xoopsModuleConfig['save_large']) {

            // Define Graphical library path
            if(!defined('IMAGE_TRANSFORM_IM_PATH') && $xoopsModuleConfig['graphic_lib'] == 'IM') {
                define('IMAGE_TRANSFORM_IM_PATH', $xoopsModuleConfig['graphic_lib_path']);
            }
            $imageTransform = Image_Transform::factory($xoopsModuleConfig['graphic_lib']);

            $filePath = $this->_getUploadPhotoPath();
            $imageTransform->load($filePath.$photoName);

            // Save large photo only if it's bigger than medium size
            if($imageTransform->getImageWidth() > $xoopsModuleConfig['medium_width'] ||
                $imageTransform->getImageHeight() > $xoopsModuleConfig['medium_heigth']) {

                // Make watermark
                if($xoopsModuleConfig['enable_large_watermark']) {
                    $this->_makeWatermark($imageTransform);
                }

                // Make border
                if($xoopsModuleConfig['enable_large_border']) {
                    $this->_makeBorder($imageTransform);
                }

                $largeFilePath = $filePath."large/large_".$photoName;
                $imageTransform->save($largeFilePath, '', 100);
                $imageTransform->free();
            }
        }
    }

    function _mediumPhotoTreatment($photoName, $filePath = null, $mediumFilePath = null) {

        global $xoopsModuleConfig;

        // Define Graphical library path
        if(!defined('IMAGE_TRANSFORM_IM_PATH') && $xoopsModuleConfig['graphic_lib'] == 'IM') {
            define('IMAGE_TRANSFORM_IM_PATH', $xoopsModuleConfig['graphic_lib_path']);
        }
        $imageTransform = Image_Transform::factory($xoopsModuleConfig['graphic_lib']);

        if(is_null($filePath)) {
            $filePath = $this->_getUploadPhotoPath();
        }
        if(is_null($mediumFilePath)) {
            $mediumFilePath = $filePath."medium/".$photoName;
        }
        $imageTransform->load($filePath.$photoName);

        // Fitting image to desired size
  if($xoopsModuleConfig['enable_medium_border']) {
   $borderSize = ($xoopsModuleConfig['inner_border_size'] * 2) + ($xoopsModuleConfig['outer_border_size'] * 2);
  } else {
   $borderSize = 0;
  }
        $imageTransform->fit($xoopsModuleConfig['medium_width'] - $borderSize , $xoopsModuleConfig['medium_heigth'] - $borderSize);
        $imageTransform->save($mediumFilePath, '', $xoopsModuleConfig['medium_quality']);
        $imageTransform->free();

        if($xoopsModuleConfig['enable_medium_watermark'] || $xoopsModuleConfig['enable_medium_border'])    {
            $imageTransform->load($mediumFilePath);

            // Make watermark
            if($xoopsModuleConfig['enable_medium_watermark']) {
                $this->_makeWatermark($imageTransform);
            }

            // Make border
            if($xoopsModuleConfig['enable_medium_border']) {
                $this->_makeBorder($imageTransform);
            }

            $imageTransform->save($mediumFilePath, '', $xoopsModuleConfig['medium_quality']);
            $imageTransform->free();
        }
    }

    function _makeThumb($photoName) {

        global $xoopsModuleConfig;

        // Define Graphical library path
        if(!defined('IMAGE_TRANSFORM_IM_PATH') && $xoopsModuleConfig['graphic_lib'] == 'IM') {
            define('IMAGE_TRANSFORM_IM_PATH', $xoopsModuleConfig['graphic_lib_path']);
        }
        $imageTransform = Image_Transform::factory($xoopsModuleConfig['graphic_lib']);

        $filePath = $this->_getUploadPhotoPath()."medium/".$photoName;
        $thumbPath = $this->_getUploadPhotoPath()."thumb/thumb_".$photoName;

        $imageTransform->load($filePath);
        $imageTransform->fit($xoopsModuleConfig['thumb_width'], $xoopsModuleConfig['thumb_heigth']);
        $imageTransform->save($thumbPath, '', $xoopsModuleConfig['thumb_quality']);
        $imageTransform->free();
    }

    function _haveLargePhoto($photoName) {
        return file_exists($this->_getUploadPhotoPath()."large/large_".$photoName);
    }

    function _getImageDimension($photoName) {

        global $xoopsModuleConfig;

        // Define Graphical library path
        if(!defined('IMAGE_TRANSFORM_IM_PATH') && $xoopsModuleConfig['graphic_lib'] == 'IM') {
            define('IMAGE_TRANSFORM_IM_PATH', $xoopsModuleConfig['graphic_lib_path']);
        }
        $imageTransform = Image_Transform::factory($xoopsModuleConfig['graphic_lib']);

        $ret = array();
        if($this->_haveLargePhoto($photoName)) {
            $imageTransform->load($this->_getUploadPhotoPath()."large/large_".$photoName);
            $ret['width'] = $imageTransform->getImageWidth();
            $ret['height'] = $imageTransform->getImageHeight();
        } else {
            $imageTransform->load($this->_getUploadPhotoPath()."medium/".$photoName);
            $ret['width'] = $imageTransform->getImageWidth();
            $ret['height'] = $imageTransform->getImageHeight();
        }
        $imageTransform->free();

        return $ret;
    }

    function _getAutoDescription($photoName) {

        global $xoopsModuleConfig;
    
        //DNPROSSI
        /*if ($xoopsModuleConfig['enable_longdesc']) {
            $newphotoname = '';
            $newnewphotoname = '';
            $patterns = array();
            $patterns[0] = "/-/";
            $patterns[1] = "/_/";
            $replacements = array();
            $replacements[0] = " ";
            $replacements[1] = "'";
            $newphotoName = substr($photoName, strpos($photoName, "-") + 1);
            $newphotoName = substr($newphotoName, strpos($newphotoName, "-") + 1);
            return preg_replace($patterns, $replacements, substr($newphotoName,0,-12));
        } else { */
            $matches = array();
            preg_match_all($xoopsModuleConfig['photoname_pattern'], substr($photoName,0,-12), $matches);
            preg_match_all($xoopsModuleConfig['photoname_pattern'], $photoName, $matches);

            return implode(" ",$matches[1]);
        //}
    }

    function _makeFileName($fileName) {
        //DNPROSSI
        //$fileName = preg_replace("/[^a-zA-Z0-9()_\.-]/", "-", $fileName);
        $fileName = preg_replace("/[^a-zA-Z0-9_\.-]/", "-", $fileName);

        $fileName = explode(".",$fileName);
        $userId = (is_object($GLOBALS['xoopsUser'])) ? $GLOBALS['xoopsUser']->getVar('uid') : 0 ;

        return $fileName[0].'_'.$userId.'_'.substr(md5(uniqid(rand())),27).'.'.$fileName[1];
    }

    function _getPhotoSize($photoName) {
        if($this->_haveLargePhoto($photoName)) {
            return $this->_getFileSize("large/large_".$photoName);
        } else {
            return $this->_getFileSize($photoName);
        }
    }

    function _getFileSize($fileName) {
        return round(filesize($this->_getUploadPhotoPath().$fileName)/1024,2);
    }

 function rebuildThumbnail($catId) {

  $photos = $this->getAlbumPhoto($catId);
  foreach($photos as $photo) {
   $this->_makeThumb($photo->getVar('photo_name'));
  }

 }

    /* Return Code :
        0 : Photo added
        1 : Photo pending
        2 : This is not an album
        3 : HTTP Upload error
        4 : File rejected
        5 : File chunk receive
        */
    function postPhotoTraitement($file, $checkMd5 = false) {

//        include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/photoUploader.php';

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $catId = intval($_POST['cat_id']);

        // If isn't an album when stop the traitment
        $cat = $catHandler->getCat($catId);
        if($cat->getVar('nright') - $cat->getVar('nleft') != 1) {
            return 2;
        }

        $allowedMimeTypes = array('image/jpeg','image/jpg','image/pjpeg','image/gif','image/png','image/x-png');
//        $allowedMimeTypes = array('jpg/jpeg', 'image/bmp', 'image/gif', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png');

        $uploadDir = XOOPS_ROOT_PATH."/uploads/extgallery/public-photo/";

//        $this->photoUploader = new ExtgalleryPhotoUploader($uploadDir,  50000000, 5000, 5000);
//        $this->photoUploader->checkMd5 = $checkMd5;
//        $this->photoUploader->fetchPhoto($_FILES[$file]);


        //------------------------
        include_once(XOOPS_ROOT_PATH . "/class/uploader.php");
        $this->photoUploader = new XoopsMediaUploader($uploadDir, $allowedMimeTypes, 50000000, 5000, 5000);

        $jupart = (isset($_POST['jupart'])) ? (int)$_POST['jupart'] : 0;
        $jufinal = (isset($_POST['jufinal'])) ? (int)$_POST['jufinal'] : 1;

        if ($this->photoUploader->fetchMedia($file) && $this->photoUploader->upload()) {
        } else {
            // We got a chunk, so we don't add photo to database
            if ($jupart && !$jufinal) {
                return 5;
            } else {
                return 4;
            }
        }

        //---------------------------

/*

        $jupart = (isset($_POST['jupart'])) ? (int)$_POST['jupart'] : 0;
        $jufinal = (isset($_POST['jufinal'])) ? (int)$_POST['jufinal'] : 1;

        if($this->photoUploader->isError()) {
            return 4;
        // We got a chunk, so we don't add photo to database
        } elseif($jupart && !$jufinal) {
            return 5;
        }
*/

        //DNPROSSI - add missing title and description on upload
        $photoTitle = '';
        $photoDesc = '';
        $photoExtra = '';
        $photoTag = '';
        
        if ( isset($_POST['photo_title']) ) { $photoTitle = $_POST['photo_title']; }
        if ( isset($_POST['photo_desc']) ) { $photoDesc = $_POST['photo_desc']; }
        if ( isset($_POST['photo_extra']) ) { $photoExtra = $_POST['photo_extra']; }
        if ( isset($_POST['tag']) ) { $photoTag = $_POST["tag"]; }
        
        $photoStatus = $this->addLocalPhoto($catId,$this->photoUploader->getSavedFilename(), $photoTitle, $photoDesc , $photoExtra , $photoTag);
        $cat = $catHandler->getCat($catId);
        $cat->setVar('cat_isalbum',1);
        $catHandler->insert($cat);

        $notification_handler =& xoops_gethandler('notification');
        $extraTags = array(
            'X_ITEM_CAT'=>$cat->getVar('cat_name'),
            'X_ITEM_NBPHOTO'=>1
        );

        if($photoStatus == 1) {
            $extraTags['X_ITEM_URL'] = XOOPS_URL."/modules/extgallery/public-album.php?id=".$cat->getVar('cat_id');
            $notification_handler->triggerEvent('global', 0, 'new_photo',$extraTags);
            $notification_handler->triggerEvent('album', $cat->getVar('cat_id'), 'new_photo_album',$extraTags);

            // Update album count
            if($cat->getVar('cat_nb_photo') == 0) {
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('nleft',$cat->getVar('nleft'),'<'));
                $criteria->add(new Criteria('nright',$cat->getVar('nright'),'>'));
                $catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album + 1', $criteria);
            }

            // Update photo count
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('nleft',$cat->getVar('nleft'),'<='));
            $criteria->add(new Criteria('nright',$cat->getVar('nright'),'>='));
            $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo + 1', $criteria);

            return 0;
        } else {
            $extraTags['X_ITEM_URL'] = XOOPS_URL."/modules/extgallery/admin/photo.php";
            $notification_handler->triggerEvent('global', 0, 'new_photo_pending',$extraTags);

            return 1;
        }

    }

    function addLocalPhoto($catId, $dirtyPhotoName, $photoTitle = "", $photoDesc = "", $photoExtra = "" , $photoTag = "") {

        include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/pear/Image/Transform.php';

        global $xoopsUser, $xoopsModuleConfig;
        $permHandler = ExtgalleryPublicPermHandler::getHandler();

        // Replace all bad file name character
        $photoName = $this->_makeFileName($dirtyPhotoName);
        rename($this->_getUploadPhotoPath().$dirtyPhotoName, $this->_getUploadPhotoPath().$photoName);
        
        //DNPROSSI - changed photo_desc to photo_title
        // Making auto description
        if($photoTitle == "") {
            $photoTitle = $this->_getAutoDescription($photoName);
        }

        $originalName = "";
        // Save original photo
        if($xoopsModuleConfig['save_large'] && $xoopsModuleConfig['save_original']) {
            $fileName = explode(".",$photoName);
            $originalName = md5(uniqid(rand())).".".$fileName[1];
            copy($this->_getUploadPhotoPath().$photoName, $this->_getUploadPhotoPath()."original/".$originalName);
        }

        $this->_largePhotoTreatment($photoName);

        $this->_mediumPhotoTreatment($photoName);

        $this->_makeThumb($photoName);

        $imageDimension = $this->_getImageDimension($photoName);

        $userId = (is_object($xoopsUser)) ? $xoopsUser->getVar('uid') : 0 ;
        $data = array(
                'cat_id'=>$catId,
                'photo_title'=>$photoTitle,
                'photo_desc'=>$photoDesc,
                'photo_name'=>$photoName,
                'photo_orig_name'=>$originalName,
                'uid'=>$userId,
                'photo_size'=>$this->_getPhotoSize($photoName),
                'photo_res_x'=>$imageDimension['width'],
                'photo_res_y'=>$imageDimension['height'],
                'photo_date'=>time(),
                'photo_havelarge'=>$this->_haveLargePhoto($photoName),
                'photo_approved'=>$permHandler->isAllowed($xoopsUser, 'public_autoapprove', $catId),
                'photo_extra'=>$photoExtra,
                'dohtml'=>$xoopsModuleConfig['allow_html']
            );

        // Deleting working photo
        unlink($this->_getUploadPhotoPath().$photoName);

        $this->createPhoto($data);

        if ($xoopsModuleConfig['usetag'] == 1|| (is_dir('../tag') or is_dir('../../tag'))){
            $newid = $this->db->getInsertId();
           $tag_handler = xoops_getmodulehandler('tag', 'tag');
           $tag_handler->updateByItem($photoTag, $newid , 'extgallery', 0);
        }
           
        return $data['photo_approved'];
    }

    function getSearchedPhoto($queryArray, $condition, $limit, $start, $userId)    {
        $criteria = new CriteriaCompo();
        if($userId > 0)
            $criteria->add(new Criteria('uid',$userId));
        $criteria->add(new Criteria('photo_approved',1));
        if(is_array($queryArray) && count($queryArray) > 0) {
            $subCriteria = new CriteriaCompo();
            foreach($queryArray as $keyWord) {
                $keyWordCriteria = new CriteriaCompo();
                $keyWordCriteria->add(new Criteria('photo_title','%'.$keyWord.'%','LIKE'));
                $keyWordCriteria->add(new Criteria('photo_desc','%'.$keyWord.'%','LIKE'), 'OR');
                $keyWordCriteria->add(new Criteria('photo_name','%'.$keyWord.'%','LIKE'), 'OR');
                $subCriteria->add($keyWordCriteria,$condition);
                unset($keyWordCriteria);
            }
            $criteria->add($subCriteria);
        }
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $criteria->setSort('photo_date');

        $photos = $this->getObjects($criteria);

        $ret = array();
        foreach($photos as $photo) {
            if($photo->getVar('photo_title')){
                $title = $photo->getVar('photo_title');
            } else {
                $title = $photo->getVar('photo_desc');
            }
            $data = array(
                        'image'=>'images/extgallery-posticon.gif',
                        'link'=>'public-photo.php?photoId='.$photo->getVar('photo_id'),
                        'title'=>$title,
                        'time'=>$photo->getVar('photo_date'),
                        'uid'=>$photo->getVar('uid')
                    );
            $ret[] = $data;
        }

        return $ret;
    }

    function getPendingPhoto() {
        $criteria = new Criteria('photo_approved',0);

        return $this->getObjects($criteria);
    }

    function _addInCriteria(&$criteria, $data) {
        $count = count($data);
        if($count > 0) {
            $in = '('.$data[0];
            array_shift($data);
            foreach($data as $elmt) {
                $in .= ','.$elmt;
            }
            $in .= ')';
            $criteria->add(new Criteria('cat_id', $in, 'IN'));
        }
    }

    function getRandomPhoto($param) {

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $this->_addInCriteria($criteria, $param['cat']);
        $criteria->setSort('RAND()');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    function getLastPhoto($param) {

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $this->_addInCriteria($criteria, $param['cat']);
        $criteria->setSort('photo_date');
        $criteria->setOrder('DESC');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    function getTopViewPhoto($param) {

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $this->_addInCriteria($criteria, $param['cat']);
        $criteria->setSort('photo_hits');
        $criteria->setOrder('DESC');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    function getTopRatedPhoto($param) {

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $this->_addInCriteria($criteria, $param['cat']);
        $criteria->setSort('photo_rating');
        $criteria->setOrder('DESC');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    function getTopEcardPhoto($param) {

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new Criteria('photo_approved',1));
        $this->_addInCriteria($criteria, $param['cat']);
        $criteria->setSort('photo_ecard');
        $criteria->setOrder('DESC');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    function getTopSubmitter($param) {

       $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

        $criteria = new Criteria();
        $this->_addInCriteria($criteria, $param['cat']);

        echo $criteria->renderWhere();

    }

    function getInsertId() {
        return $this->db->getInsertId();
    }

}
