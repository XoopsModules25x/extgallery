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
//require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
//require_once __DIR__ . '/class/Utility.php';

if (isset($_POST['step'])) {
    $step = $_POST['step'];
} else {
    $step = 'default';
}

$permHandler = Extgallery\PublicPermHandler::getInstance();
if (count($permHandler->getAuthorizedPublicCat($GLOBALS['xoopsUser'], 'public_upload')) < 1) {
    redirect_header('index.php', 3, _MD_EXTGALLERY_NOPERM);
}

$moduleDirName = basename(__DIR__);
$utility = new Extgallery\Utility();
switch ($step) {

    case 'enreg':
        /** @var Extgallery\PublicPhotoHandler $photoHandler */
        $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

        $result = $photoHandler->postPhotoTraitement('photo_file', false);

        if (2 == $result) {
            redirect_header('public-upload.php', 3, _MD_EXTGALLERY_NOT_AN_ALBUM);
        } elseif (4 == $result || 5 == $result) {
            redirect_header('public-upload.php', 3, _MD_EXTGALLERY_UPLOAD_ERROR . ' :<br>' . $photoHandler->photoUploader->getError());
        } elseif (0 == $result) {
            redirect_header('public-upload.php', 3, _MD_EXTGALLERY_PHOTO_UPLOADED);
        } elseif (1 == $result) {
            redirect_header('public-upload.php', 3, _MD_EXTGALLERY_PHOTO_PENDING);
        }

        break;

    case 'default':
    default:

        require_once XOOPS_ROOT_PATH . '/header.php';

        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $form = new \XoopsThemeForm(_MD_EXTGALLERY_PUBLIC_UPLOAD, 'add_photo', 'public-upload.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->addElement(new \XoopsFormLabel(_MD_EXTGALLERY_ALBUMS, $catHandler->getLeafSelect('cat_id', false, 0, '', 'public_upload')));

        //DNPROSSI - editors
        $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_PHOTO_TITLE, 'photo_title', '50', '150'), false);
        $editor = $utility::getWysiwygForm(_MD_EXTGALLERY_DESC, 'photo_desc', '', 15, 60, '100%', '350px', 'hometext_hidden');
        $form->addElement($editor, false);

        $form->addElement(new \XoopsFormFile(_MD_EXTGALLERY_PHOTO, 'photo_file', $xoopsModuleConfig['max_photosize']), false);
        if ($xoopsModuleConfig['display_extra_field']) {
            $form->addElement(new \XoopsFormTextArea(_MD_EXTGALLERY_EXTRA_INFO, 'photo_extra'));
        }

        // For xoops tag
        if ((1 == $xoopsModuleConfig['usetag']) && is_dir('../tag')) {
            require_once XOOPS_ROOT_PATH . '/modules/tag/include/formtag.php';
            $form->addElement(new TagFormTag('tag', 60, 255, '', 0));
        }

        $plugin = Extgallery\Helper::getInstance()->getHandler('Plugin');
        $plugin->triggerEvent('photoForm', $form);

        $form->addElement(new \XoopsFormHidden('step', 'enreg'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        $form->display();

        include XOOPS_ROOT_PATH . '/footer.php';

        break;

}
