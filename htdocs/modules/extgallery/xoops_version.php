<?php
/**
 * ExtGallery XOOPS_VERSION
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   {@link http://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */

$modversion['name']        = _MI_EXTGAL_NAME;
$modversion['version']     = 1.13;
$modversion['description'] = _MI_EXTGAL_DESC;
$modversion['credits']     = 'http://www.zoullou.net/';
$modversion['author']      = 'Zoullou';
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']    = 1; //1 indicates supported by XOOPS Dev Team, 0 means 3rd party supported
$modversion['image']       = 'assets/images/logoModule.png';
$modversion['dirname']     = basename(__DIR__);
$modversion['onInstall']   = 'include/install_function.php';
$modversion['onUpdate']    = 'include/update_function.php';

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses/moduleadmin';
$modversion['sysicons16']     = 'Frameworks/moduleclasses/icons/16';
$modversion['sysicons32']     = 'Frameworks/moduleclasses/icons/32';
$modversion['modicons16']     = 'assets/images/icons/16';
$modversion['modicons32']     = 'assets/images/icons/32';
//about
$modversion['module_status']       = 'RC 1';
$modversion['release_date']        = '2016/08/10';
$modversion['module_website_url']  = 'www.xoops.org';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.8';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = array('mysql' => '5.0.7', 'mysqli' => '5.0.7');

// Admin things
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;
if (isset($GLOBALS['xoopsModule']) && is_object($GLOBALS['xoopsModule'])
    && $GLOBALS['xoopsModule']->getVar('dirname') === 'extgallery'
) {
    if ($GLOBALS['xoopsUser'] !== null) {
        $modversion['sub'][0]['name'] = _MI_EXTGALLERY_USERALBUM;
        $modversion['sub'][0]['url']  = 'public-useralbum.php?id=' . $GLOBALS['xoopsUser']->uid();
    }

    include_once XOOPS_ROOT_PATH . '/modules/extgallery/class/publicPerm.php';
    $permHandler = ExtgalleryPublicPermHandler::getHandler();
    if (count($permHandler->getAuthorizedPublicCat($GLOBALS['xoopsUser'], 'public_upload')) > 0) {
        $modversion['sub'][1]['name'] = _MI_EXTGALLERY_PUBLIC_UPLOAD;
        if ($GLOBALS['xoopsModuleConfig']['use_extended_upload'] === 'html') {
            $modversion['sub'][1]['url'] = 'public-upload.php';
        } else {
            $modversion['sub'][1]['url'] = 'public-upload-extended.php';
        }
    }
}

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1]        = 'extgallery_publiccat';
$modversion['tables'][2]        = 'extgallery_publicphoto';
$modversion['tables'][3]        = 'extgallery_quota';
$modversion['tables'][4]        = 'extgallery_publicrating';
$modversion['tables'][5]        = 'extgallery_publicecard';

// Comments
$modversion['hasComments']                    = 1;
$modversion['comments']['itemName']           = 'photoId';
$modversion['comments']['pageName']           = 'public-photo.php';
$modversion['comments']['callbackFile']       = 'include/comment_function.php';
$modversion['comments']['callback']['update'] = 'extgalleryComUpdate';

// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'extgallerySearch';

// Config items
$i                                       = 0;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_GENERAL';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';
++$i;
$modversion['config'][$i]['name']        = 'display_type';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_DISP_TYPE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_TYPE_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['options']     = array(
    _MI_EXTGALLERY_SLIDESHOW => 'slideshow',
    _MI_EXTGALLERY_ALBUM     => 'album'
);
$modversion['config'][$i]['default']     = 'album';
++$i;
$modversion['config'][$i]['name']        = 'display_set_order';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_DISP_SET_ORDER';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_SET_ORDER_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['options']     = array(
    _MI_EXTGALLERY_DESC => 'DESC',
    _MI_EXTGALLERY_ASC  => 'ASC'
);
$modversion['config'][$i]['default']     = 'DESC';
++$i;
$modversion['config'][$i]['name']        = 'use_extended_upload';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_EXT_UPLOAD';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_EXT_UPLOAD_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'applet';
$modversion['config'][$i]['options']     = array(
    _MI_EXTGALLERY_EXTENDED => 'applet',
    _MI_EXTGALLERY_STANDARD => 'html'
);
++$i;
$modversion['config'][$i]['name']        = 'enable_jquery';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_JQUERY';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_JQUERY_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1; // yes
++$i;
$modversion['config'][$i]['name']        = 'usetag';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_TAG';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_TAG_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0; // no
/**
 * DNPROSSI - Editor to use
 */
++$i;
$modversion['config'][$i]['name']        = 'form_options';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_FORM_OPTIONS';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_FORM_OPTIONS_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'dhtml';
xoops_load('xoopseditorhandler');
$editorHandler                       = XoopsEditorHandler::getInstance();
$modversion['config'][$i]['options'] = array_flip($editorHandler->getList());
++$i;
$modversion['config'][$i]['name']        = 'photoname_pattern';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_NAME_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_NAME_PATTERN_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '`([a-zA-Z0-9]+)[-_]`';
++$i;
$modversion['config'][$i]['name']        = 'max_photosize';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_MAX_SIZE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_MAX_SIZE_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '10485760';
++$i;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_ALBUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';
++$i;
$modversion['config'][$i]['name']        = 'use_ajax_effects';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_DISP_TYPE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_TYPE_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['options']     = array(
    _MI_EXTGAL_AJAX_NONE       => 'none',
    _MI_EXTGAL_AJAX_LIGHTBOX   => 'lightbox',
    _MI_EXTGAL_AJAX_OVERLAY    => 'overlay',
    _MI_EXTGAL_AJAX_TOOLTIP    => 'tooltip',
    _MI_EXTGAL_AJAX_FANCYBOX   => 'fancybox',
    _MI_EXTGAL_AJAX_PRETTPHOTO => 'prettyphoto'
);
$modversion['config'][$i]['default']     = 'none';
++$i;
$modversion['config'][$i]['name']        = 'nb_column';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_NB_COLUMN';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_NB_COLUMN_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 4;
++$i;
$modversion['config'][$i]['name']        = 'nb_line';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_NB_LINE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_NB_LINE_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 7;
++$i;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_SLIDESHOW';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';
++$i;
$modversion['config'][$i]['name']        = 'use_slideshow_effects';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_DISP_TYPE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_TYPE_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['options']     = array(
    _MI_EXTGAL_SLIDESHOW_GVIEW => 'galleryview',
    _MI_EXTGAL_SLIDESHOW_GRIA  => 'galleria',
    _MI_EXTGAL_SLIDESHOW_MICRO => 'microgallery',
    _MI_EXTGAL_SLIDESHOW_GFIC  => 'galleriffic'
);
$modversion['config'][$i]['default']     = 'galleryview';
++$i;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_PHOTO';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';
++$i;
$modversion['config'][$i]['name']        = 'save_large';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_SAVE_L';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_SAVE_L_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0; // no
++$i;
$modversion['config'][$i]['name']        = 'save_original';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_SAVE_ORIG';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_SAVE_ORIG_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0; // no
++$i;
$modversion['config'][$i]['name']        = 'medium_width';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_M_WIDTH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_WIDTH_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 600;
++$i;
$modversion['config'][$i]['name']        = 'medium_heigth';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_M_HEIGTH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_HEIGTH_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 600;
++$i;
$modversion['config'][$i]['name']        = 'medium_quality';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_M_QUALITY';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_QUALITY_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 75;
++$i;
$modversion['config'][$i]['name']        = 'thumb_width';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_T_WIDTH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_T_WIDTH_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 100;
++$i;
$modversion['config'][$i]['name']        = 'thumb_heigth';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_T_HEIGTH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_T_HEIGTH_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 100;
++$i;
$modversion['config'][$i]['name']        = 'thumb_quality';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_T_QUALITY';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_T_QUALITY_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 75;
++$i;
$modversion['config'][$i]['name']        = 'enable_medium_watermark';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_M_WATERMARK';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_WATERMARK_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
++$i;
$modversion['config'][$i]['name']        = 'enable_medium_border';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_M_BORDER';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_BORDER_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
++$i;
$modversion['config'][$i]['name']        = 'enable_large_watermark';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_L_WATERMARK';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_L_WATERMARK_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
++$i;
$modversion['config'][$i]['name']        = 'enable_large_border';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_L_BORDER';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_L_BORDER_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
++$i;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_INFO';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';
/**
 * DNPROSSI - Info View
 * Shows-hides info from album thumbs or photo
 */
++$i;
$modversion['config'][$i]['name']        = 'info_view';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_INFO_VIEW';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_INFO_VIEW_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'both';
$modversion['config'][$i]['options']     = array(
    _MI_EXTGAL_INFO_BOTH  => 'both',
    _MI_EXTGAL_INFO_ALBUM => 'album',
    _MI_EXTGAL_INFO_PHOTO => 'photo'
);
/**
 * DNPROSSI - Public User Info
 * Shows-hides info from public or user album and photo
 */
++$i;
$modversion['config'][$i]['name']        = 'pubusr_info_view';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_INFO_PUBUSR';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_INFO_PUBUSR_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'both';
$modversion['config'][$i]['options']     = array(
    _MI_EXTGAL_INFO_BOTH   => 'both',
    _MI_EXTGAL_INFO_USER   => 'user',
    _MI_EXTGAL_INFO_PUBLIC => 'public'
);
/**
 * DNPROSSI - Enable Info
 */
++$i;
$modversion['config'][$i]['name']        = 'enable_info';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_INFO';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_INFO_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'enable_rating';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_RATING';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_RATING_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
/**
 * DNPROSSI - Enable Ecards
 */
++$i;
$modversion['config'][$i]['name']        = 'enable_ecards';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_ECARDS';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_ECARDS_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
/**
 * DNPROSSI - Enable Photo Hits
 */
++$i;
$modversion['config'][$i]['name']        = 'enable_photo_hits';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_PHOTO_HITS';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_PHOTO_HITS_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
/**
 * DNPROSSI - Enable Submitter Link
 */
++$i;
$modversion['config'][$i]['name']        = 'enable_submitter_lnk';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_SUBMITTER_LNK';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_SUBMITTER_LNK_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
/**
 * DNPROSSI - Enable Resolution
 */
++$i;
$modversion['config'][$i]['name']        = 'enable_resolution';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_RESOLUTION';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_RESOLUTION_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
/**
 * DNPROSSI - Enable Submitter Link
 */
++$i;
$modversion['config'][$i]['name']        = 'enable_date';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_DATE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_DATE_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
/**
 * DNPROSSI - Enable Download
 */
++$i;
$modversion['config'][$i]['name']        = 'enable_download';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_DOWNLOAD';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_DOWNLOAD_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
/**
 * Voltan - Enable show comments
 */
++$i;
$modversion['config'][$i]['name']        = 'enable_show_comments';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ENABLE_SHOW_COMMENTS';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_SHOW_COMMENTS_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'disp_ph_title';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_DISP_PH_TITLE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_PH_TITLE_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'disp_cat_img';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_DISP_CAT_IMG';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_CAT_IMG_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
++$i;
$modversion['config'][$i]['name']        = 'display_extra_field';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_DISPLAY_EXTRA';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISPLAY_EXTRA_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
++$i;
$modversion['config'][$i]['name']        = 'allow_html';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ALLOW_HTML';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ALLOW_HTML_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
/**
 * Voltan - Social networks and bookmarks
 */
++$i;
$modversion['config'][$i]['name']        = 'show_social_book';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_SOCIAL';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_SOCIAL_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['options']     = array(
    _MI_EXTGAL_NONE          => 0,
    _MI_EXTGAL_SOCIALNETWORM => 1,
    _MI_EXTGAL_BOOKMARK      => 2,
    _MI_EXTGAL_INFO_BOTH     => 3
);
$modversion['config'][$i]['default']     = 0;
++$i;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_RSS';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';
++$i;
$modversion['config'][$i]['name']        = 'show_rss';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_SHOW_RSS';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_SHOW_RSS_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'perpage_rss';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PERPAGE_RSS';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_PERPAGE_RSS_DSC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 10;
++$i;
$modversion['config'][$i]['name']        = 'timecache_rss';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_TIMECACHE_RSS';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_TIMECACHE_RSS_DSC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 60;
++$i;
$modversion['config'][$i]['name']        = 'logo_rss';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_LOGO_RSS';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '/assets/images/logo.png';
++$i;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_ADMIN';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';
++$i;
$modversion['config'][$i]['name']        = 'admin_nb_photo';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_ADM_NBPHOTO';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ADM_NBPHOTO_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 10;
++$i;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_GRAPHLIB';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';
++$i;
$modversion['config'][$i]['name']        = 'graphic_lib';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_GRAPHLIB';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_GRAPHLIB_DESC';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'GD';
$modversion['config'][$i]['options']     = array('GD 2' => 'GD', 'ImageMagick 6 Binary' => 'IM');
++$i;
$modversion['config'][$i]['name']        = 'graphic_lib_path';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_GRAPHLIB_PATH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_GRAPHLIB_PATH_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '/usr/local/bin/';
++$i;
$modversion['config'][$i]['name']        = 'break' . $i;
$modversion['config'][$i]['title']       = '_MI_EXTGAL_PREFERENCE_BREAK_COMNOTI';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'line_break';
$modversion['config'][$i]['valuetype']   = 'textbox';
$modversion['config'][$i]['default']     = 'head';

// Hidden preferences field
++$i;
$modversion['config'][$i]['name']        = 'watermark_type';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_M_WATERMARK';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_WATERMARK_DESC';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'watermark_font';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'AllStarResort.ttf';
++$i;
$modversion['config'][$i]['name']        = 'watermark_text';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = $GLOBALS['xoopsConfig']['sitename'];
++$i;
$modversion['config'][$i]['name']        = 'watermark_position';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'tr';
++$i;
$modversion['config'][$i]['name']        = 'watermark_color';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#FFFFFF';
++$i;
$modversion['config'][$i]['name']        = 'watermark_fontsize';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 16;
++$i;
$modversion['config'][$i]['name']        = 'watermark_padding';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 5;
++$i;
$modversion['config'][$i]['name']        = 'inner_border_color';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#FFFFFF';
++$i;
$modversion['config'][$i]['name']        = 'inner_border_size';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 2;
++$i;
$modversion['config'][$i]['name']        = 'outer_border_color';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#000000';
++$i;
$modversion['config'][$i]['name']        = 'outer_border_size';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 5;

// hidden effects for slideshow
++$i;
$modversion['config'][$i]['name']        = 'galleryview_panelwidth';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 600;
++$i;
$modversion['config'][$i]['name']        = 'galleryview_panelheight';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 400;
++$i;
$modversion['config'][$i]['name']        = 'galleryview_framewidth';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 80;
++$i;
$modversion['config'][$i]['name']        = 'galleryview_frameheight';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 60;
++$i;
$modversion['config'][$i]['name']        = 'galleryview_overlayheight';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 62;
++$i;
$modversion['config'][$i]['name']        = 'galleryview_overlaycolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#222222';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_borderwidth';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'galleryview_bordercolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#cccccc';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_navtheme';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'light';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_position';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'bottom';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_easing';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'swing';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_bgcolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#000000';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_tspeed';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1200;
++$i;
$modversion['config'][$i]['name']        = 'galleryview_tterval';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 6000;
++$i;
$modversion['config'][$i]['name']        = 'galleryview_overlaytc';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#ffffff';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_captiontc';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#222222';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_opacity';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '0.6';
++$i;
$modversion['config'][$i]['name']        = 'galleryview_overlayfs';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '11px';
++$i;
$modversion['config'][$i]['name']        = 'galleria_height';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 400;
++$i;
$modversion['config'][$i]['name']        = 'galleria_panelwidth';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 620;
++$i;
$modversion['config'][$i]['name']        = 'galleria_bgcolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#000000';
++$i;
$modversion['config'][$i]['name']        = 'galleria_bcolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#000000';
++$i;
$modversion['config'][$i]['name']        = 'galleria_bgimg';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'classic-map';
/* added by Goffy */
++$i;
$modversion['config'][$i]['name']        = 'galleria_autoplay';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'galleria_transition';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'fade';
++$i;
$modversion['config'][$i]['name']        = 'galleria_tspeed';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1000;
/* end added by Goffy */
/* added by Goffy */
// hidden effects for galleriffic
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_height';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 600;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_width';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 600;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_bordercolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#cccccc';
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_bgcolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#ffffff';
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_fontcolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#000000';
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_autoplay';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_nb_thumbs';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 10;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_nb_colthumbs';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 2;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_nb_preload';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 10;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_tdelay';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 3000;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_tspeed';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1000;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_show_descr';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
++$i;
$modversion['config'][$i]['name']        = 'galleriffic_download';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
/* end added by Goffy */

// hidden effects for album
++$i;
$modversion['config'][$i]['name']        = 'album_tooltip_width';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 250;
++$i;
$modversion['config'][$i]['name']        = 'album_tooltip_borderwidth';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
++$i;
$modversion['config'][$i]['name']        = 'album_tooltip_bordercolor';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#cccccc';
++$i;
$modversion['config'][$i]['name']        = 'album_overlay_bg';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#ffffff';
++$i;
$modversion['config'][$i]['name']        = 'album_overlay_width';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 600;
++$i;
$modversion['config'][$i]['name']        = 'album_overlay_height';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 450;
++$i;
$modversion['config'][$i]['name']        = 'album_fancybox_color';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '#333333';
++$i;
$modversion['config'][$i]['name']        = 'album_fancybox_opacity';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '0.9';
++$i;
$modversion['config'][$i]['name']        = 'album_fancybox_tin';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'none';
++$i;
$modversion['config'][$i]['name']        = 'album_fancybox_tout';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'none';
++$i;
$modversion['config'][$i]['name']        = 'album_fancybox_title';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'over';
++$i;
$modversion['config'][$i]['name']        = 'album_fancybox_showtype';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'group';
++$i;
$modversion['config'][$i]['name']        = 'album_prettyphoto_speed';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'fast';
++$i;
$modversion['config'][$i]['name']        = 'album_prettyphoto_theme';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'light_square';
++$i;
$modversion['config'][$i]['name']        = 'album_prettyphoto_slidspe';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 2000;
++$i;
$modversion['config'][$i]['name']        = 'album_prettyphoto_autopla';
$modversion['config'][$i]['title']       = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'hidden';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'true';

// Templates
$modversion['templates'][] = array('file' => 'extgallery_public-categories.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-album.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-photo.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_index.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-sendecard.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-viewecard.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-useralbum.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-userphoto.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-slideshow.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-upload-applet.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-bookmarkme.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'extgallery_public-rss.tpl', 'description' => '');

// Blocs
$modversion['blocks'][1]['file']        = 'extgallery_blocks.php';
$modversion['blocks'][1]['name']        = _MI_EXTGAL_B_PHOTO;
$modversion['blocks'][1]['description'] = '';
$modversion['blocks'][1]['show_func']   = 'extgalleryPhotoShow';
$modversion['blocks'][1]['options']     = '4|0|0|RandomPhoto|true|none|#ffffff|600|450|250|1|#cccccc|#333333|0.9|none|none|over|group|slow|dark_rounded|2000|true|500|120|300|3|0';
$modversion['blocks'][1]['edit_func']   = 'extgalleryBlockEdit';
$modversion['blocks'][1]['template']    = 'extgallery_block.tpl';

$modversion['blocks'][2]['file']        = 'extgallery_blocks.php';
$modversion['blocks'][2]['name']        = _MI_EXTGAL_B_SUB;
$modversion['blocks'][2]['description'] = '';
$modversion['blocks'][2]['show_func']   = 'extgalleryTopSubmitterShow';
$modversion['blocks'][2]['options']     = '5|0';
$modversion['blocks'][2]['edit_func']   = 'extgalleryTopSubmitterEdit';
$modversion['blocks'][2]['template']    = 'extgallery_block_top_submitter.tpl';

$modversion['blocks'][3]['file']        = 'extgallery_blocks.php';
$modversion['blocks'][3]['name']        = _MI_EXTGAL_B_AJAX;
$modversion['blocks'][3]['description'] = '';
$modversion['blocks'][3]['show_func']   = 'extgalleryAjax';
$modversion['blocks'][3]['options']     = '8|RandomPhoto|true|galleryview|600|400|60|40|000|1200|6000|62|222|fff|222|1px solid #ccc|0.6|11px|light|bottom|swing|620|400|#000000|#000000|classic-map|true|fade|1000|small|0';
$modversion['blocks'][3]['edit_func']   = 'extgalleryAjaxEdit';
$modversion['blocks'][3]['template']    = 'extgallery_block_ajax.tpl';

$modversion['blocks'][4]['file']        = 'extgallery_block_tag.php';
$modversion['blocks'][4]['name']        = _MI_EXTGAL_B_TOP_TAG;
$modversion['blocks'][4]['description'] = 'Show top tags';
$modversion['blocks'][4]['show_func']   = 'extgallery_tag_block_top_show';
$modversion['blocks'][4]['edit_func']   = 'extgallery_tag_block_top_edit';
$modversion['blocks'][4]['options']     = '50|30|c';
$modversion['blocks'][4]['template']    = 'extgallery_tag_block_top.tpl';

$modversion['blocks'][5]['file']        = 'extgallery_block_tag.php';
$modversion['blocks'][5]['name']        = _MI_EXTGAL_B_TAG_CLOUD;
$modversion['blocks'][5]['description'] = 'Show tag cloud';
$modversion['blocks'][5]['show_func']   = 'extgallery_tag_block_cloud_show';
$modversion['blocks'][5]['edit_func']   = 'extgallery_tag_block_cloud_edit';
$modversion['blocks'][5]['options']     = '100|0|150|80';
$modversion['blocks'][5]['template']    = 'extgallery_tag_block_cloud.tpl';

$modversion['blocks'][6]['file']        = 'extgallery_blocks.php';
$modversion['blocks'][6]['name']        = _MI_EXTGAL_B_LIST;
$modversion['blocks'][6]['description'] = 'List of photos';
$modversion['blocks'][6]['show_func']   = 'extgalleryList';
$modversion['blocks'][6]['edit_func']   = 'extgalleryListEdit';
$modversion['blocks'][6]['options']     = '10|1|1|1|RandomPhoto|0';
$modversion['blocks'][6]['template']    = 'extgallery_block_list.tpl';

// Notifications
$modversion['hasNotification'] = 1;
//$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
//$modversion['notification']['lookup_func'] = 'extgalleryNotifyIteminfo';

$modversion['notification']['category'][1]['name']           = 'global';
$modversion['notification']['category'][1]['title']          = _MI_EXTGAL_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description']    = _MI_EXTGAL_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = '*';
$modversion['notification']['category'][1]['item_name']      = '';

$modversion['notification']['category'][2]['name']           = 'album';
$modversion['notification']['category'][2]['title']          = _MI_EXTGAL_ALBUM_NOTIFY;
$modversion['notification']['category'][2]['description']    = _MI_EXTGAL_ALBUM_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'public-album.php';
$modversion['notification']['category'][2]['item_name']      = 'id';

$modversion['notification']['category'][3]['name']           = 'event';
$modversion['notification']['category'][3]['title']          = _MI_EXTGAL_PHOTO_NOTIFY;
$modversion['notification']['category'][3]['description']    = _MI_EXTGAL_PHOTO_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'public-photo.php';
$modversion['notification']['category'][3]['item_name']      = 'photoId';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name']          = 'new_photo';
$modversion['notification']['event'][1]['category']      = 'global';
$modversion['notification']['event'][1]['title']         = _MI_EXTGAL_NEW_PHOTO_NOTIFY;
$modversion['notification']['event'][1]['caption']       = _MI_EXTGAL_NEW_PHOTO_NOTIFYCAP;
$modversion['notification']['event'][1]['description']   = _MI_EXTGAL_NEW_PHOTO_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_new_photo';
$modversion['notification']['event'][1]['mail_subject']  = _MI_EXTGAL_NEW_PHOTO_NOTIFYSBJ;

$modversion['notification']['event'][2]['name']          = 'new_photo_pending';
$modversion['notification']['event'][2]['category']      = 'global';
$modversion['notification']['event'][2]['title']         = _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFY;
$modversion['notification']['event'][2]['caption']       = _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYCAP;
$modversion['notification']['event'][2]['description']   = _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_new_photo_pending';
$modversion['notification']['event'][2]['mail_subject']  = _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYSBJ;
$modversion['notification']['event'][2]['admin_only']    = 1;

$modversion['notification']['event'][3]['name']          = 'new_photo_album';
$modversion['notification']['event'][3]['category']      = 'album';
$modversion['notification']['event'][3]['title']         = _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFY;
$modversion['notification']['event'][3]['caption']       = _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYCAP;
$modversion['notification']['event'][3]['description']   = _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'album_new_photo';
$modversion['notification']['event'][3]['mail_subject']  = _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYSBJ;
