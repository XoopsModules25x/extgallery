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
 * @copyright   {@link https://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */


use XoopsModules\Extgallery;

include __DIR__ . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
//require_once __DIR__ . '/class/Utility.php';

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = 'default';
}

if (isset($_POST['step'])) {
    $step = $_POST['step'];
} else {
    $step = 'default';
}

if (!isset($GLOBALS['xoopsUser'])) {
    redirect_header('index.php');
} elseif (!$GLOBALS['xoopsUser']->isAdmin()) {
    redirect_header('index.php');
}
$moduleDirName = basename(__DIR__);
$utility  = new Extgallery\Utility();
switch ($op) {

    case 'edit':

        switch ($step) {

            case 'enreg':
                /** @var Extgallery\PublicPhotoHandler $photoHandler */
                $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
                $myts         = \MyTextSanitizer::getInstance();
                $photo        = $photoHandler->getPhoto($_POST['photo_id']);

                $data['cat_id']       = $_POST['cat_id'];
                $data['photo_desc']   = $_POST['photo_desc'];
                $data['photo_title']  = $_POST['photo_title'];
                $data['photo_weight'] = $_POST['photo_weight'];

                if (isset($_POST['photo_extra'])) {
                    $data['photo_extra'] = $_POST['photo_extra'];
                }

                $photoHandler->modifyPhoto((int)$_POST['photo_id'], $data);

                // For xoops tag
                if ((1 == $xoopsModuleConfig['usetag']) && is_dir('../tag')) {
                    $tagHandler = \XoopsModules\Tag\Helper::getInstance()->getHandler('Tag'); // xoops_getModuleHandler('tag', 'tag');
                    $tagHandler->updateByItem($_POST['tag'], $_POST['photo_id'], $xoopsModule->getVar('dirname'), 0);
                }

                // If the photo category change
                if ($photo->getVar('cat_id') != $_POST['cat_id']) {
                    $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
                    $oldCat     = $catHandler->getCat($photo->getVar('cat_id'));
                    $newCat     = $catHandler->getCat($_POST['cat_id']);

                    // Set new category as album
                    $catHandler->modifyCat(['cat_id' => (int)$_POST['cat_id'], 'cat_isalbum' => 1]);

                    // Update album count
                    if (1 == $oldCat->getVar('cat_nb_photo')) {
                        $criteria = new \CriteriaCompo();
                        $criteria->add(new \Criteria('nleft', $oldCat->getVar('nleft'), '<'));
                        $criteria->add(new \Criteria('nright', $oldCat->getVar('nright'), '>'));
                        $catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album - 1', $criteria);
                    }

                    if (0 == $newCat->getVar('cat_nb_photo')) {
                        $criteria = new \CriteriaCompo();
                        $criteria->add(new \Criteria('nleft', $newCat->getVar('nleft'), '<'));
                        $criteria->add(new \Criteria('nright', $newCat->getVar('nright'), '>'));
                        $catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album + 1', $criteria);
                    }

                    // Update photo count
                    $criteria = new \CriteriaCompo();
                    $criteria->add(new \Criteria('nleft', $newCat->getVar('nleft'), '<='));
                    $criteria->add(new \Criteria('nright', $newCat->getVar('nright'), '>='));
                    $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo + 1', $criteria);

                    $criteria = new \CriteriaCompo();
                    $criteria->add(new \Criteria('nleft', $oldCat->getVar('nleft'), '<='));
                    $criteria->add(new \Criteria('nright', $oldCat->getVar('nright'), '>='));
                    $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo - 1', $criteria);

                    // If the old album don't contains other photo
                    if (0 == $photoHandler->nbPhoto($oldCat)) {
                        $catHandler->modifyCat(['cat_id' => $photo->getVar('cat_id'), 'cat_isalbum' => 0]);
                        redirect_header('public-categories.php?id=' . $photo->getVar('cat_id'), 3, _MD_EXTGALLERY_PHOTO_UPDATED);
                    } else {
                        redirect_header('public-album.php?id=' . $photo->getVar('cat_id'), 3, _MD_EXTGALLERY_PHOTO_UPDATED);
                    }
                } else {
                    redirect_header('public-photo.php?photoId=' . $photo->getVar('photo_id'), 3, _MD_EXTGALLERY_PHOTO_UPDATED);
                }

                break;

            case 'default':
            default:

                require_once XOOPS_ROOT_PATH . '/header.php';
                $myts = \MyTextSanitizer::getInstance();
                /** @var Extgallery\PublicCategoryHandler $catHandler */
                $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
                /** @var Extgallery\PublicPhotoHandler $photoHandler */
                $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

                $photo = $photoHandler->getPhoto((int)$_GET['id']);

                echo '<img src="' . XOOPS_URL . '/uploads/extgallery/public-photo/thumb/thumb_' . $photo->getVar('photo_name') . '">';

                $form = new \XoopsThemeForm(_MD_EXTGALLERY_MODIFY_PHOTO, 'add_photo', 'public-modify.php?op=edit', 'post', true);
                $form->addElement(new \XoopsFormLabel(_MD_EXTGALLERY_CATEGORY, $catHandler->getLeafSelect('cat_id', false, $photo->getVar('cat_id'))));
                $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_PHOTO_WEIGHT, 'photo_weight', '3', '11', $photo->getVar('photo_weight')), false);
                $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_PHOTO_TITLE, 'photo_title', '50', '150', $photo->getVar('photo_title')), false);
                //DNPROSSI - wysiwyg editors from xoopseditors
                //TODO dohtml - dobr
                $photo_desc = $myts->displayTarea($photo->getVar('photo_desc'), 0, 1, 1, 1, 0);
                $editor     = $utility::getWysiwygForm(_MD_EXTGALLERY_DESC, 'photo_desc', $photo_desc, 15, 60, '100%', '350px', 'hometext_hidden');
                $form->addElement($editor, false);
                if ($xoopsModuleConfig['display_extra_field']) {
                    $form->addElement(new \XoopsFormTextArea(_MD_EXTGALLERY_EXTRA_INFO, 'photo_extra', $photo->getVar('photo_extra')));
                }

                // For xoops tag
                if ((1 == $xoopsModuleConfig['usetag']) && is_dir('../tag')) {
                    $tagId = $photo->isNew() ? 0 : $photo->getVar('photo_id');
                    require_once XOOPS_ROOT_PATH . '/modules/tag/include/formtag.php';
                    $form->addElement(new TagFormTag('tag', 60, 255, $tagId, 0));
                }

                $form->addElement(new \XoopsFormHidden('photo_id', $_GET['id']));
                $form->addElement(new \XoopsFormHidden('step', 'enreg'));
                $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
                $form->display();

                include XOOPS_ROOT_PATH . '/footer.php';

                break;

        }

        break;

    case 'delete':
        /** @var Extgallery\PublicCategoryHandler $catHandler */
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
        /** @var Extgallery\PublicPhotoHandler $photoHandler */
        $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

        $photo = $photoHandler->getPhoto((int)$_GET['id']);
        $photoHandler->deletePhoto($photo);

        $cat = $catHandler->getCat($photo->getVar('cat_id'));

        // Update photo count
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('nleft', $cat->getVar('nleft'), '<='));
        $criteria->add(new \Criteria('nright', $cat->getVar('nright'), '>='));
        $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo - 1', $criteria);

        if (1 == $cat->getVar('cat_nb_photo')) {

            // Update album count
            $criteria = new \CriteriaCompo();
            $criteria->add(new \Criteria('nleft', $cat->getVar('nleft'), '<'));
            $criteria->add(new \Criteria('nright', $cat->getVar('nright'), '>'));
            $catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album - 1', $criteria);

            $catHandler->modifyCat(['cat_id' => $photo->getVar('cat_id'), 'cat_isalbum' => 0]);

            redirect_header('public-categories.php?id=' . $photo->getVar('cat_id'));
        } else {
            redirect_header('public-album.php?id=' . $photo->getVar('cat_id'));
        }

        break;

}
