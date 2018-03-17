<?php
/**
 * ExtGallery Block settings
 * Manage all Blocks
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
 * @param $options
 * @return array
 */

use XoopsModules\Extgallery;

// Manage photo blocks
/**
 * @param $options
 * @return array
 */
function extgalleryPhotoShow($options)
{
    global $xoopsConfig;
    $photos = [];

    /** @var Extgallery\PhotoHandler $photoHandler */
    $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

    $param                = ['limit' => $options[0]];
    $direction            = $options[1];
    $title                = $options[2];
    $photoHandlertype     = $options[3];
    $jquery               = $options[4];
    $ajaxeffect           = $options[5];
    $overlyabg            = $options[6];
    $overlyaw             = $options[7];
    $overlyah             = $options[8];
    $tooltipw             = $options[9];
    $tooltipbw            = $options[10];
    $tooltipbbg           = $options[11];
    $fancyboxbg           = $options[12];
    $fancyboxop           = $options[13];
    $fancyboxtin          = $options[14];
    $fancyboxtout         = $options[15];
    $fancyboxtp           = $options[16];
    $fancyboxshow         = $options[17];
    $prettyphotospeed     = $options[18];
    $prettyphototheme     = $options[19];
    $prettyphotoslidspeed = $options[20];
    $prettyphotoautoplay  = $options[21];
    $jcarouselhwidth      = $options[22];
    $jcarouselvwidth      = $options[23];
    $jcarouselvheight     = $options[24];
    $column               = $options[25];

    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $categories = [];
    foreach ($options as $cat) {
        if (0 == $cat) {
            $categories = [];
            break;
        }
        $categories[] = $cat;
    }
    $param['cat'] = $categories;

    switch ($photoHandlertype) {
        case 'RandomPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getRandomPhoto($param));
            break;

        case 'LastPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getLastPhoto($param));
            break;

        case 'TopViewPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopViewPhoto($param));
            break;

        case 'TopRatedPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopRatedPhoto($param));
            break;

        case 'TopEcardPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopEcardPhoto($param));
            break;
    }

    if ('true' === $jquery && 'none' !== $ajaxeffect) {
        global $xoTheme;
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

        switch ($ajaxeffect) {
            case 'lightbox':
                $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.lightbox.js');
                $xoTheme->addStylesheet('browse.php?modules/system/css/lightbox.css');
                break;
            case 'tooltip':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/tooltip/image.tooltip.js');
                $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/tooltip/image.tooltip.css');
                break;
            case 'overlay':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/overlay/overlay.jquery.tools.min.js');
                $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/overlay/overlay.css');
                break;
            case 'fancybox':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/fancybox/mousewheel.js');
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/fancybox/fancybox.pack.js');
                $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/fancybox/fancybox.css');
                break;
            case 'prettyphoto':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/prettyphoto/jquery.prettyPhoto.js');
                $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/prettyphoto/prettyPhoto.css');
                break;
            case 'jcarousel':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/jcarousel/jquery.jcarousel.min.js');
                $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/jcarousel/skin.css');
                break;
            case 'TosRUs':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/TosRUs/src/js/jquery.tosrus.js');
                $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/TosRUs/src/css/jquery.tosrus.css');
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/TosRUs/lib/jquery.hammer.min.js');
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/TosRUs/lib/FlameViewportScale.js');
                break;
        }
    }

    if (0 == count($photos)) {
        return [];
    }

    $ret = [
        'photos'               => $photos,
        'column'               => $column,
        'direction'            => $direction,
        'title'                => $title,
        'jquery'               => $jquery,
        'ajaxeffect'           => $ajaxeffect,
        'overlyabg'            => $overlyabg,
        'overlyaw'             => $overlyaw,
        'overlyah'             => $overlyah,
        'tooltipw'             => $tooltipw,
        'tooltipbw'            => $tooltipbw,
        'tooltipbbg'           => $tooltipbbg,
        'fancyboxbg'           => $fancyboxbg,
        'fancyboxop'           => $fancyboxop,
        'fancyboxtin'          => $fancyboxtin,
        'fancyboxtout'         => $fancyboxtout,
        'fancyboxtp'           => $fancyboxtp,
        'fancyboxshow'         => $fancyboxshow,
        'prettyphotospeed'     => $prettyphotospeed,
        'prettyphototheme'     => $prettyphototheme,
        'prettyphotoslidspeed' => $prettyphotoslidspeed,
        'prettyphotoautoplay'  => $prettyphotoautoplay,
        'jcarouselhwidth'      => $jcarouselhwidth,
        'jcarouselvwidth'      => $jcarouselvwidth,
        'jcarouselvheight'     => $jcarouselvheight
    ];

    return $ret;
}

// converts a 2D array in a comma separated list (or separator of our choice)
/**
 * @param $sep
 * @param $array
 *
 * @return string
 */
function implodeArray2Dextgallery($sep, $array)
{
    $num = count($array);
    $str = '';
    foreach ($array as $i => $iValue) {
        if ($i) {
            $str .= $sep;
        }
        $str .= $array[$i];
    }

    return $str;
}

// Manage Top Submitter blocks
/**
 * @param $options
 *
 * @return string
 */
function extgalleryTopSubmitterShow($options)
{
    global $xoopsDB, $xoopsConfig;
    $catauth = '';
    $block   = [];
    if (0 != $options[1]) {
        $cat     = array_slice($options, 1); //Get information about categories to display
        $catauth = implodeArray2Dextgallery(',', $cat); //Creation of categories list to use - separated by a coma
    }
    $sql = 'SELECT uid, count(photo_id) AS countphoto FROM ' . $xoopsDB->prefix('extgallery_publicphoto');
    $sql .= ' WHERE (uid>0)';
    if (0 != $options[1]) {
        $sql .= ' AND cat_id IN (' . $catauth . ')';
    }
    $sql .= ' GROUP BY uid ORDER BY countphoto DESC';
    if ((int)$options[0] > 0) {
        $sql .= ' LIMIT ' . (int)$options[0];
    }
    $result = $xoopsDB->query($sql);
    if (!$result) {
        return '';
    }
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $uid                  = $myrow['uid'];
        $countphoto           = $myrow['countphoto'];
        $uname                = XoopsUser::getUnameFromId($myrow['uid']);
        $block['designers'][] = ['uid' => $uid, 'uname' => $uname, 'countphoto' => $countphoto];
    }

    return $block;
}

// Manage Ajax photos
/**
 * @param $options
 *
 * @return array
 */
function extgalleryAjax($options)
{
    /** @var Extgallery\PhotoHandler $photoHandler */
    $photoHandler       = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
    $param              = ['limit' => $options[0]];
    $photoHandlertype   = $options[1];
    $jquery             = $options[2];
    $ajaxeffect         = $options[3];
    $panel_width        = $options[4];
    $panel_height       = $options[5];
    $frame_width        = $options[6];
    $frame_height       = $options[7];
    $background_color   = $options[8];
    $transition_speed   = $options[9];
    $ransition_interval = $options[10];
    $overlay_height     = $options[11];
    $overlay_color      = $options[12];
    $overlay_text_color = $options[13];
    $caption_text_color = $options[14];
    $border             = $options[15];
    $overlay_opacity    = $options[16];
    $overlay_font_size  = $options[17];
    $nav_theme          = $options[18];
    $position           = $options[19];
    $easing             = $options[20];
    $gria_panelwidth    = $options[21];
    $gria_height        = $options[22];
    $gria_bgcolor       = $options[23];
    $gria_bcolor        = $options[24];
    $gria_bgimg         = $options[25];
    $gria_autoplay      = $options[26];
    $gria_transition    = $options[27];
    $gria_tspeed        = $options[28];
    $micro_size         = $options[29];

    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $categories = [];
    foreach ($options as $cat) {
        if (0 == $cat) {
            $categories = [];
            break;
        }
        $categories[] = $cat;
    }

    $param['cat'] = $categories;

    switch ($photoHandlertype) {
        case 'RandomPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getRandomPhoto($param));
            break;
        case 'LastPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getLastPhoto($param));
            break;
        case 'TopViewPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopViewPhoto($param));
            break;
        case 'TopRatedPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopRatedPhoto($param));
            break;
        case 'TopEcardPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopEcardPhoto($param));
            break;
    }

    if ('true' === $jquery) {
        global $xoTheme;
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

        switch ($ajaxeffect) {
            case 'galleryview':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleryview/galleryview.js');
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleryview/timers.js');
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleryview/easing.js');
                $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/galleryview/galleryview.css');
                break;
            case 'galleria':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/galleria/galleria.js');
                break;
            case 'microgallery':
                $xoTheme->addScript('browse.php?modules/extgallery/assets/js/microgallery/jquery.microgallery.js');
                $xoTheme->addStylesheet('browse.php?modules/extgallery/assets/js/microgallery/style.css');
                break;
        }
    }

    if (0 == count($photos)) {
        return [];
    }

    $ret = [
        'photos'              => $photos,
        'jquery'              => $jquery,
        'ajaxeffect'          => $ajaxeffect,
        'panel_width'         => $panel_width,
        'panel_height'        => $panel_height,
        'frame_width'         => $frame_width,
        'frame_height'        => $frame_height,
        'background_color'    => $background_color,
        'transition_speed'    => $transition_speed,
        'transition_interval' => $ransition_interval,
        'overlay_height'      => $overlay_height,
        'overlay_color'       => $overlay_color,
        'overlay_text_color'  => $overlay_text_color,
        'caption_text_color'  => $caption_text_color,
        'border'              => $border,
        'overlay_opacity'     => $overlay_opacity,
        'overlay_font_size'   => $overlay_font_size,
        'nav_theme'           => $nav_theme,
        'position'            => $position,
        'easing'              => $easing,
        'galleria_panelwidth' => $gria_panelwidth,
        'galleria_height'     => $gria_height,
        'galleria_bgcolor'    => $gria_bgcolor,
        'galleria_bcolor'     => $gria_bcolor,
        'galleria_bgimg'      => $gria_bgimg,
        'galleria_autoplay'   => $gria_autoplay,
        'galleria_transition' => $gria_transition,
        'galleria_tspeed'     => $gria_tspeed,
        'micro_size'          => $micro_size
    ];

    return $ret;
}

// Options photo blocks
/**
 * @param $options
 *
 * @return string
 */
function extgalleryBlockEdit($options)
{

    /** @var Extgallery\Category $catHandler */
    $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

    $form = _MB_EXTGALLERY_PHOTO_NUMBER . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[0] . '" type="text"><br>';

    $Selected = new \XoopsFormSelect(_MB_EXTGALLERY_DIRECTION, 'options[]', $options[1]);
    $Selected->addOption('0', _MB_EXTGALLERY_HORIZONTALLY);
    $Selected->addOption('1', _MB_EXTGALLERY_VERTICALLY);
    $Selected->addOption('2', _MB_EXTGALLERY_TABLE);
    $form .= _MB_EXTGALLERY_DIRECTION . ' : ' . $Selected->render() . '<br>';

    $yChecked = '';
    $nChecked = '';
    if (1 == $options[2]) {
        $yChecked = ' checked';
    } else {
        $nChecked = ' checked';
    }

    $form .= _MB_EXTGALLERY_DISPLAY_TITLE . ' : <input type="radio" name="options[]" value="1"' . $yChecked . '>&nbsp;' . _YES . '&nbsp;&nbsp;<input type="radio" name="options[]" value="0"' . $nChecked . '>' . _NO . '<br>';

    $effectTypeSelect = new \XoopsFormSelect(_MB_EXTGALLERY_SHOW_TYPE, 'options[]', $options[3]);
    $effectTypeSelect->addOption('RandomPhoto', _MB_EXTGALLERY_TYPE_OP1);
    $effectTypeSelect->addOption('LastPhoto', _MB_EXTGALLERY_TYPE_OP2);
    $effectTypeSelect->addOption('TopViewPhoto', _MB_EXTGALLERY_TYPE_OP3);
    $effectTypeSelect->addOption('TopRatedPhoto', _MB_EXTGALLERY_TYPE_OP4);
    $effectTypeSelect->addOption('TopEcardPhoto', _MB_EXTGALLERY_TYPE_OP5);
    $form .= _MB_EXTGALLERY_SHOW_TYPE . ' : ' . $effectTypeSelect->render() . '<br>';

    $jqSelect = new \XoopsFormSelect(_MB_EXTGALLERY_JQUERY, 'options[]', $options[4]);
    $jqSelect->addOption('true', _MB_EXTGALLERY_TRUE);
    $jqSelect->addOption('false', _MB_EXTGALLERY_FALSE);
    $form .= _MB_EXTGALLERY_JQUERY . ' : ' . $jqSelect->render() . '<br>';

    //select option
    $form             .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_USE_AJAX_EFFECTS . '</legend>';
    $ajaxeffectSelect = new \XoopsFormSelect(_MB_EXTGALLERY_USE_AJAX_EFFECTS, 'options[]', $options[5]);
    $ajaxeffectSelect->addOption('none', _MB_EXTGALLERY_AJAX_NONE);
    $ajaxeffectSelect->addOption('lightbox', _MB_EXTGALLERY_AJAX_LIGHTBOX);
    $ajaxeffectSelect->addOption('overlay', _MB_EXTGALLERY_AJAX_OVERLAY);
    $ajaxeffectSelect->addOption('tooltip', _MB_EXTGALLERY_AJAX_TOOLTIP);
    $ajaxeffectSelect->addOption('fancybox', _MB_EXTGALLERY_AJAX_FANCYBOX);
    $ajaxeffectSelect->addOption('prettyphoto', _MB_EXTGALLERY_AJAX_PRETTPHOTO);
    $ajaxeffectSelect->addOption('jcarousel', _MB_EXTGALLERY_AJAX_JCAROUSEL);
    $ajaxeffectSelect->addOption('TosRUs', _MB_EXTGALLERY_AJAX_TOSRUS);
    $form .= _MB_EXTGALLERY_USE_AJAX_EFFECTS . ' : ' . $ajaxeffectSelect->render() . '<br>';
    $form .= '</fieldset><br>';

    //for overlay
    $form .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_AJAX_OVERLAY . '</legend>';
    $form .= _MB_EXTGALLERY_OVERLAY_BG . ' : <input name="options[]" size="7" maxlength="7" value="' . $options[6] . '" type="text"><br>';
    $form .= _MB_EXTGALLERY_OVERLAY_WIDTH . ' : <input name="options[]" size="5" maxlength="5" value="' . $options[7] . '" type="text"><br>';
    $form .= _MB_EXTGALLERY_OVERLAY_HEIGHT . ' : <input name="options[]" size="5" maxlength="5" value="' . $options[8] . '" type="text"><br>';
    $form .= '</fieldset><br>';

    //for tooltip
    $form .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_AJAX_TOOLTIP . '</legend>';
    $form .= _MB_EXTGALLERY_TOOLTIP_WIDTH . ' : <input name="options[]" size="5" maxlength="5" value="' . $options[9] . '" type="text"><br>';
    $form .= _MB_EXTGALLERY_TOOLTIP_BORDER_WIDTH . ' : <input name="options[]" size="5" maxlength="5" value="' . $options[10] . '" type="text"><br>';
    $form .= _MB_EXTGALLERY_TOOLTIP_BORDERCOLOR . ' : <input name="options[]" size="7" maxlength="7" value="' . $options[11] . '" type="text"><br>';
    $form .= '</fieldset><br>';

    //for fancybox
    $form              .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_AJAX_FANCYBOX . '</legend>';
    $form              .= _MB_EXTGALLERY_FANCYBOX_BGCOLOR . ' : <input name="options[]" size="7" maxlength="7" value="' . $options[12] . '" type="text"><br>';
    $form              .= _MB_EXTGALLERY_FANCYBOX_OPACITY . ' : <input name="options[]" size="5" maxlength="5" value="' . $options[13] . '" type="text"><br>';
    $fancyboxtinSelect = new \XoopsFormSelect(_MB_EXTGALLERY_FANCYBOX_TIN, 'options[]', $options[14]);
    $fancyboxtinSelect->addOption('none', _MB_EXTGALLERY_FANCYBOX_NONE);
    $fancyboxtinSelect->addOption('elastic', _MB_EXTGALLERY_FANCYBOX_ELASTIC);
    $form               .= _MB_EXTGALLERY_FANCYBOX_TIN . ' : ' . $fancyboxtinSelect->render() . '<br>';
    $fancyboxtoutSelect = new \XoopsFormSelect(_MB_EXTGALLERY_FANCYBOX_TOUT, 'options[]', $options[15]);
    $fancyboxtoutSelect->addOption('none', _MB_EXTGALLERY_FANCYBOX_NONE);
    $fancyboxtoutSelect->addOption('elastic', _MB_EXTGALLERY_FANCYBOX_ELASTIC);
    $form             .= _MB_EXTGALLERY_FANCYBOX_TOUT . ' : ' . $fancyboxtoutSelect->render() . '<br>';
    $fancyboxtpSelect = new \XoopsFormSelect(_MB_EXTGALLERY_FANCYBOX_TITLEPOSITION, 'options[]', $options[16]);
    $fancyboxtpSelect->addOption('over', _MB_EXTGALLERY_FANCYBOX_OVER);
    $fancyboxtpSelect->addOption('inside', _MB_EXTGALLERY_FANCYBOX_INSIDE);
    $fancyboxtpSelect->addOption('outside', _MB_EXTGALLERY_FANCYBOX_OUTSIDE);
    $form               .= _MB_EXTGALLERY_FANCYBOX_TITLEPOSITION . ' : ' . $fancyboxtpSelect->render() . '<br>';
    $fancyboxshowSelect = new \XoopsFormSelect(_MB_EXTGALLERY_FANCYBOX_SHOWTYPE, 'options[]', $options[17]);
    $fancyboxshowSelect->addOption('single', _MB_EXTGALLERY_FANCYBOX_SINGLE);
    $fancyboxshowSelect->addOption('group', _MB_EXTGALLERY_FANCYBOX_GROUP);
    $form .= _MB_EXTGALLERY_FANCYBOX_SHOWTYPE . ' : ' . $fancyboxshowSelect->render() . '<br>';
    $form .= '</fieldset><br>';

    //for prettyphoto
    $form              .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_AJAX_PRETTPHOTO . '</legend>';
    $prettyspeedSelect = new \XoopsFormSelect(_MB_EXTGALLERY_PRETTPHOTO_SPEED, 'options[]', $options[18]);
    $prettyspeedSelect->addOption('fast', _MB_EXTGALLERY_PRETTPHOTO_FAST);
    $prettyspeedSelect->addOption('slow', _MB_EXTGALLERY_PRETTPHOTO_SLOW);
    $form              .= _MB_EXTGALLERY_PRETTPHOTO_SPEED . ' : ' . $prettyspeedSelect->render() . '<br>';
    $prettythemeSelect = new \XoopsFormSelect(_MB_EXTGALLERY_PRETTPHOTO_THEME, 'options[]', $options[19]);
    $prettythemeSelect->addOption('dark_rounded', _MB_EXTGALLERY_PRETTPHOTO_THEME1);
    $prettythemeSelect->addOption('dark_square', _MB_EXTGALLERY_PRETTPHOTO_THEME2);
    $prettythemeSelect->addOption('facebook', _MB_EXTGALLERY_PRETTPHOTO_THEME3);
    $prettythemeSelect->addOption('light_rounded', _MB_EXTGALLERY_PRETTPHOTO_THEME4);
    $prettythemeSelect->addOption('light_square', _MB_EXTGALLERY_PRETTPHOTO_THEME5);
    $form                 .= _MB_EXTGALLERY_PRETTPHOTO_THEME . ' : ' . $prettythemeSelect->render() . '<br>';
    $form                 .= _MB_EXTGALLERY_PRETTPHOTO_SLIDESPEED . ' : <input name="options[]" size="5" maxlength="5" value="' . $options[20] . '" type="text"><br>';
    $prettyautoplaySelect = new \XoopsFormSelect(_MB_EXTGALLERY_PRETTPHOTO_AUTOPLAY, 'options[]', $options[21]);
    $prettyautoplaySelect->addOption('true', _MB_EXTGALLERY_TRUE);
    $prettyautoplaySelect->addOption('false', _MB_EXTGALLERY_FALSE);
    $form .= _MB_EXTGALLERY_PRETTPHOTO_AUTOPLAY . ' : ' . $prettyautoplaySelect->render() . '<br>';
    $form .= '</fieldset><br>';

    //for jcarousel
    $form .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_AJAX_JCAROUSEL . '</legend>';
    $form .= _MB_EXTGALLERY_JCAROUSEL_HWIDTH . ' : <input name="options[]" size="7" maxlength="7" value="' . $options[22] . '" type="text"><br>';
    $form .= _MB_EXTGALLERY_JCAROUSEL_VWIDTH . ' : <input name="options[]" size="7" maxlength="7" value="' . $options[23] . '" type="text"><br>';
    $form .= _MB_EXTGALLERY_JCAROUSEL_VHIGHT . ' : <input name="options[]" size="7" maxlength="7" value="' . $options[24] . '" type="text"><br>';
    $form .= '</fieldset><br>';

    $form .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_TABLE . '</legend>';
    $form .= _MB_EXTGALLERY_PHOTO_NUMBER_TABLE . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[25] . '" type="text"><br>';
    $form .= '</fieldset><br>';

    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $form .= $catHandler->getBlockSelect($options);

    return $form;
}

// Options Ajax photos
/**
 * @param $options
 *
 * @return string
 */
function extgalleryAjaxEdit($options)
{
    $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

    $form = _MB_EXTGALLERY_PHOTO_NUMBER . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[0] . '" type="text"><br>';

    $showTypeSelect = new \XoopsFormSelect(_MB_EXTGALLERY_SHOW_TYPE, 'options[]', $options[1]);
    $showTypeSelect->addOption('RandomPhoto', _MB_EXTGALLERY_TYPE_OP1);
    $showTypeSelect->addOption('LastPhoto', _MB_EXTGALLERY_TYPE_OP2);
    $showTypeSelect->addOption('TopViewPhoto', _MB_EXTGALLERY_TYPE_OP3);
    $showTypeSelect->addOption('TopRatedPhoto', _MB_EXTGALLERY_TYPE_OP4);
    $showTypeSelect->addOption('TopEcardPhoto', _MB_EXTGALLERY_TYPE_OP5);
    $form .= _MB_EXTGALLERY_SHOW_TYPE . ' : ' . $showTypeSelect->render() . '<br>';

    $jqSelect = new \XoopsFormSelect(_MB_EXTGALLERY_JQUERY, 'options[]', $options[2]);
    $jqSelect->addOption('true', _MB_EXTGALLERY_TRUE);
    $jqSelect->addOption('false', _MB_EXTGALLERY_FALSE);
    $form .= _MB_EXTGALLERY_JQUERY . ' : ' . $jqSelect->render() . '<br>';

    //select option
    $form             .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_USE_AJAX_EFFECTS . '</legend>';
    $ajaxeffectSelect = new \XoopsFormSelect(_MB_EXTGALLERY_USE_AJAX_EFFECTS, 'options[]', $options[3]);
    $ajaxeffectSelect->addOption('galleryview', _MB_EXTGALLERY_GVIEW);
    $ajaxeffectSelect->addOption('galleria', _MB_EXTGALLERY_GRIA);
    $ajaxeffectSelect->addOption('microgallery', _MB_EXTGALLERY_MICRO);
    $form .= _MB_EXTGALLERY_USE_AJAX_EFFECTS . ' : ' . $ajaxeffectSelect->render() . '<br>';
    $form .= '</fieldset><br>';

    $form        .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_GVIEW . '</legend>';
    $form        .= _MB_EXTGALLERY_PANEL_WIDTH . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[4] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_PANEL_HEIGHT . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[5] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_FRAME_WIDTH . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[6] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_FRAME_HEIGHT . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[7] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_BACKGROUND . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[8] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_TRANSITION_SPEED . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[9] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_TRANSITION_INTERVAL . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[10] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_OVERLAY_HEIGHT . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[11] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_OVERLAY_COLOR . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[12] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_OVERLAY_TEXT_COLOR . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[13] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_CAPTION_TEXT_COLOR . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[14] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_BORDER . ' : <input name="options[]" size="20" maxlength="255" value="' . $options[15] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_OVERLAY_OPACITY . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[16] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_OVERLAY_FONT_SIZE . ' : <input name="options[]" size="6" maxlength="255" value="' . $options[17] . '" type="text"><br>';
    $themeSelect = new \XoopsFormSelect(_MB_EXTGALLERY_SELECT_THEME, 'options[]', $options[18]);
    $themeSelect->addOption('light', _MB_EXTGALLERY_LIGHT);
    $themeSelect->addOption('dark', _MB_EXTGALLERY_DARK);
    $themeSelect->addOption('custom', _MB_EXTGALLERY_CUSTOM);
    $form           .= _MB_EXTGALLERY_SELECT_THEME . ' : ' . $themeSelect->render() . '<br>';
    $positionSelect = new \XoopsFormSelect(_MB_EXTGALLERY_POSITION, 'options[]', $options[19]);
    $positionSelect->addOption('bottom', _MB_EXTGALLERY_BOTTOM);
    $positionSelect->addOption('top', _MB_EXTGALLERY_TOP);
    $form         .= _MB_EXTGALLERY_POSITION . ' : ' . $positionSelect->render() . '<br>';
    $easingSelect = new \XoopsFormSelect(_MB_EXTGALLERY_EASING, 'options[]', $options[20]);
    $easingSelect->addOption('swing', _MB_EXTGALLERY_EASING_OP1);
    $easingSelect->addOption('linear', _MB_EXTGALLERY_EASING_OP2);
    $easingSelect->addOption('easeInOutBack', _MB_EXTGALLERY_EASING_OP3);
    $easingSelect->addOption('easeInOutQuad', _MB_EXTGALLERY_EASING_OP4);
    $easingSelect->addOption('easeOutBounce', _MB_EXTGALLERY_EASING_OP5);
    $form .= _MB_EXTGALLERY_EASING . ' : ' . $easingSelect->render() . '<br>';
    $form .= '</fieldset><br>';

    $form        .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_GRIA . '</legend>';
    $form        .= _MB_EXTGALLERY_GRIA_WIDTH . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[21] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_GRIA_HEIGHT . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[22] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_GRIA_BGCOLOR . ' : <input name="options[]" size="7" maxlength="255" value="' . $options[23] . '" type="text"><br>';
    $form        .= _MB_EXTGALLERY_GRIA_BCOLOR . ' : <input name="options[]" size="7" maxlength="255" value="' . $options[24] . '" type="text"><br>';
    $bgimgSelect = new \XoopsFormSelect(_MB_EXTGALLERY_GRIA_BGIMG, 'options[]', $options[25]);
    $bgimgSelect->addOption('classic-map', _MB_EXTGALLERY_GRIA_BGIMG_OP1);
    $bgimgSelect->addOption('classic-map-b', _MB_EXTGALLERY_GRIA_BGIMG_OP2);
    $form .= _MB_EXTGALLERY_GRIA_BGIMG . ' : ' . $bgimgSelect->render() . '<br>';

    $autoplaySelect = new \XoopsFormSelect(_MB_EXTGALLERY_GRIA_AUTOPLAY, 'options[]', $options[26]);
    $autoplaySelect->addOption('true', _MB_EXTGALLERY_TRUE);
    $autoplaySelect->addOption('false', _MB_EXTGALLERY_FALSE);
    $form         .= _MB_EXTGALLERY_GRIA_AUTOPLAY . ' : ' . $autoplaySelect->render() . '<br>';
    $select_trans = new \XoopsFormSelect(_MB_EXTGALLERY_GRIA_TRANS, 'options[]', $options[27]);
    $select_trans->addOption('fade', _MB_EXTGALLERY_GRIA_TRANS_TYP1);
    $select_trans->addOption('flash', _MB_EXTGALLERY_GRIA_TRANS_TYP2);
    $select_trans->addOption('pulse', _MB_EXTGALLERY_GRIA_TRANS_TYP3);
    $select_trans->addOption('slide', _MB_EXTGALLERY_GRIA_TRANS_TYP4);
    $select_trans->addOption('fadeslide', _MB_EXTGALLERY_GRIA_TRANS_TYP5);
    $form .= _MB_EXTGALLERY_GRIA_TRANS . ' : ' . $select_trans->render() . '<br>';
    $form .= _MB_EXTGALLERY_GRIA_TSPEED . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[28] . '" type="text"><br>';

    $form .= '</fieldset><br>';

    $form       .= "<fieldset><legend style='font-weight:bold; color:#990000;'>" . _MB_EXTGALLERY_MICRO . '</legend>';
    $sizeSelect = new \XoopsFormSelect(_MB_EXTGALLERY_MICRO_SIZE, 'options[]', $options[29]);
    $sizeSelect->addOption('small', _MB_EXTGALLERY_MICRO_SIZE_OP1);
    $sizeSelect->addOption('medium', _MB_EXTGALLERY_MICRO_SIZE_OP2);
    $sizeSelect->addOption('large', _MB_EXTGALLERY_MICRO_SIZE_OP3);
    $form .= _MB_EXTGALLERY_MICRO_SIZE . ' : ' . $sizeSelect->render() . '<br>';
    $form .= '</fieldset><br>';

    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $form .= $catHandler->getBlockSelect($options);

    return $form;
}

// Options TopSubmiter
/**
 * @param $options
 *
 * @return string
 */
function extgalleryTopSubmitterEdit($options)
{
    $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

    $form = _MB_EXTGALLERY_USER_NUMBER . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[0] . '" type="text"><br>';

    array_shift($options);

    $form .= $catHandler->getBlockSelect($options);

    return $form;
}

/**
 * @param $options
 *
 * @return array
 */
function extgalleryList($options)
{
    global $xoopsConfig;

    /** @var Extgallery\PhotoHandler $photoHandler */
    $photoHandler     = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
    $param            = ['limit' => $options[0]];
    $date             = $options[1];
    $hits             = $options[2];
    $rate             = $options[3];
    $photoHandlertype = $options[4];

    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $categories = [];
    foreach ($options as $cat) {
        if (0 == $cat) {
            $categories = [];
            break;
        }
        $categories[] = $cat;
    }
    $param['cat'] = $categories;

    switch ($photoHandlertype) {
        case 'RandomPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getRandomPhoto($param));
            break;
        case 'LastPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getLastPhoto($param));
            break;
        case 'TopViewPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopViewPhoto($param));
            break;
        case 'TopRatedPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopRatedPhoto($param));
            break;
        case 'TopEcardPhoto':
            $photos = $photoHandler->objectToArray($photoHandler->getTopEcardPhoto($param));
            break;
    }

    if (0 == count($photos)) {
        return [];
    }

    foreach (array_keys($photos) as $i) {
        if (isset($photos[$i]['photo_date'])) {
            $photos[$i]['photo_date'] = date(_SHORTDATESTRING, $photos[$i]['photo_date']);
        }
    }

    $ret = [
        'photos' => $photos,
        'date'   => $date,
        'hits'   => $hits,
        'rate'   => $rate
    ];

    return $ret;
}

/**
 * @param $options
 *
 * @return string
 */
function extgalleryListEdit($options)
{
    $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
    $form       = _MB_EXTGALLERY_PHOTO_NUMBER . ' : <input name="options[]" size="5" maxlength="255" value="' . $options[0] . '" type="text"><br>';
    //==================================
    $y2Checked = '';
    $n2Checked = '';
    if (1 == $options[1]) {
        $y2Checked = ' checked';
    } else {
        $n2Checked = ' checked';
    }
    $form .= _MB_EXTGALLERY_DISPLAY_DATE . ' : <input type="radio" name="options[1]" value="1"' . $y2Checked . '>&nbsp;' . _YES . '&nbsp;&nbsp;<input type="radio" name="options[1]" value="0"' . $n2Checked . '>' . _NO . '<br>';
    //==================================
    $y3Checked = '';
    $n3Checked = '';
    if (1 == $options[2]) {
        $y3Checked = ' checked';
    } else {
        $n3Checked = ' checked';
    }
    $form .= _MB_EXTGALLERY_DISPLAY_HITS . ' : <input type="radio" name="options[2]" value="1"' . $y3Checked . '>&nbsp;' . _YES . '&nbsp;&nbsp;<input type="radio" name="options[2]" value="0"' . $n3Checked . '>' . _NO . '<br>';
    //==================================
    $y4Checked = '';
    $n4Checked = '';
    if (1 == $options[3]) {
        $y4Checked = ' checked';
    } else {
        $n4Checked = ' checked';
    }
    $form .= _MB_EXTGALLERY_DISPLAY_RATE . ' : <input type="radio" name="options[3]" value="1"' . $y4Checked . '>&nbsp;' . _YES . '&nbsp;&nbsp;<input type="radio" name="options[3]" value="0"' . $n4Checked . '>' . _NO . '<br>';
    //==================================
    $effectTypeSelect = new \XoopsFormSelect(_MB_EXTGALLERY_SHOW_TYPE, 'options[]', $options[4]);
    $effectTypeSelect->addOption('RandomPhoto', _MB_EXTGALLERY_TYPE_OP1);
    $effectTypeSelect->addOption('LastPhoto', _MB_EXTGALLERY_TYPE_OP2);
    $effectTypeSelect->addOption('TopViewPhoto', _MB_EXTGALLERY_TYPE_OP3);
    $effectTypeSelect->addOption('TopRatedPhoto', _MB_EXTGALLERY_TYPE_OP4);
    $effectTypeSelect->addOption('TopEcardPhoto', _MB_EXTGALLERY_TYPE_OP5);
    $form .= _MB_EXTGALLERY_SHOW_TYPE . ' : ' . $effectTypeSelect->render() . '<br>';

    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $form .= $catHandler->getBlockSelect($options);

    return $form;
}
