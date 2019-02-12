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
 * @copyright   {@link https://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */

use XoopsModules\Extgallery;

require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName = basename(__DIR__);

// ------------------- Informations ------------------- //
$modversion = [
    'version'             => 1.14,
    'module_status'       => 'Beta 2',
    'release_date'        => '2018/09/22', // YYYY/mm/dd
    'name'                => _MI_EXTGALLERY_NAME,
    'description'         => _MI_EXTGAL_DESC,
    'author'              => 'Zoullou, contributors: Voltan, Mamba, Goffy',
    //    'author_mail'         => " ",
    'author_website_url'  => 'http://xoops.com',
    'author_website_name' => 'XOOPS',
    'credits'             => 'XOOPS Development Team',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',

    'release_info' => 'release_info',
    'release'      => '2016-08-28',
    'release_file' => XOOPS_URL . "/modules/{$moduleDirName}/docs/release_info file",

    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/{$moduleDirName}/docs/install.txt",
    'min_php'             => '5.5',
    'min_xoops'           => '2.5.9',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5'],
    'image'               => 'assets/images/logoModule.png', // Path and name of the module’s logo
    'official'            => 1, //1 indicates supported by XOOPS Dev Team, 0 means 3rd party supported
    'dirname'             => $moduleDirName,
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons',

    //About
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // Admin things
    'hasAdmin'            => 1,
    'system_menu'         => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // Main Menu
    'hasMain'             => 1,
    // Install/Update
    'onInstall'           => 'include/oninstall.php',
    //'onUninstall'         => "include/onuninstall.php",
    'onUpdate'            => 'include/onupdate.php',
    // Search
    'hasSearch'           => 1,
    // Comments
    'hasComments'         => 1,
    // Notification
    'hasNotification'     => 1,
];

// Menu
$modversion['hasMain'] = 1;
if (isset($GLOBALS['xoopsModule']) && is_object($GLOBALS['xoopsModule']) && 'extgallery' === $GLOBALS['xoopsModule']->getVar('dirname')) {
    if (null !== $GLOBALS['xoopsUser'] && is_object($GLOBALS['xoopsUser'])) {
        $modversion['sub'][0]['name'] = _MI_EXTGALLERY_USERALBUM;
        $modversion['sub'][0]['url']  = 'public-useralbum.php?id=' . $GLOBALS['xoopsUser']->uid();

        //        if (isset($GLOBALS['xoopsUser']) && '' !== $GLOBALS['xoopsUser']) {
        //        require_once XOOPS_ROOT_PATH . "/modules/$moduleDirName/class/publicPerm.php";
        $permHandler = Extgallery\PublicPermHandler::getInstance();
        if (count($permHandler->getAuthorizedPublicCat($GLOBALS['xoopsUser'], 'public_upload')) > 0) {
            $modversion['sub'][1]['name'] = _MI_EXTGALLERY_PUBLIC_UPLOAD;
            if ('html' === $GLOBALS['xoopsModuleConfig']['use_extended_upload']) {
                $modversion['sub'][1]['url'] = 'public-upload.php';
            } else {
                $modversion['sub'][1]['url'] = 'public-upload-extended.php';
            }
        }
    }
    //    }
}

// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'] = [
    $moduleDirName . '_' . 'publiccat',
    $moduleDirName . '_' . 'publicphoto',
    $moduleDirName . '_' . 'quota',
    $moduleDirName . '_' . 'publicrating',
    $moduleDirName . '_' . 'publicecard',
];

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_EXTGALLERY_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_EXTGALLERY_HELP1, 'link' => 'page=help1'],
    ['name' => _MI_EXTGALLERY_HELP2, 'link' => 'page=help2'],
    ['name' => _MI_EXTGALLERY_HELP3, 'link' => 'page=help3'],
    ['name' => _MI_EXTGALLERY_HELP4, 'link' => 'page=help4'],
    ['name' => _MI_EXTGALLERY_HELP5, 'link' => 'page=help5'],
    ['name' => _MI_EXTGALLERY_HELP6, 'link' => 'page=help6'],
    ['name' => _MI_EXTGALLERY_HELP7, 'link' => 'page=help7'],
    ['name' => _MI_EXTGALLERY_HELP_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_EXTGALLERY_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_EXTGALLERY_SUPPORT, 'link' => 'page=support'],
];

// Comments
$modversion['hasComments']                    = 1;
$modversion['comments']['itemName']           = 'photoId';
$modversion['comments']['pageName']           = 'public-photo.php';
$modversion['comments']['callbackFile']       = 'include/comment_function.php';
$modversion['comments']['callback']['update'] = $moduleDirName . 'ComUpdate';

// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = $moduleDirName . 'Search';

// Config items
$i                      = 1;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_GENERAL',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

$modversion['config'][] = [
    'name'        => 'display_type',
    'title'       => '_MI_EXTGAL_DISP_TYPE',
    'description' => '_MI_EXTGAL_DISP_TYPE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => [
        _MI_EXTGALLERY_SLIDESHOW => 'slideshow',
        _MI_EXTGALLERY_ALBUM     => 'album',
    ],
    'default'     => 'album',
];

$modversion['config'][] = [
    'name'        => 'display_set_order',
    'title'       => '_MI_EXTGAL_DISP_SET_ORDER',
    'description' => '_MI_EXTGAL_DISP_SET_ORDER_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => [
        _MI_EXTGALLERY_DESC => 'DESC',
        _MI_EXTGALLERY_ASC  => 'ASC',
    ],
    'default'     => 'DESC',
];

$modversion['config'][] = [
    'name'        => 'use_extended_upload',
    'title'       => '_MI_EXTGAL_EXT_UPLOAD',
    'description' => '_MI_EXTGAL_EXT_UPLOAD_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'applet',
    'options'     => [
        _MI_EXTGALLERY_EXTENDED => 'applet',
        _MI_EXTGALLERY_STANDARD => 'html',
    ],
];

$modversion['config'][] = [
    'name'        => 'enable_jquery',
    'title'       => '_MI_EXTGAL_JQUERY',
    'description' => '_MI_EXTGAL_JQUERY_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1, // yes
];

$modversion['config'][] = [
    'name'        => 'usetag',
    'title'       => '_MI_EXTGAL_TAG',
    'description' => '_MI_EXTGAL_TAG_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0, // no
    /**
     * DNPROSSI - Editor to use
     */
];
xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();

$modversion['config'][] = [
    'name'        => 'form_options',
    'title'       => '_MI_EXTGAL_FORM_OPTIONS',
    'description' => '_MI_EXTGAL_FORM_OPTIONS_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtml',
    'options'     => array_flip($editorHandler->getList()),
];

$modversion['config'][] = [
    'name'        => 'photoname_pattern',
    'title'       => '_MI_EXTGAL_NAME_PATTERN',
    'description' => '_MI_EXTGAL_NAME_PATTERN_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '`([a-zA-Z0-9]+)[-_]`',
];

$modversion['config'][] = [
    'name'        => 'max_photosize',
    'title'       => '_MI_EXTGAL_MAX_SIZE',
    'description' => '_MI_EXTGAL_MAX_SIZE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '10485760',
];
++$i;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_ALBUM',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

$modversion['config'][] = [
    'name'        => 'use_ajax_effects',
    'title'       => '_MI_EXTGAL_DISP_TYPE',
    'description' => '_MI_EXTGAL_DISP_TYPE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => [
        _MI_EXTGAL_AJAX_NONE       => 'none',
        _MI_EXTGAL_AJAX_LIGHTBOX   => 'lightbox',
        _MI_EXTGAL_AJAX_OVERLAY    => 'overlay',
        _MI_EXTGAL_AJAX_TOOLTIP    => 'tooltip',
        _MI_EXTGAL_AJAX_FANCYBOX   => 'fancybox',
        _MI_EXTGAL_AJAX_PRETTPHOTO => 'prettyphoto',
    ],
    'default'     => 'none',
];

$modversion['config'][] = [
    'name'        => 'nb_column',
    'title'       => '_MI_EXTGAL_NB_COLUMN',
    'description' => '_MI_EXTGAL_NB_COLUMN_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 4,
];

$modversion['config'][] = [
    'name'        => 'nb_line',
    'title'       => '_MI_EXTGAL_NB_LINE',
    'description' => '_MI_EXTGAL_NB_LINE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 7,
];
++$i;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_SLIDESHOW',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

$modversion['config'][] = [
    'name'        => 'use_slideshow_effects',
    'title'       => '_MI_EXTGAL_DISP_TYPE',
    'description' => '_MI_EXTGAL_DISP_TYPE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => [
        _MI_EXTGAL_SLIDESHOW_GVIEW => 'galleryview',
        _MI_EXTGAL_SLIDESHOW_GRIA  => 'galleria',
        _MI_EXTGAL_SLIDESHOW_MICRO => 'microgallery',
        _MI_EXTGAL_SLIDESHOW_GFIC  => 'galleriffic',
    ],
    'default'     => 'galleryview',
];

++$i;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_PHOTO',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

$modversion['config'][] = [
    'name'        => 'save_large',
    'title'       => '_MI_EXTGAL_SAVE_L',
    'description' => '_MI_EXTGAL_SAVE_L_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0, // no
];

$modversion['config'][] = [
    'name'        => 'save_original',
    'title'       => '_MI_EXTGAL_SAVE_ORIG',
    'description' => '_MI_EXTGAL_SAVE_ORIG_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0, // no
];

$modversion['config'][] = [
    'name'        => 'medium_width',
    'title'       => '_MI_EXTGAL_M_WIDTH',
    'description' => '_MI_EXTGAL_M_WIDTH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 600,
];

$modversion['config'][] = [
    'name'        => 'medium_heigth',
    'title'       => '_MI_EXTGAL_M_HEIGTH',
    'description' => '_MI_EXTGAL_M_HEIGTH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 600,
];

$modversion['config'][] = [
    'name'        => 'medium_quality',
    'title'       => '_MI_EXTGAL_M_QUALITY',
    'description' => '_MI_EXTGAL_M_QUALITY_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 75,
];

$modversion['config'][] = [
    'name'        => 'thumb_width',
    'title'       => '_MI_EXTGAL_T_WIDTH',
    'description' => '_MI_EXTGAL_T_WIDTH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 100,
];

$modversion['config'][] = [
    'name'        => 'thumb_heigth',
    'title'       => '_MI_EXTGAL_T_HEIGTH',
    'description' => '_MI_EXTGAL_T_HEIGTH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 100,
];

$modversion['config'][] = [
    'name'        => 'thumb_quality',
    'title'       => '_MI_EXTGAL_T_QUALITY',
    'description' => '_MI_EXTGAL_T_QUALITY_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 75,
];

$modversion['config'][] = [
    'name'        => 'enable_medium_watermark',
    'title'       => '_MI_EXTGAL_M_WATERMARK',
    'description' => '_MI_EXTGAL_M_WATERMARK_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'enable_medium_border',
    'title'       => '_MI_EXTGAL_M_BORDER',
    'description' => '_MI_EXTGAL_M_BORDER_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'enable_large_watermark',
    'title'       => '_MI_EXTGAL_L_WATERMARK',
    'description' => '_MI_EXTGAL_L_WATERMARK_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'enable_large_border',
    'title'       => '_MI_EXTGAL_L_BORDER',
    'description' => '_MI_EXTGAL_L_BORDER_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

++$i;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_INFO',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

/**
 * DNPROSSI - Info View
 * Shows-hides info from album thumbs or photo
 */
$modversion['config'][] = [
    'name'        => 'info_view',
    'title'       => '_MI_EXTGAL_INFO_VIEW',
    'description' => '_MI_EXTGAL_INFO_VIEW_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'both',
    'options'     => [
        _MI_EXTGAL_INFO_BOTH  => 'both',
        _MI_EXTGAL_INFO_ALBUM => 'album',
        _MI_EXTGAL_INFO_PHOTO => 'photo',
    ],
];

/**
 * DNPROSSI - Public User Info
 * Shows-hides info from public or user album and photo
 */
$modversion['config'][] = [
    'name'        => 'pubusr_info_view',
    'title'       => '_MI_EXTGAL_INFO_PUBUSR',
    'description' => '_MI_EXTGAL_INFO_PUBUSR_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'both',
    'options'     => [
        _MI_EXTGAL_INFO_BOTH   => 'both',
        _MI_EXTGAL_INFO_USER   => 'user',
        _MI_EXTGAL_INFO_PUBLIC => 'public',
    ],
];

/**
 * DNPROSSI - Enable Info
 */
$modversion['config'][] = [
    'name'        => 'enable_info',
    'title'       => '_MI_EXTGAL_ENABLE_INFO',
    'description' => '_MI_EXTGAL_ENABLE_INFO_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'enable_rating',
    'title'       => '_MI_EXTGAL_ENABLE_RATING',
    'description' => '_MI_EXTGAL_ENABLE_RATING_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * DNPROSSI - Enable Ecards
 */
$modversion['config'][] = [
    'name'        => 'enable_ecards',
    'title'       => '_MI_EXTGAL_ENABLE_ECARDS',
    'description' => '_MI_EXTGAL_ENABLE_ECARDS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * DNPROSSI - Enable Photo Hits
 */
$modversion['config'][] = [
    'name'        => 'enable_photo_hits',
    'title'       => '_MI_EXTGAL_ENABLE_PHOTO_HITS',
    'description' => '_MI_EXTGAL_ENABLE_PHOTO_HITS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * DNPROSSI - Enable Submitter Link
 */
$modversion['config'][] = [
    'name'        => 'enable_submitter_lnk',
    'title'       => '_MI_EXTGAL_ENABLE_SUBMITTER_LNK',
    'description' => '_MI_EXTGAL_ENABLE_SUBMITTER_LNK_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * DNPROSSI - Enable Resolution
 */
$modversion['config'][] = [
    'name'        => 'enable_resolution',
    'title'       => '_MI_EXTGAL_ENABLE_RESOLUTION',
    'description' => '_MI_EXTGAL_ENABLE_RESOLUTION_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * DNPROSSI - Enable Submitter Link
 */
$modversion['config'][] = [
    'name'        => 'enable_date',
    'title'       => '_MI_EXTGAL_ENABLE_DATE',
    'description' => '_MI_EXTGAL_ENABLE_DATE_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * DNPROSSI - Enable Download
 */
$modversion['config'][] = [
    'name'        => 'enable_download',
    'title'       => '_MI_EXTGAL_ENABLE_DOWNLOAD',
    'description' => '_MI_EXTGAL_ENABLE_DOWNLOAD_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Voltan - Enable show comments
 */
$modversion['config'][] = [
    'name'        => 'enable_show_comments',
    'title'       => '_MI_EXTGAL_ENABLE_SHOW_COMMENTS',
    'description' => '_MI_EXTGAL_ENABLE_SHOW_COMMENTS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'disp_ph_title',
    'title'       => '_MI_EXTGAL_DISP_PH_TITLE',
    'description' => '_MI_EXTGAL_DISP_PH_TITLE_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'disp_cat_img',
    'title'       => '_MI_EXTGAL_DISP_CAT_IMG',
    'description' => '_MI_EXTGAL_DISP_CAT_IMG_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'display_extra_field',
    'title'       => '_MI_EXTGAL_DISPLAY_EXTRA',
    'description' => '_MI_EXTGAL_DISPLAY_EXTRA_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'allow_html',
    'title'       => '_MI_EXTGAL_ALLOW_HTML',
    'description' => '_MI_EXTGAL_ALLOW_HTML_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

/**
 * Voltan - Social networks and bookmarks
 */
$modversion['config'][] = [
    'name'        => 'show_social_book',
    'title'       => '_MI_EXTGAL_SOCIAL',
    'description' => '_MI_EXTGAL_SOCIAL_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'options'     => [
        _MI_EXTGAL_NONE          => 0,
        _MI_EXTGAL_SOCIALNETWORM => 1,
        _MI_EXTGAL_BOOKMARK      => 2,
        _MI_EXTGAL_INFO_BOTH     => 3,
    ],
    'default'     => 0,
];

++$i;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_RSS',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

$modversion['config'][] = [
    'name'        => 'show_rss',
    'title'       => '_MI_EXTGAL_SHOW_RSS',
    'description' => '_MI_EXTGAL_SHOW_RSS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'perpage_rss',
    'title'       => '_MI_EXTGAL_PERPAGE_RSS',
    'description' => '_MI_EXTGAL_PERPAGE_RSS_DSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];

$modversion['config'][] = [
    'name'        => 'timecache_rss',
    'title'       => '_MI_EXTGAL_TIMECACHE_RSS',
    'description' => '_MI_EXTGAL_TIMECACHE_RSS_DSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 60,
];

$modversion['config'][] = [
    'name'        => 'logo_rss',
    'title'       => '_MI_EXTGAL_LOGO_RSS',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '/assets/images/logo.png',
];

++$i;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_ADMIN',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

$modversion['config'][] = [
    'name'        => 'admin_nb_photo',
    'title'       => '_MI_EXTGAL_ADM_NBPHOTO',
    'description' => '_MI_EXTGAL_ADM_NBPHOTO_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];

++$i;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_GRAPHLIB',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

$modversion['config'][] = [
    'name'        => 'graphic_lib',
    'title'       => '_MI_EXTGAL_GRAPHLIB',
    'description' => '_MI_EXTGAL_GRAPHLIB_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'gd',
    'options'     => ['GD 2' => 'gd', 'Imagick' => 'imagick'],
];

$modversion['config'][] = [
    'name'        => 'graphic_lib_path',
    'title'       => '_MI_EXTGAL_GRAPHLIB_PATH',
    'description' => '_MI_EXTGAL_GRAPHLIB_PATH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '/usr/local/bin/',
];

++$i;
$modversion['config'][] = [
    'name'        => 'break' . $i,
    'title'       => '_MI_EXTGAL_PREFERENCE_BREAK_COMNOTI',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
];

// Hidden preferences field

$modversion['config'][] = [
    'name'        => 'watermark_type',
    'title'       => '_MI_EXTGAL_M_WATERMARK',
    'description' => '_MI_EXTGAL_M_WATERMARK_DESC',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'watermark_font',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'AllStarResort.ttf',
];

$modversion['config'][] = [
    'name'        => 'watermark_text',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => $GLOBALS['xoopsConfig']['sitename'],
];

$modversion['config'][] = [
    'name'        => 'watermark_position',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'tr',
];

$modversion['config'][] = [
    'name'        => 'watermark_color',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#FFFFFF',
];

$modversion['config'][] = [
    'name'        => 'watermark_fontsize',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 16,
];

$modversion['config'][] = [
    'name'        => 'watermark_padding',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 5,
];

$modversion['config'][] = [
    'name'        => 'inner_border_color',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#FFFFFF',
];

$modversion['config'][] = [
    'name'        => 'inner_border_size',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 2,
];

$modversion['config'][] = [
    'name'        => 'outer_border_color',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#000000',
];

$modversion['config'][] = [
    'name'        => 'outer_border_size',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 5,
];

// hidden effects for slideshow

$modversion['config'][] = [
    'name'        => 'galleryview_panelwidth',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 600,
];

$modversion['config'][] = [
    'name'        => 'galleryview_panelheight',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 400,
];

$modversion['config'][] = [
    'name'        => 'galleryview_framewidth',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 80,
];

$modversion['config'][] = [
    'name'        => 'galleryview_frameheight',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 60,
];

$modversion['config'][] = [
    'name'        => 'galleryview_overlayheight',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 62,
];

$modversion['config'][] = [
    'name'        => 'galleryview_overlaycolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#222222',
];

$modversion['config'][] = [
    'name'        => 'galleryview_borderwidth',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'galleryview_bordercolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#cccccc',
];

$modversion['config'][] = [
    'name'        => 'galleryview_navtheme',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'light',
];

$modversion['config'][] = [
    'name'        => 'galleryview_position',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'bottom',
];

$modversion['config'][] = [
    'name'        => 'galleryview_easing',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'swing',
];

$modversion['config'][] = [
    'name'        => 'galleryview_bgcolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#000000',
];

$modversion['config'][] = [
    'name'        => 'galleryview_tspeed',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 1200,
];

$modversion['config'][] = [
    'name'        => 'galleryview_tterval',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 6000,
];

$modversion['config'][] = [
    'name'        => 'galleryview_overlaytc',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#ffffff',
];

$modversion['config'][] = [
    'name'        => 'galleryview_captiontc',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#222222',
];

$modversion['config'][] = [
    'name'        => 'galleryview_opacity',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '0.6',
];

$modversion['config'][] = [
    'name'        => 'galleryview_overlayfs',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '11px',
];

$modversion['config'][] = [
    'name'        => 'galleria_height',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 400,
];

$modversion['config'][] = [
    'name'        => 'galleria_panelwidth',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 620,
];

$modversion['config'][] = [
    'name'        => 'galleria_bgcolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#000000',
];

$modversion['config'][] = [
    'name'        => 'galleria_bcolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#000000',
];

$modversion['config'][] = [
    'name'        => 'galleria_bgimg',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'classic-map',
    /* added by Goffy */
];

$modversion['config'][] = [
    'name'        => 'galleria_autoplay',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'galleria_transition',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'fade',
];

$modversion['config'][] = [
    'name'        => 'galleria_tspeed',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 1000,
];

/* end added by Goffy */
/* added by Goffy */
// hidden effects for galleriffic

$modversion['config'][] = [
    'name'        => 'galleriffic_height',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 600,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_width',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 600,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_bordercolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#cccccc',
];

$modversion['config'][] = [
    'name'        => 'galleriffic_bgcolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#ffffff',
];

$modversion['config'][] = [
    'name'        => 'galleriffic_fontcolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#000000',
];

$modversion['config'][] = [
    'name'        => 'galleriffic_autoplay',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_nb_thumbs',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 10,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_nb_colthumbs',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 2,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_nb_preload',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 10,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_tdelay',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 3000,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_tspeed',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 1000,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_show_descr',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'galleriffic_download',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 0,
];

/* end added by Goffy */
// hidden effects for album

$modversion['config'][] = [
    'name'        => 'album_tooltip_width',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 250,
];

$modversion['config'][] = [
    'name'        => 'album_tooltip_borderwidth',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'album_tooltip_bordercolor',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#cccccc',
];

$modversion['config'][] = [
    'name'        => 'album_overlay_bg',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#ffffff',
];

$modversion['config'][] = [
    'name'        => 'album_overlay_width',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 600,
];

$modversion['config'][] = [
    'name'        => 'album_overlay_height',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 450,
];

$modversion['config'][] = [
    'name'        => 'album_fancybox_color',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '#333333',
];

$modversion['config'][] = [
    'name'        => 'album_fancybox_opacity',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => '0.9',
];

$modversion['config'][] = [
    'name'        => 'album_fancybox_tin',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'none',
];

$modversion['config'][] = [
    'name'        => 'album_fancybox_tout',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'none',
];

$modversion['config'][] = [
    'name'        => 'album_fancybox_title',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'over',
];

$modversion['config'][] = [
    'name'        => 'album_fancybox_showtype',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'group',
];

$modversion['config'][] = [
    'name'        => 'album_prettyphoto_speed',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'fast',
];

$modversion['config'][] = [
    'name'        => 'album_prettyphoto_theme',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'light_square',
];

$modversion['config'][] = [
    'name'        => 'album_prettyphoto_slidspe',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'int',
    'default'     => 2000,
];

$modversion['config'][] = [
    'name'        => 'album_prettyphoto_autopla',
    'title'       => '_MI_EXTGAL_HIDDEN_FIELD',
    'description' => '',
    'formtype'    => 'hidden',
    'valuetype'   => 'text',
    'default'     => 'true',
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => '_MI_EXTGAL_SHOW_SAMPLE_BUTTON',
    'description' => '_MI_EXTGAL_SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => '_MI_EXTGAL_SHOW_DEV_TOOLS',
    'description' => '_MI_EXTGAL_SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

// Templates
$modversion['templates'] = [
    ['file' => 'extgallery_public-categories.tpl', 'description' => ''],
    ['file' => 'extgallery_public-album.tpl', 'description' => ''],
    ['file' => 'extgallery_public-photo.tpl', 'description' => ''],
    ['file' => 'extgallery_index.tpl', 'description' => ''],
    ['file' => 'extgallery_public-sendecard.tpl', 'description' => ''],
    ['file' => 'extgallery_public-viewecard.tpl', 'description' => ''],
    ['file' => 'extgallery_public-useralbum.tpl', 'description' => ''],
    ['file' => 'extgallery_public-userphoto.tpl', 'description' => ''],
    ['file' => 'extgallery_public-slideshow.tpl', 'description' => ''],
    ['file' => 'extgallery_public-upload-applet.tpl', 'description' => ''],
    ['file' => 'extgallery_public-bookmarkme.tpl', 'description' => ''],
    ['file' => 'extgallery_public-rss.tpl', 'description' => ''],
];

// Blocs

$modversion['blocks'][] = [
    'file'        => 'extgallery_blocks.php',
    'name'        => _MI_EXTGAL_B_PHOTO,
    'description' => '',
    'show_func'   => 'extgalleryPhotoShow',
    'options'     => '4|0|0|RandomPhoto|true|none|#ffffff|600|450|250|1|#cccccc|#333333|0.9|none|none|over|group|slow|dark_rounded|2000|true|500|120|300|3|0',
    'edit_func'   => 'extgalleryBlockEdit',
    'template'    => 'extgallery_block.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'extgallery_blocks.php',
    'name'        => _MI_EXTGAL_B_SUB,
    'description' => '',
    'show_func'   => 'extgalleryTopSubmitterShow',
    'options'     => '5|0',
    'edit_func'   => 'extgalleryTopSubmitterEdit',
    'template'    => 'extgallery_block_top_submitter.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'extgallery_blocks.php',
    'name'        => _MI_EXTGAL_B_AJAX,
    'description' => '',
    'show_func'   => 'extgalleryAjax',
    'options'     => '8|RandomPhoto|true|galleryview|600|400|60|40|000|1200|6000|62|222|fff|222|1px solid #ccc|0.6|11px|light|bottom|swing|620|400|#000000|#000000|classic-map|true|fade|1000|small|0',
    'edit_func'   => 'extgalleryAjaxEdit',
    'template'    => 'extgallery_block_ajax.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'extgallery_block_tag.php',
    'name'        => _MI_EXTGAL_B_TOP_TAG,
    'description' => 'Show top tags',
    'show_func'   => 'extgallery_tag_block_top_show',
    'edit_func'   => 'extgallery_tag_block_top_edit',
    'options'     => '50|30|c',
    'template'    => 'extgallery_tag_block_top.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'extgallery_block_tag.php',
    'name'        => _MI_EXTGAL_B_TAG_CLOUD,
    'description' => 'Show tag cloud',
    'show_func'   => 'extgallery_tag_block_cloud_show',
    'edit_func'   => 'extgallery_tag_block_cloud_edit',
    'options'     => '100|0|150|80',
    'template'    => 'extgallery_tag_block_cloud.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'extgallery_blocks.php',
    'name'        => _MI_EXTGAL_B_LIST,
    'description' => 'List of photos',
    'show_func'   => 'extgalleryList',
    'edit_func'   => 'extgalleryListEdit',
    'options'     => '10|1|1|1|RandomPhoto|0',
    'template'    => 'extgallery_block_list.tpl',
];

// Notifications
$modversion['hasNotification'] = 1;
//$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
//$modversion['notification']['lookup_func'] = 'extgalleryNotifyIteminfo';

$modversion['notification']['category'][] = [
    'name'           => 'global',
    'title'          => _MI_EXTGAL_GLOBAL_NOTIFY,
    'description'    => _MI_EXTGAL_GLOBAL_NOTIFYDSC,
    'subscribe_from' => '*',
    'item_name'      => '',
];

$modversion['notification']['category'][] = [
    'name'           => 'album',
    'title'          => _MI_EXTGAL_ALBUM_NOTIFY,
    'description'    => _MI_EXTGAL_ALBUM_NOTIFYDSC,
    'subscribe_from' => 'public-album.php',
    'item_name'      => 'id',
];

$modversion['notification']['category'][] = [
    'name'           => 'event',
    'title'          => _MI_EXTGAL_PHOTO_NOTIFY,
    'description'    => _MI_EXTGAL_PHOTO_NOTIFYDSC,
    'subscribe_from' => 'public-photo.php',
    'item_name'      => 'photoId',
    'allow_bookmark' => 1,
];

$modversion['notification']['event'][1] = [
    'name'          => 'new_photo',
    'category'      => 'global',
    'title'         => _MI_EXTGAL_NEW_PHOTO_NOTIFY,
    'caption'       => _MI_EXTGAL_NEW_PHOTO_NOTIFYCAP,
    'description'   => _MI_EXTGAL_NEW_PHOTO_NOTIFYDSC,
    'mail_template' => 'global_new_photo',
    'mail_subject'  => _MI_EXTGAL_NEW_PHOTO_NOTIFYSBJ,
];

$modversion['notification']['event'][2] = [
    'name'          => 'new_photo_pending',
    'category'      => 'global',
    'title'         => _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFY,
    'caption'       => _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYCAP,
    'description'   => _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYDSC,
    'mail_template' => 'global_new_photo_pending',
    'mail_subject'  => _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYSBJ,
    'admin_only'    => 1,
];

$modversion['notification']['event'][3] = [
    'name'          => 'new_photo_album',
    'category'      => 'album',
    'title'         => _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFY,
    'caption'       => _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYCAP,
    'description'   => _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYDSC,
    'mail_template' => 'album_new_photo',
    'mail_subject'  => _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYSBJ,
];
