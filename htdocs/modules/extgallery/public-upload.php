<?php
/**
 * ExtGallery User area
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
 * @version     $Id: public-upload.php 8088 2011-11-06 09:38:12Z beckmi $
 */

require '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
include_once 'include/functions.php';

if(isset($_POST['step'])) {
	$step = $_POST['step'];
} else {
	$step = 'default';
}

$permHandler = ExtgalleryPublicPermHandler::getHandler();
if(count($permHandler->getAuthorizedPublicCat($xoopsUser, 'public_upload')) < 1) {
	redirect_header("index.php", 3, _MD_EXTGALLERY_NOPERM);
	exit;
}

switch($step) {

	case 'enreg':

	    $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

	    $result = $photoHandler->postPhotoTraitement('photo_file', false);

	    if($result == 2) {
	       redirect_header("public-upload.php", 3, _MD_EXTGALLERY_NOT_AN_ALBUM);
	    } elseif($result == 4 || $result == 5) {
	       redirect_header("public-upload.php", 3, _MD_EXTGALLERY_UPLOAD_ERROR.' :<br />'.$photoHandler->photoUploader->getError());
	    } elseif($result == 0) {
	       redirect_header("public-upload.php", 3, _MD_EXTGALLERY_PHOTO_UPLOADED);
	    } elseif($result == 1) {
 		   redirect_header("public-upload.php", 3, _MD_EXTGALLERY_PHOTO_PENDING);
	    }


		break;

	case 'default':
	default:

		include_once XOOPS_ROOT_PATH.'/header.php';

		$catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

		$form = new XoopsThemeForm(_MD_EXTGALLERY_PUBLIC_UPLOAD, 'add_photo', 'public-upload.php', 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		$form->addElement(new XoopsFormLabel(_MD_EXTGALLERY_ALBUMS, $catHandler->getLeafSelect('cat_id', false, 0, "", "public_upload")));
		
		//DNPROSSI - editors 
		$form->addElement(new XoopsFormText(_MD_EXTGALLERY_PHOTO_TITLE, 'photo_title', '50', '150'),false);
		$editor = gal_getWysiwygForm(_MD_EXTGALLERY_DESC, 'photo_desc', '', 15, 60, '100%', '350px', 'hometext_hidden');
		$form->addElement($editor, false);
		
		$form->addElement(new XoopsFormFile(_MD_EXTGALLERY_PHOTO, 'photo_file', $xoopsModuleConfig['max_photosize']),false);
		if($xoopsModuleConfig['display_extra_field']) {
			$form->addElement(new XoopsFormTextArea(_MD_EXTGALLERY_EXTRA_INFO, "photo_extra"));
		}

		// For xoops tag
		if (($xoopsModuleConfig['usetag'] == 1) and (is_dir('../tag'))){
	      require_once XOOPS_ROOT_PATH.'/modules/tag/include/formtag.php';
	      $form->addElement(new XoopsFormTag('tag', 60, 255, '', 0));
      }
      
		$plugin = xoops_getmodulehandler('plugin', 'extgallery');
		$plugin->triggerEvent('photoForm', $form);

		$form->addElement(new XoopsFormHidden("step", 'enreg'));
		$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));

		$form->display();

		include(XOOPS_ROOT_PATH."/footer.php");

		break;

}

?>