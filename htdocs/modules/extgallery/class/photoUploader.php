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
 * @version     $Id: photoUploader.php 11938 2013-08-19 18:29:38Z beckmi $
 */

class ExtgalleryPhotoUploader {

 var $uploadDir;
 var $savedDestination;
 var $savedFilename;
 var $maxFileSize;
 var $maxWidth;
 var $maxHeight;
 var $isError;
 var $error;
 var $checkMd5;

 function ExtgalleryPhotoUploader($uploadDir, $maxFileSize=0, $maxWidth=null, $maxHeight=null) {

  $this->uploadDir = $uploadDir;
  $this->maxFileSize = intval($maxFileSize);
  if (isset($maxWidth)) {
   $this->maxWidth = intval($maxWidth);
  }
  if (isset($maxHeight)) {
   $this->maxHeight = intval($maxHeight);
  }

  $this->isError = false;
  $this->error = '';
  $this->checkMd5 = true;

 }

 function fetchPhoto($file) {

  $jupart = (isset($_POST['jupart'])) ? (int)$_POST['jupart'] : 0;
  $jufinal = (isset($_POST['jufinal'])) ? (int)$_POST['jufinal'] : 1;
  $md5sums = (isset($_POST['md5sum'][0])) ? $_POST['md5sum'][0] : null;

  if($this->uploadDir == '') {
   $this->abort('upload dir not defined');

   return false;
  }

  if(!is_dir($this->uploadDir)) {
   $this->abort('fail to open upload dir');

   return false;
  }

  if(!is_writeable($this->uploadDir)) {
   $this->abort('upload dir not writable');

   return false;
  }

  if($this->checkMd5 && !isset($md5sums)) {
   $this->abort('Expecting an MD5 checksum');

   return false;
  }

  $dstdir = $this->uploadDir;
  $dstname = $dstdir.'/juvar.'.session_id();
  $tmpname = $dstdir.'/juvar.tmp'.session_id();

  if (!move_uploaded_file($file['tmp_name'], $tmpname)) {
   $this->abort('Unable to move uploaded file');

   return false;
  }

  if($jupart) {
   // got a chunk of a multi-part upload
   $len = filesize($tmpname);
   $_SESSION['juvar.tmpsize'] += $len;
   if($len > 0) {
    $src = fopen($tmpname, 'rb');
    $dst = fopen($dstname, ($jupart == 1) ? 'wb' : 'ab');
    while($len > 0) {
     $rlen = ($len > 8192) ? 8192 : $len;
     $buf = fread($src, $rlen);
     if(!$buf) {
      fclose($src);
      fclose($dst);
      unlink($dstname);
      $this->abort('read IO error');

      return false;
     }
     if(!fwrite($dst, $buf, $rlen)) {
      fclose($src);
      fclose($dst);
      unlink($dstname);
      $this->abort('write IO error');

      return false;
     }
     $len -= $rlen;
    }
    fclose($src);
    fclose($dst);
    unlink($tmpname);
   }
   if($jufinal) {
    // This is the last chunk. Check total lenght and rename it to it's final name.
    $dlen = filesize($dstname);
    if($dlen != $_SESSION['juvar.tmpsize']) {
     $this->abort('file size mismatch');

     return false;
    }
    if($this->checkMd5 && ($md5sums != md5_file($dstname))) {
     $this->abort('MD5 checksum mismatch');

     return false;
    }
    // remove zero sized files
    if($dlen > 0) {
     if(!$this->_saveFile($dstname, $file['name'])) {
      return false;
     }
    } else {
     $this->abort('0 file size');

     return false;
    }
    // reset session var
    $_SESSION['juvar.tmpsize'] = 0;
   }
  } else {
   // Got a single file upload. Trivial.
   if($this->checkMd5 && $md5sums != md5_file($tmpname)) {
    $this->abort('MD5 checksum mismatch');

    return false;
   }
   if(!$this->_saveFile($tmpname, $file['name'])) {
    return false;
   }
  }

  return true;

 }

 function _saveFile($tmpDestination, $fileName) {

  $this->savedFilename = $fileName;
  $this->savedDestination = $this->uploadDir.$fileName;

  if(!$this->_checkFile($tmpDestination)) {
   return false;
  }

  if (!rename($tmpDestination, $this->savedDestination)) {
   $this->abort('error renaming file');

   return false;
  }

  @chmod($this->savedDestination, 0644);

  return true;

 }

 function _checkFile($tmpDestination) {

//  $imageExtensions = array(IMAGETYPE_GIF => 'gif', IMAGETYPE_JPEG => 'jpeg', IMAGETYPE_JPG => 'jpg', IMAGETYPE_PNG => 'png');

     $valid_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP);

     $imageExtensions = array('gif', 'jpg', 'jpeg', 'png');

  // Check IE XSS before returning success
  $ext = strtolower( substr( strrchr( $this->savedDestination , '.' ) , 1 ) ) ;
  $photoInfo = getimagesize($tmpDestination);
  if( $photoInfo === false || $imageExtensions[ (int)$photoInfo[2] ] != $ext ) {
   $this->abort('Suspicious image upload refused');

   return false;
  }

  if(!$this->checkMaxFileSize($tmpDestination)) {
   $this->abort('Max file size error');

   return false;
  }

  if(!$this->checkMaxWidth($photoInfo)) {
   $this->abort('Max width error');

   return false;
  }

  if(!$this->checkMaxHeight($photoInfo)) {
   $this->abort('Max height error');

   return false;
  }

  if(!$this->checkImageType($photoInfo)) {
   $this->abort('File type not allowed');

   return false;
  }

  return true;

 }

 function checkMaxFileSize($file) {

  if (!isset($this->maxFileSize)) {
   return true;
  }

  if(filesize($file) > $this->maxFileSize) {
   return false;
  }

  return true;

 }

 function checkMaxWidth($photoInfo) {

  if(!isset($this->maxWidth)) {
   return true;
  }

  if($photoInfo[0] > $this->maxWidth) {
   return false;
  }

  return true;

 }

 function checkMaxHeight($photoInfo) {

  if(!isset($this->maxHeight)) {
   return true;
  }

  if($photoInfo[1] > $this->maxHeight) {
   return false;
  }

  return true;
 }

 function checkImageType($photoInfo) {

//  $allowedMimeTypes = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_JPG, IMAGETYPE_PNG);
   $allowedMimeTypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
  if (!in_array($photoInfo['mime'], $allowedMimeTypes)) {
   return false;
  }

  return true;

 }

 function abort($msg = '') {
  // remove all uploaded files of *this* request
  if (isset($_FILES)) {
   foreach ($_FILES as $key => $val) {
    //@unlink($val['tmp_name']);
   }
  }

  // remove accumulated file, if any.
  //@unlink($this->uploadDir .'/juvar.'.session_id());
  //@unlink($this->uploadDir .'/juvar.tmp'.session_id());

  // reset session var
  $_SESSION['juvar.tmpsize'] = 0;

  $this->isError = true;
  $this->error = $msg;

 }

 function isError() {
  return $this->isError;
 }

 function getError() {
  return $this->error;
 }

 function getSavedDestination() {
  return $this->savedDestination;
 }

 function getSavedFilename() {
  return $this->savedFilename;
 }

}
