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

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-viewecard.tpl';
include XOOPS_ROOT_PATH . '/header.php';

$myts = \MyTextSanitizer::getInstance();

if (isset($_GET['id'])) {
    $ecardId = $myts->addSlashes($_GET['id']);
} else {
    $ecardId = 0;
}

$ecardHandler = Extgallery\Helper::getInstance()->getHandler('PublicEcard');

$ecardObj = $ecardHandler->getEcard($ecardId);

// Check is the photo exist
if (!$ecardObj) {
    redirect_header('index.php', 3, _NOPERM);
}

$ecard = $ecardHandler->objectToArray($ecardObj, ['photo_id']);

if ('' == $ecard['photo']['photo_serveur']) {
    $ecard['photoUrl'] = XOOPS_URL . '/uploads/extgallery/public-photo/medium/' . $ecard['photo']['photo_name'];
} else {
    $ecard['photoUrl'] = $ecard['photo']['photo_serveur'] . $ecard['photo']['photo_name'];
}

$xoopsTpl->assign('ecard', $ecard);

$rel                 = 'alternate';
$attributes['rel']   = $rel;
$attributes['type']  = 'application/rss+xml';
$attributes['title'] = _MD_EXTGALLERY_RSS;
$attributes['href']  = XOOPS_URL . '/modules/extgallery/public-rss.php';
$xoTheme->addMeta('link', $rel, $attributes);
$xoTheme->addStylesheet('modules/extgallery/assets/css/style.css');

$lang = [
    'clickFormMore' => _MD_EXTGALLERY_CLICK_FOR_MORE
];
$xoopsTpl->assign('lang', $lang);

include XOOPS_ROOT_PATH . '/footer.php';
