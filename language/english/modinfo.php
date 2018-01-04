<?php

define('_MI_EXTGALLERY_NAME', 'eXtGallery');
define('_MI_EXTGAL_DESC', 'eXtGallery is a powerful web gallery module for XOOPS');

// Main menu
define('_MI_EXTGALLERY_USERALBUM', 'My album');
define('_MI_EXTGALLERY_PUBLIC_UPLOAD', 'Public Upload');

// Main administration menu
define('_MI_EXTGALLERY_INDEX', 'Home');
define('_MI_EXTGALLERY_PUBLIC_CAT', 'Category &amp; Albums');
define('_MI_EXTGALLERY_PHOTO', 'Photos');
define('_MI_EXTGALLERY_PERMISSIONS', 'Permissions');
define('_MI_EXTGALLERY_WATERMARK_BORDER', 'Watermark &amp; Border');
define('_MI_EXTGALLERY_SLIDESHOW', 'Slideshow');
define('_MI_EXTGALLERY_EXTENSION', 'Extension');
define('_MI_EXTGALLERY_ALBUM', 'Configs');
define('_MI_EXTGALLERY_ABOUT', 'About');

// Module options
define('_MI_EXTGAL_DISP_TYPE', 'Display type');
define('_MI_EXTGAL_DISP_TYPE_DESC', 'Select the display type for photo');
define('_MI_EXTGAL_DISP_SET_ORDER', 'Display Photo order type');
define('_MI_EXTGAL_DISP_SET_ORDER_DESC', 'Select the display order type for photo, desc or asc , based on submit photo upload time');
define('_MI_EXTGALLERY_DESC', 'Desc');
define('_MI_EXTGALLERY_ASC', 'Asc');
define('_MI_EXTGAL_NB_COLUMN', 'Number of Columns in each album');
define('_MI_EXTGAL_NB_COLUMN_DESC', 'Set number of columns to display photo thumbnails on album view');
define('_MI_EXTGAL_NB_LINE', 'Number of Lines in each album');
define('_MI_EXTGAL_NB_LINE_DESC', 'Set number of lines used to display photo thumbnails on album view');
define('_MI_EXTGAL_SAVE_L', 'Save large photo');
define('_MI_EXTGAL_SAVE_L_DESC', 'If you save large photos - bigger than medium  - the download link will point to them on the photo page');
define('_MI_EXTGAL_M_WIDTH', 'Width for medium photo');
define('_MI_EXTGAL_M_WIDTH_DESC', 'Photo will be resized to set this value as the maximum Width - in pixels');
define('_MI_EXTGAL_M_HEIGTH', 'Height for medium photo');
define('_MI_EXTGAL_M_HEIGTH_DESC', 'Photo will be resized to set this value as the maximum Height - in pixels');
define('_MI_EXTGAL_T_WIDTH', 'Width for photo thumbnail');
define('_MI_EXTGAL_T_WIDTH_DESC', 'Maximum width for photo thumbnails');
define('_MI_EXTGAL_T_HEIGTH', 'Height for photo thumbnail');
define('_MI_EXTGAL_T_HEIGTH_DESC', 'Maximum height for photo thumbnails');
define('_MI_EXTGAL_M_WATERMARK', 'Enable watermarks for medium photos');
define('_MI_EXTGAL_M_WATERMARK_DESC', "Choose whether on not to enable the watermark feature for new medium photos. You must also configure watermark settings under the 'watermarks & borders' tab.");
define('_MI_EXTGAL_M_BORDER', 'Enable border for medium photo');
define('_MI_EXTGAL_M_BORDER_DESC', "Choose whether on not to enable the border feature for new medium photos. You must also configure border settings under the 'watermarks & borders' tab.");
define('_MI_EXTGAL_L_WATERMARK', 'Enable watermarks for large photos');
define('_MI_EXTGAL_L_WATERMARK_DESC', "Choose whether on not to enable the watermark feature for new large photos. You must also configure border settings under the 'watermarks & borders' tab.");
define('_MI_EXTGAL_L_BORDER', 'Enable borders for large photos');
define('_MI_EXTGAL_L_BORDER_DESC', "Choose whether on not to enable the border feature for new large photos. You must also configure border settings under the 'watermarks & borders' tab.");
define('_MI_EXTGAL_NAME_PATTERN', 'Auto photo description pattern');
define(
    '_MI_EXTGAL_NAME_PATTERN_DESC',
       "If you don't provide a description for your photo on upload the file name of the photo will be used to make an auto description.<br> For example, with a \"Tournament-06-may-2006_1.jpg\" photo name, you will end up with \"Tournament 06 may 2006\" as the description"
);
define('_MI_EXTGAL_DISPLAY_EXTRA', 'Display an extra field');
define('_MI_EXTGAL_DISPLAY_EXTRA_DESC', 'Choose whether on not to add more information on submit form. For example, you could use this feature to add a PayPal button to each photo.');
define('_MI_EXTGAL_ALLOW_HTML', 'Allow HTML in extra field');
define('_MI_EXTGAL_ALLOW_HTML_DESC', 'Allow or Disallow HTML code in description and extra field.');
define('_MI_EXTGAL_HIDDEN_FIELD', "This constant is used only to remove PHP notices. This text isn't use in the module");
define('_MI_EXTGAL_SAVE_ORIG', 'Save original photo');
define('_MI_EXTGAL_SAVE_ORIG_DESC', "The original version can be downloaded but is dependant on group permission for \"Download original permissions\"</b>.<br>If a user doesn't have permission to download the original, then the \"large\" photo will be downloaded instead.");
define('_MI_EXTGAL_ADM_NBPHOTO', 'Number of photos to be displayed on admin page');
define('_MI_EXTGAL_ADM_NBPHOTO_DESC', 'Set the number of photos to be displayed on the admin approve and edit table.');
define('_MI_EXTGAL_GRAPHLIB', 'Graphic library');
define('_MI_EXTGAL_GRAPHLIB_DESC', "Select the graphic library you want to use. Be careful with this advanced option, don't modify it if you don't know what the effect will be.");
define('_MI_EXTGAL_GRAPHLIB_PATH', 'Graphic library path');
define('_MI_EXTGAL_GRAPHLIB_PATH_DESC', 'Path to the graphic library on the server <b>WITH</b> trailing slash.');
define('_MI_EXTGAL_ENABLE_RATING', 'Enable photo rating');
define('_MI_EXTGAL_ENABLE_RATING_DESC', 'Choose whether on not to globally enable or disable the photo ratings feature.');
define('_MI_EXTGAL_DISP_PH_TITLE', 'Photo title');
define('_MI_EXTGAL_DISP_PH_TITLE_DESC', 'Choose whether on not to display the title of the photograph inside the album.');
define('_MI_EXTGAL_DISP_CAT_IMG', 'Category image');
define('_MI_EXTGAL_DISP_CAT_IMG_DESC', 'Choose whether or not to display an image to represent the category or not.');
define('_MI_EXTGAL_M_QUALITY', 'Medium photo quality');
define('_MI_EXTGAL_M_QUALITY_DESC', 'Quality for medium photo from 0 (bad) to 100 (good)');
define('_MI_EXTGAL_T_QUALITY', 'Thumb photo quality');
define('_MI_EXTGAL_T_QUALITY_DESC', 'Quality for thumb photo from 0 (bad) to 100 (good)');
//DNPROSSI - Double define to be removed
//define('_MI_EXTGALLERY_ALBUM',"Album");
define('_MI_EXTGAL_EXT_UPLOAD', 'Upload type page');
define('_MI_EXTGAL_EXT_UPLOAD_DESC', 'Select the upload type that is provided to user. Extended require Java plugin.');
define('_MI_EXTGALLERY_EXTENDED', 'Extended');
define('_MI_EXTGALLERY_STANDARD', 'Standard');

// Bloc Name
define('_MI_EXTGAL_B_PHOTO', 'Photo View');
define('_MI_EXTGAL_B_SUB', 'Top Submitter');
define('_MI_EXTGAL_B_AJAX', 'Slideshow photo View');
define('_MI_EXTGAL_B_TOP_TAG', 'eXtGallery Top Tags');
define('_MI_EXTGAL_B_TAG_CLOUD', 'eXtGallery Top Cloud');
define('_MI_EXTGAL_B_LIST', 'List of photos');

// Notifications
define('_MI_EXTGAL_GLOBAL_NOTIFY', 'Global notification');
define('_MI_EXTGAL_GLOBAL_NOTIFYDSC', 'GLOBAL_NOTIFYDSC');
define('_MI_EXTGAL_ALBUM_NOTIFY', 'Album notification');
define('_MI_EXTGAL_ALBUM_NOTIFYDSC', '_MI_EXTGAL_CAT_NOTIFYDSC');
define('_MI_EXTGAL_PHOTO_NOTIFY', 'Photo notification');
define('_MI_EXTGAL_PHOTO_NOTIFYDSC', '_MI_EXTGAL_PHOTO_NOTIFYDSC');
define('_MI_EXTGAL_NEW_PHOTO_NOTIFY', 'New photo');
define('_MI_EXTGAL_NEW_PHOTO_NOTIFYCAP', 'Notify me when a new photo is added');
define('_MI_EXTGAL_NEW_PHOTO_NOTIFYDSC', 'NEW_PHOTO_NOTIFYDSC');
define('_MI_EXTGAL_NEW_PHOTO_NOTIFYSBJ', 'New photo submitted');
define('_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFY', 'Notify me when a new photo is pending');
define('_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYCAP', 'Notify me when a new photo is pending');
define('_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYDSC', '_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYDSC');
define('_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYSBJ', 'New pending photo');
define('_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFY', 'Notify me when a new photo is added in this album');
define('_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYCAP', 'Notify me when a new photo is added in this album');
define('_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYDSC', '_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYDSC');
define('_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYSBJ', 'New photo submitted');

// DNPROSSI ADDED in ver 1.09
define('_MI_EXTGAL_FORM_OPTIONS', 'Form Option');
define('_MI_EXTGAL_FORM_OPTIONS_DESC', "Select the editor to use. If you have a 'simple' install (e.g you use only xoops core editor class, provided in the standard XOOPS core package), then you can just select DHTML and Compact");
define('_MI_EXTGAL_ENABLE_INFO', 'Photo Info View');
define('_MI_EXTGAL_ENABLE_INFO_DESC', 'If disabled all photo info (submitter, resolution, date etc.) will not be viewed');
define('_MI_EXTGAL_ENABLE_ECARDS', 'E-cards View');
define('_MI_EXTGAL_ENABLE_ECARDS_DESC', 'Enables/disables E-card Icon View when <b>Photo Info View</b> is enabled');
define('_MI_EXTGAL_ENABLE_PHOTO_HITS', 'Photo Hits View');
define('_MI_EXTGAL_ENABLE_PHOTO_HITS_DESC', 'Enables/disables Photo Hits View when <b>Photo Info View</b> is enabled');
define('_MI_EXTGAL_ENABLE_SUBMITTER_LNK', 'Submitter View');
define('_MI_EXTGAL_ENABLE_SUBMITTER_LNK_DESC', 'Enables/disables Submitter View when <b>Photo Info View</b> is enabled');
define('_MI_EXTGAL_ENABLE_RESOLUTION', 'Resolution View');
define('_MI_EXTGAL_ENABLE_RESOLUTION_DESC', 'Enables/disables Resolution View when <b>Photo Info View</b> is enabled');
define('_MI_EXTGAL_ENABLE_DATE', 'Date View');
define('_MI_EXTGAL_ENABLE_DATE_DESC', 'Enables/disables Date View when <b>Photo Info View</b> is enabled');
define('_MI_EXTGAL_ENABLE_DOWNLOAD', 'Download View');
define('_MI_EXTGAL_ENABLE_DOWNLOAD_DESC', 'Enables/disables Download and Download Count View when <b>Photo Info View</b> is enabled');
define('_MI_EXTGAL_ENABLE_SHOW_COMMENTS', 'Comments View');
define('_MI_EXTGAL_ENABLE_SHOW_COMMENTS_DESC', 'Enables/disables Comments Count View when <b>Photo Info View</b> is enabled');

define('_MI_EXTGAL_INFO_VIEW', 'Info View');
define('_MI_EXTGAL_INFO_VIEW_DESC', 'Shows-hides info from album thumbs or photo');
define('_MI_EXTGAL_INFO_BOTH', 'Both');
define('_MI_EXTGAL_INFO_ALBUM', 'Album');
define('_MI_EXTGAL_INFO_PHOTO', 'Photo');
define('_MI_EXTGAL_INFO_PUBUSR', 'Public or User Info');
define('_MI_EXTGAL_INFO_PUBUSR_DESC', 'Shows-hides info from public or user album and photo');
define('_MI_EXTGAL_INFO_PUBLIC', 'Public');
define('_MI_EXTGAL_INFO_USER', 'User');
define('_MI_EXTGAL_JQUERY', 'Use jQuery');
define('_MI_EXTGAL_JQUERY_DESC', 'You can enable/disable jQuery in module templates. if jQuery loaded in your theme and you have problem with theme Ajax effects (Interference jQuery library), you must disable jQuery in extGallery and use theme jQuery.');
define('_MI_EXTGAL_SOCIAL', 'Use Social network');
define('_MI_EXTGAL_SOCIAL_DESC', 'You can use Social network and bookmark icons for each photo');
define('_MI_EXTGAL_NONE', 'None');
define('_MI_EXTGAL_SOCIALNETWORM', 'Social Networks');
define('_MI_EXTGAL_BOOKMARK', 'Bookmark me');
define('_MI_EXTGAL_TAG', 'Use TAG module to generate tags');
define('_MI_EXTGAL_TAG_DESC', 'You have to install TAG module in order to use this option');
define('_MI_EXTGAL_SHOW_RSS', 'Show RSS icon');
define('_MI_EXTGAL_SHOW_RSS_DESC', 'Shows-hides RSS icon in module');
define('_MI_EXTGAL_PERPAGE_RSS', 'RSS number of photos');
define('_MI_EXTGAL_PERPAGE_RSS_DSC', 'Select number of new photos in RSS page');
define('_MI_EXTGAL_TIMECACHE_RSS', 'RSS cache time');
define('_MI_EXTGAL_TIMECACHE_RSS_DSC', 'Cache time for RSS pages in minutes');
define('_MI_EXTGAL_LOGO_RSS', 'Site logo for RSS pages');
define('_MI_EXTGAL_MAX_SIZE', 'Max photo size');
define('_MI_EXTGAL_MAX_SIZE_DESC', 'Select max upload photo size for all upload sides');

define('_MI_EXTGAL_AJAX_NONE', 'Normal');
define('_MI_EXTGAL_AJAX_LIGHTBOX', 'Lightbox');
define('_MI_EXTGAL_AJAX_OVERLAY', 'Overlay');
define('_MI_EXTGAL_AJAX_TOOLTIP', 'Tooltip');
define('_MI_EXTGAL_AJAX_FANCYBOX', 'Fancybox');
define('_MI_EXTGAL_AJAX_PRETTPHOTO', 'PrettyPhoto');

define('_MI_EXTGAL_SLIDESHOW_GVIEW', 'galleryview');
define('_MI_EXTGAL_SLIDESHOW_GRIA', 'galleria');
define('_MI_EXTGAL_SLIDESHOW_MICRO', 'microgallery');
define('_MI_EXTGAL_SLIDESHOW_GFIC', 'galleriffic');

define('_MI_EXTGAL_PREFERENCE_BREAK_GENERAL', 'General');
define('_MI_EXTGAL_PREFERENCE_BREAK_PHOTO', 'Photo');
define('_MI_EXTGAL_PREFERENCE_BREAK_INFO', 'Information');
define('_MI_EXTGAL_PREFERENCE_BREAK_ADMIN', 'Admin');
define('_MI_EXTGAL_PREFERENCE_BREAK_RSS', 'Rss');
define('_MI_EXTGAL_PREFERENCE_BREAK_GRAPHLIB', 'Graphic library');
define('_MI_EXTGAL_PREFERENCE_BREAK_COMNOTI', 'Comments and notifications');
define('_MI_EXTGAL_PREFERENCE_BREAK_ALBUM', 'Album');
define('_MI_EXTGAL_PREFERENCE_BREAK_SLIDESHOW', 'Slideshow');

//Help
define('_MI_EXTGALLERY_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_EXTGALLERY_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_EXTGALLERY_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_EXTGALLERY_OVERVIEW', 'Overview');

//help multi-page
define('_MI_EXTGALLERY_HELP1', 'Category/Albums');
define('_MI_EXTGALLERY_HELP2', 'Photos');
define('_MI_EXTGALLERY_HELP3', 'Permissions');
define('_MI_EXTGALLERY_HELP4', 'Watermark & Border');
define('_MI_EXTGALLERY_HELP5', 'Slideshow');
define('_MI_EXTGALLERY_HELP6', 'Extension');
define('_MI_EXTGALLERY_HELP7', 'Configuration');
define('_MI_EXTGALLERY_HELP_DISCLAIMER', 'Disclaimer');
define('_MI_EXTGALLERY_LICENSE', 'License');
define('_MI_EXTGALLERY_SUPPORT', 'Support');
