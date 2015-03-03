<?php
/**
 * ExtGallery Admin settings
 * Manage admin pages
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
 * @version     $Id: photo.php 11938 2013-08-19 18:29:38Z beckmi $
 */

include '../../../include/cp_header.php';
include '../../../class/xoopsformloader.php';
include '../../../class/pagenav.php';
include XOOPS_ROOT_PATH.'/modules/extgallery/class/pear/Image/Transform.php';
include 'function.php';

if(isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = 'default';
}

if(isset($_POST['step'])) {
    $step = $_POST['step'];
} else {
    $step = 'default';
}

if(isset($_GET['start'])) {
    $start = $_GET['start'];
} else {
    $start = 0;
}

switch($op) {

    case 'add_photo':

        $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');
        $result = $photoHandler->postPhotoTraitement('photo_file', false);

        if($result == 2) {
           redirect_header("photo.php", 3, _AM_EXTGALLERY_NOT_AN_ALBUM);
           exit;
        } elseif($result == 4 || $result == 5) {
           redirect_header("photo.php", 3, _AM_EXTGALLERY_UPLOAD_ERROR.' :<br />'.$photoHandler->photoUploader->getErrors());
           exit;
        } elseif($result == 0) {
           redirect_header("photo.php", 3, _AM_EXTGALLERY_PHOTO_UPLOADED);
           exit;
        } elseif($result == 1) {
           redirect_header("photo.php", 3, _AM_EXTGALLERY_PHOTO_PENDING);
           exit;
        }
       break;
         
    case 'batchAdd':

        if(get_cfg_var('max_execution_time') == null) {
            $maxExecTime = 30;
        } else {
            $maxExecTime = get_cfg_var('max_execution_time');
        }
        $maxTime = time() + $maxExecTime - 5;
        $maxTimeReached = false;

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
        $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

        // Test if an album is selected
        if(!isset($_POST['cat_id'])) {
            redirect_header("photo.php", 3, _AM_EXTGALLERY_NOT_AN_ALBUM);
            exit;
        }

        // If isn't an album when stop the traitment
        $cat = $catHandler->getCat($_POST['cat_id']);
        if($cat->getVar('nright') - $cat->getVar('nleft') != 1) {
            redirect_header("photo.php", 3, _AM_EXTGALLERY_NOT_AN_ALBUM);
            exit;
        }

        $photos = array();

        $batchRep = XOOPS_ROOT_PATH.'/modules/extgallery/batch/';
        $photoRep = XOOPS_ROOT_PATH.'/uploads/extgallery/public-photo/';
        $dir = opendir($batchRep);
        while ($f = readdir($dir)) {
            if(is_file($batchRep.$f)) {
                if(preg_match("/.*gif/",strtolower($f)) || preg_match("/.*jpg/",strtolower($f)) || preg_match("/.*jpeg/",strtolower($f)) ||preg_match("/.*png/",strtolower($f))) {
                    $photos[] = $f;
                }
            }
        }

        // Check if they are photos to add in the batch folder
        if(count($photos) < 1) {
            redirect_header("photo.php", 3, _AM_EXTGALLERY_NO_PHOTO_IN_BATCH_DIR);
            exit;
        }

        $nbPhotos = (isset($_POST['nbPhoto'])) ? $_POST['nbPhoto'] : 0 ;
        $i = 0;
        foreach($photos as $photo) {

            // Move the photo to the upload directory
            rename($batchRep.$photo,$photoRep.$photo);

            $photoStatus = $photoHandler->addLocalPhoto($_POST['cat_id'], $photo, $_POST['photo_desc']);
            $i++;
            if(time() > $maxTime) {
                $maxTimeReached = true;
                break;
            }
        }

        // Set the category as album only if photo is approve
        include_once '../class/publicPerm.php';
        $permHandler = ExtgalleryPublicPermHandler::getHandler();
        if($permHandler->isAllowed($xoopsUser, 'public_autoapprove', $cat->getVar('cat_id'))) {
            $cat->setVar('cat_isalbum',1);
            $catHandler->insert($cat);
        }

        // Make a "continue" page to display imformation message
        if($maxTimeReached) {

            xoops_cp_header();

            echo '<div class="confirmMsg">';

            $photoMore = count($photos) - $i;
            echo '<h4>'.sprintf(_AM_EXTGALLERY_BATCH_CONTINUE_MESSAGE,($i + $nbPhotos), $photoMore).'</h4>';
            echo '<form method="post" action="photo.php?op=batchAdd">';
            echo '<input type="hidden" name="cat_id" value="'.$_POST['cat_id'].'" />';
            echo '<input type="hidden" name="photo_desc" value="'.$_POST['photo_desc'].'" />';
            echo '<input type="hidden" name="nbPhoto" value="'.($i + $nbPhotos).'" />';
            echo '<input type="submit" name="confirm_submit" value="Continue" />';
            echo '</form>';
            echo '</div>';

            xoops_confirm(array('cat_id'=>$_POST['cat_id'], 'photo_desc'=>$_POST['photo_desc'], 'nbPhoto'=>$nbPhotos), 'photo.php?op=batchAdd', _AM_EXTGALLERY_DELETE_CAT_CONFIRM);

            xoops_cp_footer();

        } else {

            $notification_handler =& xoops_gethandler('notification');
            $extraTags = array(
                            'X_ITEM_CAT'=>$cat->getVar('cat_name'),
                            'X_ITEM_NBPHOTO'=>($i + $nbPhotos)
                        );
            if($photoStatus == 1) {
                $extraTags['X_ITEM_URL'] = XOOPS_URL."/modules/extgallery/public-album.php?id=".$cat->getVar('cat_id');
                $notification_handler->triggerEvent('global', 0, 'new_photo',$extraTags);
                $notification_handler->triggerEvent('album', $cat->getVar('cat_id'), 'new_photo_album',$extraTags);
            } else {
                $extraTags['X_ITEM_URL'] = XOOPS_URL."/modules/extgallery/admin/photo.php";
                $notification_handler->triggerEvent('global', 0, 'new_photo_pending',$extraTags);
            }

            // Update photo count if photo needn't approve
            include_once '../class/publicPerm.php';
            $permHandler = ExtgalleryPublicPermHandler::getHandler();
            if($permHandler->isAllowed($xoopsUser, 'public_autoapprove', $cat->getVar('cat_id'))) {

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
                $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo + '.($i + $nbPhotos), $criteria);
            }

            redirect_header("photo.php", 3, sprintf(_AM_EXTGALLERY_X_PHOTO_ADDED, count($photos)));
        }

        break;

    case 'batchApprove':

        $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

        // Check if they are selected photo
        if(!isset($_POST['photoId'])) {
            redirect_header("photo.php",3,_AM_EXTGALLERY_NO_PHOTO_SELECTED);
            exit;
        }

        if(isset($_POST['approve'])) {

            $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

            // If we have only one photo we put in in an array
            $categories = array();
            foreach(array_keys($_POST['photoId']) as $photoId) {
                $photo = $photoHandler->get($photoId);
                $photo->setVar('photo_approved',1);
                $photoHandler->insert($photo);

                if(!isset($categories[$photo->getVar('cat_id')]))
                    $categories[$photo->getVar('cat_id')] = 0;
                $categories[$photo->getVar('cat_id')]++;
            }

            $notification_handler =& xoops_gethandler('notification');

            foreach($categories as $k=>$v) {
                $cat = $catHandler->getCat($k);
                $extraTags = array(
                                'X_ITEM_CAT'=>$cat->getVar('cat_name'),
                                'X_ITEM_NBPHOTO'=>$v,
                                'X_ITEM_URL'=>XOOPS_URL."/modules/extgallery/public-album.php?id=".$cat->getVar('cat_id')
                            );
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
                $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo + '.$v, $criteria);
            }
            
            if($cat->getVar('cat_isalbum') == 0) {
                $cat->setVar('cat_isalbum',1);
                $catHandler->insert($cat);
            }

            redirect_header("photo.php", 3, sprintf(_AM_EXTGALLERY_X_PHOTO_APPROVED, count($_POST['photoId'])));

        } else if(isset($_POST['delete'])) {

            foreach(array_keys($_POST['photoId']) as $photoId) {
                $photo = $photoHandler->get($photoId);
                $photoHandler->deletePhoto($photo);
            }

            redirect_header("photo.php", 3, sprintf(_AM_EXTGALLERY_X_PHOTO_DELETED, count($_POST['photoId'])));

        }

        break;
  
 case 'rebuildthumb':
 
  $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');
  $photoHandler->rebuildThumbnail($_GET['cat_id']);
  
  redirect_header("photo.php", 3, _AM_EXTGALLERY_THUMB_REBUILDED);
  
  break;

    case 'modify':

        switch($step) {
         

            case 'enreg':

                // Check if they are selected photo
                if(!isset($_POST['photoId'])) {
                    redirect_header("photo.php",3,_AM_EXTGALLERY_NO_PHOTO_SELECTED);
                    exit;
                }

                $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
                $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

                // Test if an album is selected
                if(!isset($_POST['cat_id'])) {
                    redirect_header("photo.php", 3, _AM_EXTGALLERY_NOT_AN_ALBUM);
                    exit;
                }

                // If isn't an album when stop the traitment
                $cat = $catHandler->getCat($_POST['cat_id']);
                if($cat->getVar('nright') - $cat->getVar('nleft') != 1) {
                    redirect_header("photo.php", 3, _AM_EXTGALLERY_NOT_AN_ALBUM);
                    exit;
                }

                $message = "";

                if(isset($_POST['modify'])) {

                    $toCategories = array();
                    foreach(array_keys($_POST['photoId']) as $photoId) {

                        $data = array(
                                    'cat_id'=>$_POST['catId'][$photoId],
                                    'photo_desc'=>$_POST['photoDesc'][$photoId],
                                    'photo_title'=>$_POST['photoTitre'][$photoId],
                                    'photo_weight'=>$_POST['photoPoids'][$photoId]
                                );
                        $photoHandler->modifyPhoto($photoId, $data);

                        if(!isset($toCategories[$_POST['catId'][$photoId]]))
                            $toCategories[$_POST['catId'][$photoId]] = 0;
                        $toCategories[$_POST['catId'][$photoId]]++;
                    }

                    // Get from and to categories
                    $categories = array();
                    $categories[$_POST['cat_id']] = $catHandler->getCat($_POST['cat_id']);
                    foreach(array_keys($_POST['photoId']) as $photoId) {
                        if($_POST['catId'][$photoId] == $_POST['cat_id'])
                            continue;
                        $categories[$_POST['catId'][$photoId]] = $catHandler->getCat($_POST['catId'][$photoId]);
                    }

                    // Set dest categories as album
                    foreach($toCategories as $k=>$v) {
                        if($categories[$k]->getVar('cat_isalbum') == 0) {
                            $categories[$k]->setVar('cat_isalbum',1);
                            $catHandler->insert($categories[$k]);
                        }
                    }

                    // Get the photo number of the from category
                    $nbPhotoFromCat = $catHandler->nbPhoto($categories[$_POST['cat_id']]);

                    // Update cat counter and is_album for from category
                    if($nbPhotoFromCat == 0) {
                        $categories[$_POST['cat_id']]->setVar('cat_isalbum',0);
                        $catHandler->insert($categories[$_POST['cat_id']]);

                        $criteria = new CriteriaCompo();
                        $criteria->add(new Criteria('nleft',$categories[$_POST['cat_id']]->getVar('nleft'),'<'));
                        $criteria->add(new Criteria('nright',$categories[$_POST['cat_id']]->getVar('nright'),'>'));
                        $catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album - 1', $criteria);
                    }

                    // Update cat counter for to categories
                    foreach($toCategories as $k=>$v) {
                        // Skip from category
                        if($k == $_POST['cat_id'])
                            continue;

                        // If category hasn't photo before the changes
                        if($categories[$k]->getVar('cat_nb_photo') == 0) {
                            $criteria = new CriteriaCompo();
                            $criteria->add(new Criteria('nleft',$categories[$k]->getVar('nleft'),'<'));
                            $criteria->add(new Criteria('nright',$categories[$k]->getVar('nright'),'>'));
                            $catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album + 1', $criteria);
                        }
                    }

                    // Count the number of photo removed from from category and update photo counter for to categories
                    $nbPhotoMoved = 0;
                    foreach($toCategories as $k=>$v) {
                        // Skip from category
                        if($k == $_POST['cat_id'])
                            continue;
                        $nbPhotoMoved += $v;

                        $criteria = new CriteriaCompo();
                        $criteria->add(new Criteria('nleft',$categories[$k]->getVar('nleft'),'<='));
                        $criteria->add(new Criteria('nright',$categories[$k]->getVar('nright'),'>='));
                        $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo + '.$v, $criteria);
                    }

                    // Update the photo counter of the from gallery
                    if($nbPhotoMoved != 0) {
                        $criteria = new CriteriaCompo();
                        $criteria->add(new Criteria('nleft',$categories[$_POST['cat_id']]->getVar('nleft'),'<='));
                        $criteria->add(new Criteria('nright',$categories[$_POST['cat_id']]->getVar('nright'),'>='));
                        $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo - '.$nbPhotoMoved, $criteria);
                    }

                    $message = sprintf(_AM_EXTGALLERY_X_PHOTO_MODIFIED, count($_POST['photoId']));
                } else if(isset($_POST['delete'])) {

                    foreach(array_keys($_POST['photoId']) as $photoId) {
                        $photo = $photoHandler->getPhoto($photoId);
                        $photoHandler->deletePhoto($photo);
                    }

                    $nbPhotoDeleted = count($_POST['photoId']);
                    $cat = $catHandler->getCat($_POST['cat_id']);

                    if($cat->getVar('cat_nb_photo') == $nbPhotoDeleted) {

                        $cat->setVar('cat_isalbum',0);
                        $catHandler->insert($cat);

                        $criteria = new CriteriaCompo();
                        $criteria->add(new Criteria('nleft',$cat->getVar('nleft'),'<'));
                        $criteria->add(new Criteria('nright',$cat->getVar('nright'),'>'));
                        $catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album - 1', $criteria);
                    }

                    $criteria = new CriteriaCompo();
                    $criteria->add(new Criteria('nleft',$cat->getVar('nleft'),'<='));
                    $criteria->add(new Criteria('nright',$cat->getVar('nright'),'>='));
                    $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo - '.$nbPhotoDeleted, $criteria);

                    $message = sprintf(_AM_EXTGALLERY_X_PHOTO_DELETED, count($_POST['photoId']));
                }

                redirect_header("photo.php", 3, $message);

                break;

            case 'default':
            default:

                xoops_cp_header();

                $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
                $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

                $photos = $photoHandler->getAlbumPhotoAdminPage($_GET['cat_id'], $start);
    $nbPhoto = $photoHandler->getAlbumCount($_GET['cat_id']);
                // Check if they are selected photo
                if($nbPhoto < 1) {
                    redirect_header("photo.php",3,_AM_EXTGALLERY_NO_PHOTO_IN_THIS_ALBUM);
                    exit;
                }

                echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_APPROVE.'</legend>'."\n";
                echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>'."\n";
                echo _AM_EXTGALLERY_EDITDELETE_PHOTOTABLE_INFO."\n";
                echo '</fieldset><br />'."\n";

                $pageNav = new XoopsPageNav($nbPhoto, $xoopsModuleConfig['admin_nb_photo'], $start, 'start', 'op=modify&cat_id='.$_GET['cat_id']);
                $globalCatSelect = $catHandler->getLeafSelect('changeAllCat', false, $_GET['cat_id'], ' onChange="return changeAllCategory();"');

                echo '<div style="text-align:right;">'.$pageNav->renderNav().'</div>'."\n";
                echo '<form action="photo.php?op=modify" method="post">'."\n";
                echo '<table class="outer" style="width:100%; text-align:center;"><tr>'."\n";
                echo '<th><input type="checkbox" name="selectAllPhoto" id="selectAllPhoto" onClick="return checkAllPhoto();" /></th>'."\n";
                echo '<th>'._AM_EXTGALLERY_PHOTO.'</th>'."\n";
                echo '<th>'._AM_EXTGALLERY_CATEGORY.'<br />'.$globalCatSelect.'</th>'."\n";
                echo '<th>'._AM_EXTGALLERY_WEIGHT.'</th>'."\n";
                echo '<th>'._AM_EXTGALLERY_TITLE.'<br>';
                echo _AM_EXTGALLERY_DESC.'</th>'."\n";
                echo '</tr>'."\n";

                $i = 0;
                $cat = array();
                $scriptCheckbox = "";
                $scriptSelect = "";
                $first = true;
                foreach($photos as $photo) {

                    $class = (($i++ % 2) == 0) ? 'even' : 'odd';
                    /*if(!isset($cat[$photo->getVar('cat_id')])) {
                        $cat[$photo->getVar('cat_id')] = $catHandler->get($photo->getVar('cat_id'));
                    }*/
                    echo '<tr class="'.$class.'">'."\n";
                    echo '<td><input type="checkbox" name="photoId['.$photo->getVar('photo_id').'][]" id="photoId['.$photo->getVar('photo_id').'][]" /></td>'."\n";
                    echo '<td><img src="'.XOOPS_URL.'/uploads/extgallery/public-photo/thumb/thumb_'.$photo->getVar('photo_name').'" /></td>'."\n";
                    echo '<td>'.$catHandler->getLeafSelect('catId['.$photo->getVar('photo_id').']', false, $_GET['cat_id']).'</td>'."\n";
                    echo '<td><input type="text" name="photoPoids['.$photo->getVar('photo_id').']" id="photoPoids['.$photo->getVar('photo_id').']" value="'.$photo->getVar('photo_weight').'" size="3" maxlength="14" /></td>'."\n";
                    echo '<td><input type="text" name="photoTitre['.$photo->getVar('photo_id').']" id="photoTitre['.$photo->getVar('photo_id').']" value="'.$photo->getVar('photo_title','e').'" size="60" maxlength="150" /><br>'."\n";
                    echo '<textarea name="photoDesc['.$photo->getVar('photo_id').']" id="photoDesc['.$photo->getVar('photo_id').']" rows="1" cols="57">'.$photo->getVar('photo_desc','e').'</textarea></td>'."\n";
                    echo '</tr>'."\n";
                    $scriptCheckbox .= $first ? '\'photoId['.$photo->getVar('photo_id').'][]\'' : ', \'photoId['.$photo->getVar('photo_id').'][]\'' ;
                    $scriptSelect .= $first ? '\'catId['.$photo->getVar('photo_id').']\'' : ', \'catId['.$photo->getVar('photo_id').']\'' ;
                    $first = false;
                }
                echo '<tr><td colspan="4">';
                echo '<input type="hidden" name="cat_id" value="'.$_GET['cat_id'].'" />';
                echo '<input type="hidden" name="step" value="enreg" />';
                echo '<input type="submit" name="modify" value="'._AM_EXTGALLERY_APPLY_CHANGE.'" />&nbsp;&nbsp;<input type="submit" name="delete" value="'._DELETE.'" />';
                echo '</td></tr>';

                echo '</table>'."\n";
                echo '</form>';
                echo '</fieldset><br />'."\n";

                echo '<script type="text/javascript">'."\n";
                echo 'function checkAllPhoto() {'."\n";
                echo 'var optionids = new Array('.$scriptCheckbox.');'."\n";
                echo 'xoopsCheckAllElements(optionids, \'selectAllPhoto\');'."\n";
                echo '}'."\n";
                echo 'function changeAllCategory() {'."\n";
                echo 'var elementIds = new Array('.$scriptSelect.');'."\n";
                echo 'var select_cbox = xoopsGetElementById(\'changeAllCat\');'."\n";
                echo 'for (var i = 0; i < elementIds.length; i++) {'."\n";
                echo 'var e = xoopsGetElementById(elementIds[i]);'."\n";
                echo 'e.selectedIndex = select_cbox.selectedIndex;'."\n";
                echo '}'."\n";
                echo '}'."\n";
                echo '</script>'."\n";

                xoops_cp_footer();

                break;

        }

        break;

    /*case 'approve':

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
        $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

        $photo = $photoHandler->getPhoto($_GET['id']);
        $photo->setVar('photo_approve',1);
        $photoHandler->insert($photo, true);

        $cat = $catHandler->getCat($photo->getVar('cat_id'));

        $notification_handler =& xoops_gethandler('notification');
        $extraTags = array(
                        'X_ITEM_CAT'=>$cat->getVar('cat_name'),
                        'X_ITEM_NBPHOTO'=>1,
                        'X_ITEM_URL'=>XOOPS_URL."/modules/extgallery/public-album.php?id=".$cat->getVar('cat_id')
                    );
        $notification_handler->triggerEvent('global', 0, 'new_photo',$extraTags);
        $notification_handler->triggerEvent('album', $cat->getVar('cat_id'), 'new_photo_album',$extraTags);

        //redirect_header("photo.php");

        break;*/

    /*case 'delete':

        $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

        $photo = $photoHandler->getPhoto($_GET['id']);
        $photoHandler->deletePhoto($photo);

        redirect_header("photo.php", 3, _AM_EXTGALLERY_PHOTO_MODIFIED);

        break;*/

    case 'default':
    default:

        $catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
        $photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

        xoops_cp_header();
      
      include_once '../include/functions.php';
      
      echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_ADD_PHOTO.'</legend>';
      
      $form = new XoopsThemeForm(_AM_EXTGALLERY_UPLOAD, 'add_photo', 'photo.php?op=add_photo', 'post', true);
        //$form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->addElement(new XoopsFormLabel(_AM_EXTGALLERY_ALBUMS, $catHandler->getLeafSelect('cat_id', false, 0, "", "public_upload")));
        //DNPROSSI - editors
        $form->addElement(new XoopsFormText(_AM_EXTGALLERY_PHOTO_TITLE, 'photo_title', '50', '150'),false);
        $editor = gal_getWysiwygForm(_AM_EXTGALLERY_DESC, 'photo_desc', '', 15, 60, '100%', '350px', 'hometext_hidden');
        $form->addElement($editor, false);
        $form->addElement(new XoopsFormFile(_AM_EXTGALLERY_PHOTO, 'photo_file', $xoopsModuleConfig['max_photosize']),false);
        if($xoopsModuleConfig['display_extra_field']) {
            $form->addElement(new XoopsFormTextArea(_AM_EXTGALLERY_EXTRA_INFO, "photo_extra"));
        }
        // For xoops tag
        if (($xoopsModuleConfig['usetag'] == 1) and (is_dir('../../tag'))){
          require_once XOOPS_ROOT_PATH.'/modules/tag/include/formtag.php';
          $form->addElement(new XoopsFormTag('tag', 60, 255, '', 0));
      }
        $form->addElement(new XoopsFormHidden("op", 'add_photo'));
        $form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
        $form->display();
        
        echo '</fieldset><br />';
        
        $nbPhotos = 0;

        $rep = XOOPS_ROOT_PATH.'/modules/extgallery/batch/';
        $dir = opendir($rep);
        while ($f = readdir($dir)) {
            if(is_file($rep.$f)) {
                if(preg_match("/.*gif/",strtolower($f)) || preg_match("/.*jpg/",strtolower($f)) || preg_match("/.*jpeg/",strtolower($f)) ||preg_match("/.*png/",strtolower($f))) {
                    $nbPhotos++;
                }
            }
        }

        // Batch upload
        echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_ADD_BATCH.'</legend>';

        echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>';
        echo '<b>'._AM_EXTGALLERY_BATCH_PATH.'</b> : '.XOOPS_ROOT_PATH.'/modules/extgallery/batch/<br /><br />'.sprintf(_AM_EXTGALLERY_ADD_BATCH_INFO, $nbPhotos);
        echo '</fieldset><br />';

        $form = new XoopsThemeForm(_AM_EXTGALLERY_ADD_BATCH, 'batch_photo', 'photo.php?op=batchAdd', 'post', true);
        $form->addElement(new XoopsFormLabel(_AM_EXTGALLERY_ALBUM, $catHandler->getLeafSelect('cat_id')));
        $form->addElement(new XoopsFormText(_AM_EXTGALLERY_DESC, 'photo_desc', '70', '255'),false);
        $form->addElement(new XoopsFormHidden("step", 'enreg'));
        $form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
        $form->display();

        echo '</fieldset><br />';

  // Rebuild thumbnail
        echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_REBUILD_THUMB.'</legend>';

        echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>';
        echo _AM_EXTGALLERY_REBUILD_THUMB_INFO;
        echo '</fieldset><br />';

        $form = new XoopsThemeForm(_AM_EXTGALLERY_REBUILD_THUMB, 'rebuild_thumb', 'photo.php', 'get', true);
        $form->addElement(new XoopsFormLabel(_AM_EXTGALLERY_ALBUM, $catHandler->getSelect('cat_id', 'node')));
        $form->addElement(new XoopsFormHidden("op", 'rebuildthumb'));
        $form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
        $form->display();

        echo '</fieldset><br />';
  
        // Edit/delete photo
        echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_EDITDELETE_PHOTO.'</legend>';

        echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>';
        echo _AM_EXTGALLERY_EDITDELETE_PHOTO_INFO;
        echo '</fieldset><br />';

        $form = new XoopsThemeForm(_AM_EXTGALLERY_EDITDELETE_PHOTO, 'modify_photo', 'photo.php', 'get', true);
        $form->addElement(new XoopsFormLabel(_AM_EXTGALLERY_ALBUM, $catHandler->getSelect('cat_id', 'node')));
        $form->addElement(new XoopsFormHidden("op", 'modify'));
        $form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
        $form->display();

        echo '</fieldset><br />';

        // Pending photo
        echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_PENDING_PHOTO.'</legend>';
        echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>';
        //echo '<img src="../images/on.png" style="vertical-align:middle;" />&nbsp;&nbsp;'._AM_EXTGALLERY_APPROVE_INFO.'<br />';
        echo '<img src="../images/edit.png" style="vertical-align:middle;" />&nbsp;&nbsp;'._AM_EXTGALLERY_EDIT_INFO.'<br />';
        echo '<img src="../images/delete.png" style="vertical-align:middle;" />&nbsp;&nbsp;'._AM_EXTGALLERY_DELETE_INFO;
        echo '</fieldset><br />';

        $pendingPhoto = $photoHandler->getPendingPhoto();
        $pageNav = new XoopsPageNav(count($pendingPhoto), $xoopsModuleConfig['admin_nb_photo'], $start);

        echo '<div id="pending-photo" style="text-align:right;">'.$pageNav->renderNav().'</div>';
        echo '<form action="photo.php?op=batchApprove" method="post">';
        echo '<table class="outer" style="width:100%; text-align:center;"><tr>'."\n";
        echo '<th><input type="checkbox" name="selectAllPhoto" id="selectAllPhoto" onClick="return checkAllPhoto();" /></th>'."\n";
        echo '<th>'._AM_EXTGALLERY_PHOTO.'</th>'."\n";
        echo '<th>'._AM_EXTGALLERY_CATEGORY.'</th>'."\n";
        echo '<th>'._AM_EXTGALLERY_TITLE.'</th>'."\n";
        echo '<th>'._AM_EXTGALLERY_DESC.'</th>'."\n";
        echo '<th>'._AM_EXTGALLERY_ACTION.'</th>'."\n";
        echo '</tr>'."\n";
        $i = 0;
        $cat = array();
        $script = "";
        $first = true;
        foreach($pendingPhoto as $photo) {

            if(++$i < $start+1 || $i > ($start + $xoopsModuleConfig['admin_nb_photo'])) {
                continue;
            }
            $class = (($i%2) == 0) ? 'even' : 'odd';
            if(!isset($cat[$photo->getVar('cat_id')])) {
                $cat[$photo->getVar('cat_id')] = $catHandler->get($photo->getVar('cat_id'));
            }
            echo '<tr class="'.$class.'">'."\n";
            echo '<td><input type="checkbox" name="photoId['.$photo->getVar('photo_id').']" id="photoId['.$photo->getVar('photo_id').']" /></td>'."\n";
            echo '<td><img src="'.XOOPS_URL.'/uploads/extgallery/public-photo/thumb/thumb_'.$photo->getVar('photo_name').'" /></td>'."\n";
            echo '<td>'.$cat[$photo->getVar('cat_id')]->getVar('cat_name').'</td>'."\n";
            echo '<td>'.$photo->getVar('photo_title').'</td>'."\n";
            echo '<td>'.$photo->getVar('photo_desc').'</td>'."\n";
            echo '<td>'."\n";
            //echo '<a href="photo.php?op=approve&id='.$photo->getVar('photo_id').'"><img src="../images/on.png" style="vertical-align:middle;" /></a>&nbsp;&nbsp;'."\n";
            echo '<a href="photo.php?op=modify&id='.$photo->getVar('photo_id').'"><img src="../images/edit.png" style="vertical-align:middle;" /></a>&nbsp;'."\n";
            echo '<a href="photo.php?op=delete&id='.$photo->getVar('photo_id').'"><img src="../images/delete.png" style="vertical-align:middle;" /></a>'."\n";
            echo '</td>'."\n";
            echo '</tr>'."\n";
            $script .= $first ? '\'photoId['.$photo->getVar('photo_id').']\'' : ', \'photoId['.$photo->getVar('photo_id').']\'' ;
            $first = false;
        }
        echo '<tr><td colspan="5">';
        echo '<input type="submit" name="approve" value="'._AM_EXTGALLERY_APPROVE.'" />&nbsp;&nbsp;<input type="submit" name="delete" value="'._DELETE.'" />';
        echo '</td></tr>';

        echo '</table>'."\n";
        echo '</form>';
        echo '</fieldset><br />'."\n";

        echo '<script type="text/javascript">'."\n";
        echo 'function checkAllPhoto() {'."\n";
        echo 'var optionids = new Array('.$script.');'."\n";
        echo 'xoopsCheckAllElements(optionids, \'selectAllPhoto\');'."\n";
        echo '}'."\n";
        echo '</script>'."\n";

        xoops_cp_footer();

        break;

}
