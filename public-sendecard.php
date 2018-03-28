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

if (isset($_GET['id'])) {
    $photoId = (int)$_GET['id'];
} elseif (isset($_POST['photo_id'])) {
    $photoId = (int)$_POST['photo_id'];
} else {
    $photoId = 0;
}
if (isset($_POST['step'])) {
    $step = $_POST['step'];
} else {
    $step = 'default';
}
/** @var Extgallery\PublicPhotoHandler $photoHandler */
$photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
$photo        = $photoHandler->getPhoto($photoId);

$permHandler = Extgallery\PublicPermHandler::getInstance();

if (!$permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_ecard', $photo->getVar('cat_id'))) {
    redirect_header('index.php', 3, _MD_EXTGALLERY_NOPERM);
}
/** @var xos_opal_Theme $xoTheme */
switch ($step) {

    case 'send':

//        require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/php-captcha.inc.php';

        // Enable captcha only if GD is Used
        if ('gd' === $xoopsModuleConfig['graphic_lib']) {
            if (!Extgallery\PhpCaptcha::Validate($_POST['captcha'])) {
                redirect_header('public-photo.php?photoId=' . $photoId . '#photoNav', 3, _MD_EXTGALLERY_CAPTCHA_ERROR);
            }
        }
        /** @var Extgallery\PublicEcardHandler $ecardHandler */
        $ecardHandler = Extgallery\Helper::getInstance()->getHandler('PublicEcard');
        /** @var Extgallery\PublicPhotoHandler $photoHandler */
        $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $data = [
            'ecard_fromname'  => $_POST['ecard_fromname'],
            'ecard_fromemail' => $_POST['ecard_fromemail'],
            'ecard_toname'    => $_POST['ecard_toname'],
            'ecard_toemail'   => $_POST['ecard_toemail'],
            'ecard_greetings' => $_POST['ecard_greetings'],
            'ecard_desc'      => $_POST['ecard_desc'],
            'ecard_ip'        => $ip,
            'photo_id'        => $photoId
        ];

        $ecardHandler->createEcard($data);
        $photoHandler->updateEcard($photoId);

        redirect_header('public-photo.php?photoId=' . $photoId . '#photoNav', 3, _MD_EXTGALLERY_ECARD_SENT);

        break;

    case 'default':
    default:

        $GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-sendecard.tpl';
        include XOOPS_ROOT_PATH . '/header.php';

        if ('' != $photo->getVar('photo_serveur')) {
            $photoUrl = $photo->getVar('photo_serveur') . 'thumb_' . $photo->getVar('photo_name');
        } else {
            $photoUrl = XOOPS_URL . '/uploads/extgallery/public-photo/thumb/thumb_' . $photo->getVar('photo_name');
        }

        $fromName  = is_a($GLOBALS['xoopsUser'], 'XoopsUser') ? $GLOBALS['xoopsUser']->getVar('uname') : '';
        $fromEmail = is_a($GLOBALS['xoopsUser'], 'XoopsUser') ? $GLOBALS['xoopsUser']->getVar('email') : '';

        $form = new \XoopsThemeForm(_MD_EXTGALLERY_SEND_ECARD, 'send_ecard', 'public-sendecard.php', 'post', true);
        $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_FROM_NAME, 'ecard_fromname', '70', '255', $fromName), false);
        $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_FROM_EMAIL, 'ecard_fromemail', '70', '255', $fromEmail), false);
        $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_TO_NAME, 'ecard_toname', '70', '255', ''), false);
        $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_TO_EMAIL, 'ecard_toemail', '70', '255', ''), false);
        $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_GREETINGS, 'ecard_greetings', '110', '255', ''), false);
        $form->addElement(new \XoopsFormTextArea(_MD_EXTGALLERY_DESC, 'ecard_desc', ''), false);
        // Enable captcha only if GD is Used
        if ('gd' === $xoopsModuleConfig['graphic_lib']) {
            $form->addElement(new \XoopsFormText(_MD_EXTGALLERY_SECURITY, 'captcha', '10', '5', ''), false);
        }
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $form->addElement(new \XoopsFormHidden('photo_id', $photoId));
        $form->addElement(new \XoopsFormHidden('step', 'send'));
        $form->assign($xoopsTpl);

        $xoopsTpl->assign('photo', $photoUrl);
        $xoopsTpl->assign('xoops_pagetitle', 'Send ' . $photo->getVar('photo_desc') . ' to eCard');
        $xoTheme->addMeta('meta', 'description', $photo->getVar('photo_desc'));

        $rel                 = 'alternate';
        $attributes['rel']   = $rel;
        $attributes['type']  = 'application/rss+xml';
        $attributes['title'] = _MD_EXTGALLERY_RSS;
        $attributes['href']  = XOOPS_URL . '/modules/extgallery/public-rss.php';
        $xoTheme->addMeta('link', $rel, $attributes);
        $xoTheme->addStylesheet('modules/extgallery/assets/css/style.css');

        $lang = [
            'to'   => _MD_EXTGALLERY_TO,
            'from' => _MD_EXTGALLERY_FROM
        ];
        $xoopsTpl->assign('lang', $lang);

        include XOOPS_ROOT_PATH . '/footer.php';

        break;

}
