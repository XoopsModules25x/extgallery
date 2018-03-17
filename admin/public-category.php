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
 * @copyright   {@link https://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */

use XoopsModules\Extgallery;

require_once __DIR__ . '/admin_header.php';

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

switch ($op) {

    case 'create':

        switch ($step) {

            case 'enreg':

                /** @var Extgallery\PublicCategoryHandler $catHandler */
                $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
                $data       = [
                    'cat_pid'    => $_POST['cat_pid'],
                    'cat_name'   => $_POST['cat_name'],
                    'cat_desc'   => $_POST['cat_desc'],
                    'cat_weight' => $_POST['cat_weight'],
                    'cat_date'   => time(),
                    'cat_imgurl' => $_POST['cat_imgurl']
                ];
                $catHandler->createCat($data);

                redirect_header('public-category.php', 3, _AM_EXTGALLERY_CAT_CREATED);

                break;

        }

        break;

    case 'modify':

        switch ($step) {

            case 'enreg':

                if (isset($_POST['submit'])) {
                    $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
                    $catHandler->modifyCat($_POST);

                    redirect_header('public-category.php', 3, _AM_EXTGALLERY_CAT_MODIFIED);
                } elseif ($_POST['delete']) {
                    xoops_cp_header();

                    xoops_confirm(['cat_id' => $_POST['cat_id'], 'step' => 'enreg'], 'public-category.php?op=delete', _AM_EXTGALLERY_DELETE_CAT_CONFIRM);
                    //                    xoops_cp_footer();
                    require_once __DIR__ . '/admin_footer.php';
                }

                break;

            case 'default':
            default:

                // Check if they are selected category
                if (!isset($_POST['cat_id'])) {
                    redirect_header('photo.php', 3, _AM_EXTGALLERY_NO_CATEGORY_SELECTED);
                }

                $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
                /** @var Extgallery\PublicPhotoHandler $photoHandler */
                $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

                $cat       = $catHandler->getCat($_POST['cat_id']);
                $photosCat = $photoHandler->getCatPhoto($cat);

                xoops_cp_header();

                $selectedPhoto = '../assets/images/blank.gif';
                $photoArray    = [];
                foreach ($photosCat as $photo) {
                    if ('' != $photo->getVar('photo_serveur')) {
                        $url = $photo->getVar('photo_serveur') . 'thumb_' . $photo->getVar('photo_name');
                    } else {
                        $url = XOOPS_URL . '/uploads/extgallery/public-photo/thumb/thumb_' . $photo->getVar('photo_name');
                    }
                    if ($photo->getVar('photo_id') == $cat->getVar('photo_id')) {
                        $selectedPhoto = $url;
                    }
                    $photoArray[$photo->getVar('photo_id')] = $url;
                }

                echo "<script type='text/JavaScript'>";
                echo 'function ChangeThumb() {

                            var formSelect;
                            var thumb = new Array();';

                echo "thumb[0] = '../assets/images/blank.gif';\n";
                foreach ($photoArray as $k => $v) {
                    echo 'thumb[' . $k . "] = '" . $v . "';\n";
                }

                echo "formSelect = document.getElementById('photo_id');

                            document.getElementById('thumb').src = thumb[formSelect.options[formSelect.selectedIndex].value];
                        }";
                echo '</script>';

                $photoSelect = "\n" . '<select size="1" name="photo_id" id="photo_id" onChange="ChangeThumb();" onkeydown="ChangeThumb();">' . "\n";
                $photoSelect .= '<option value="0">&nbsp;</option>' . "\n";
                foreach ($photosCat as $photo) {
                    if ($photo->getVar('photo_id') == $cat->getVar('photo_id')) {
                        $photoSelect .= '<option value="' . $photo->getVar('photo_id') . '" selected>' . $photo->getVar('photo_title') . ' (' . $photo->getVar('photo_name') . ')</option>' . "\n";
                    } else {
                        $photoSelect .= '<option value="' . $photo->getVar('photo_id') . '">' . $photo->getVar('photo_title') . ' (' . $photo->getVar('photo_name') . ')</option>' . "\n";
                    }
                }
                $photoSelect .= '</select>' . "\n";

                $form = new \XoopsThemeForm(_AM_EXTGALLERY_MOD_PUBLIC_CAT, 'create_cat', 'public-category.php?op=modify', 'post', true);
                $form->addElement(new \XoopsFormLabel(_AM_EXTGALLERY_PARENT_CAT, $catHandler->getSelect('cat_pid', 'leaf', true, $cat->getVar('cat_pid'))));
                $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_NAME, 'cat_name', '70', '255', $cat->getVar('cat_name', 'e')), false);
                $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_WEIGHT, 'cat_weight', '4', '4', $cat->getVar('cat_weight')), false);
                $form->addElement(new \XoopsFormDhtmlTextArea(_AM_EXTGALLERY_DESC, 'cat_desc', $cat->getVar('cat_desc', 'e')), false);
                $elementTrayThumb = new \XoopsFormElementTray(_AM_EXTGALLERY_THUMB);
                $elementTrayThumb->addElement(new \XoopsFormLabel('', $photoSelect . "<img style=\"float:left; margin-top:5px;\" id=\"thumb\" src=\"$selectedPhoto\">"));
                $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_CAT_IMG, 'cat_imgurl', '70', '150', $cat->getVar('cat_imgurl', 'e')), false);
                $form->addElement($elementTrayThumb);
                $elementTrayButton = new \XoopsFormElementTray('');
                $elementTrayButton->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
                $elementTrayButton->addElement(new \XoopsFormButton('', 'delete', _DELETE, 'submit'));
                $form->addElement($elementTrayButton);
                $form->addElement(new \XoopsFormHidden('cat_id', $_POST['cat_id']));
                $form->addElement(new \XoopsFormHidden('step', 'enreg'));
                $xoopsTpl->assign('formmodifcat', $form->render());

                $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/extgallery/templates/admin/extgallery_admin_public_category.tpl');

                //                xoops_cp_footer();
                require_once __DIR__ . '/admin_footer.php';

                break;

        }

        break;

    case 'delete':

        switch ($step) {

            case 'enreg':

                $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

                $catHandler->deleteCat($_POST['cat_id']);

                redirect_header('public-category.php', 3, _AM_EXTGALLERY_CAT_DELETED);

                break;

        }

        break;

    case 'default':
    default:

        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        xoops_cp_header();

        $form = new \XoopsThemeForm(_AM_EXTGALLERY_MODDELETE_PUBLICCAT, 'modify_cat', 'public-category.php?op=modify', 'post', true);
        $form->addElement(new \XoopsFormLabel(_AM_EXTGALLERY_CATEGORY, $catHandler->getSelect('cat_id', false, false, 0, '', true)));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('formselectcat', $form->render());

        $form = new \XoopsThemeForm(_AM_EXTGALLERY_ADD_PUBLIC_CAT, 'create_cat', 'public-category.php?op=create', 'post', true);
        $form->addElement(new \XoopsFormLabel(_AM_EXTGALLERY_PARENT_CAT, $catHandler->getSelect('cat_pid', 'leaf', true)));
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_NAME, 'cat_name', '70', '255'), true);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_WEIGHT, 'cat_weight', '4', '4'), false);
        $form->addElement(new \XoopsFormDhtmlTextArea(_AM_EXTGALLERY_DESC, 'cat_desc', ''), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_CAT_IMG, 'cat_imgurl', '70', '150'), false);
        $form->addElement(new \XoopsFormHidden('step', 'enreg'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('formcreatecat', $form->render());

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/extgallery/templates/admin/extgallery_admin_public_category.tpl');
        //        xoops_cp_footer();
        require_once __DIR__ . '/admin_footer.php';
        break;

}
