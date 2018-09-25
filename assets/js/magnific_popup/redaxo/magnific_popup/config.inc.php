<?php
// init addon
$REX['ADDON']['name']['magnific_popup']        = 'Magnific Popup';
$REX['ADDON']['page']['magnific_popup']        = 'magnific_popup';
$REX['ADDON']['version']['magnific_popup']     = '1.1.2';
$REX['ADDON']['author']['magnific_popup']      = 'RexDude';
$REX['ADDON']['supportpage']['magnific_popup'] = 'forum.redaxo.de';
$REX['ADDON']['perm']['magnific_popup']        = 'magnific_popup[]';

// permissions
$REX['PERM'][] = 'magnific_popup[]';

// includes
require_once $REX['INCLUDE_PATH'] . '/addons/magnific_popup/settings.inc.php';
require_once $REX['INCLUDE_PATH'] . '/addons/magnific_popup/classes/class.rex_magnific_popup_utils.inc.php';

if ($REX['REDAXO']) {
    // add lang file
    $I18N->appendFile($REX['INCLUDE_PATH'] . '/addons/magnific_popup/lang/');

    // add subpages
    $REX['ADDON']['magnific_popup']['SUBPAGES'] = [
        ['', $I18N->msg('magnific_popup_start')],
        ['image_module', $I18N->msg('magnific_popup_image_module')],
        ['gallery_module', $I18N->msg('magnific_popup_gallery_module')],
        ['settings', $I18N->msg('magnific_popup_settings')],
        ['help', $I18N->msg('magnific_popup_help')],
    ];
} else {
    rex_register_extension('OUTPUT_FILTER', 'rex_magnific_popup_utils::includeMagnificPopup');
}
