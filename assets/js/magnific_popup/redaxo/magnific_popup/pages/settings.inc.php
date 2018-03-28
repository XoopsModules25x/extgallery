<?php

$configFile = $REX['INCLUDE_PATH'] . '/addons/magnific_popup/settings.inc.php';

if ('update' === rex_request('func', 'string')) {
    $include_jquery = trim(rex_request('include_jquery', 'string'));

    $REX['ADDON']['magnific_popup']['settings']['include_jquery'] = $include_jquery;

    $content = '
        $REX[\'ADDON\'][\'magnific_popup\'][\'settings\'][\'include_jquery\'] = "' . $include_jquery . '";
    ';

    if (false !== rex_replace_dynamic_contents($configFile, str_replace("\t", '', $content))) {
        echo rex_info($I18N->msg('magnific_popup_configfile_update'));
    } else {
        echo rex_warning($I18N->msg('magnific_popup_configfile_nosave'));
    }
}

if (!is_writable($configFile)) {
    echo rex_warning($I18N->msg('magnific_popup_configfile_nowrite', $configFile));
}

// retrieve links to imagetypes
$sql = new rex_sql();
//$sql->debugsql = true;
$sql->setQuery('SELECT id FROM `' . $REX['TABLE_PREFIX'] . "679_types` WHERE name LIKE 'magnific_popup_image_thumb'");

if (1 == $sql->getRows()) {
    $imageManagerLinkImage = 'index.php?page=image_manager&subpage=effects&type_id=' . $sql->getValue('id');
} else {
    $imageManagerLinkImage = 'index.php?page=image_manager&subpage=types';
}

$sql->setQuery('SELECT id FROM `' . $REX['TABLE_PREFIX'] . "679_types` WHERE name LIKE 'magnific_popup_gallery_thumb'");

if (1 == $sql->getRows()) {
    $imageManagerLinkGallery = 'index.php?page=image_manager&subpage=effects&type_id=' . $sql->getValue('id');
} else {
    $imageManagerLinkGallery = 'index.php?page=image_manager&subpage=types';
}

?>

<div class="rex-addon-output">
    <div class="rex-form">

        <h2 class="rex-hl2"><?php echo $I18N->msg('magnific_popup_settings'); ?></h2>

        <form action="index.php" method="post">

            <fieldset class="rex-form-col-1">
                <div class="rex-form-wrapper">
                    <input type="hidden" name="page" value="magnific_popup">
                    <input type="hidden" name="subpage" value="settings">
                    <input type="hidden" name="func" value="update">

                    <div class="rex-form-row rex-form-element-v1">
                        <p class="rex-form-text">
                            <label for="include_jquery"><?php echo $I18N->msg('magnific_popup_settings_include_jquery'); ?></label>
                            <input type="checkbox" name="include_jquery" id="include_jquery" value="1" <?php if (1 == $REX['ADDON']['magnific_popup']['settings']['include_jquery']) {
    echo 'checked="checked"';
} ?>>
                        </p>
                    </div>

                    <div class="rex-form-row rex-form-element-v1">
                        <p class="rex-form-col-a rex-form-read">
                            <label for="imagetype_image"><?php echo $I18N->msg('magnific_popup_settings_imagetype_image'); ?></label>
                            <span class="rex-form-read" id="imagetype_image"><a href="<?php echo $imageManagerLinkImage; ?>">magnific_popup_image_thumb</a></span>
                        </p>
                    </div>

                    <div class="rex-form-row rex-form-element-v1">
                        <p class="rex-form-col-a rex-form-read">
                            <label for="imagetype_gallery"><?php echo $I18N->msg('magnific_popup_settings_imagetype_gallery'); ?></label>
                            <span class="rex-form-read" id="imagetype_gallery"><a href="<?php echo $imageManagerLinkGallery; ?>">magnific_popup_gallery_thumb</a></span>
                        </p>
                    </div>

                    <div class="rex-form-row rex-form-element-v1">
                        <p class="rex-form-col-a rex-form-read">
                            <label for="css_hint"><?php echo $I18N->msg('magnific_popup_settings_custom_css'); ?></label>
                            <span class="rex-form-read" id="css_hint"><code>/files/addons/magnific_popup/custom.css</code></span>
                        </p>
                    </div>

                    <div class="rex-form-row rex-form-element-v1">
                        <p class="rex-form-submit">
                            <input type="submit" class="rex-form-submit" name="sendit" value="<?php echo $I18N->msg('magnific_popup_settings_save'); ?>">
                        </p>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
