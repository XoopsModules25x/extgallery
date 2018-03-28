<?php
$moduleInput  = rex_get_file_contents($REX['INCLUDE_PATH'] . '/addons/magnific_popup/module/image/input.php');
$moduleOutput = rex_get_file_contents($REX['INCLUDE_PATH'] . '/addons/magnific_popup/module/image/output.php');

// Ist Modul schon vorhanden ?
$searchtext = 'module: magnific_popup_image_out';

$gm = rex_sql::factory();
$gm->setQuery('SELECT * FROM ' . $REX['TABLE_PREFIX'] . 'module WHERE ausgabe LIKE "%' . $searchtext . '%"');

$module_id   = 0;
$module_name = '';

foreach ($gm->getArray() as $module) {
    $module_id   = $module['id'];
    $module_name = $module['name'];
}

if (isset($_REQUEST['install']) && 1 == $_REQUEST['install']) {
    $module_name = $I18N->msg('magnific_popup_module_name_image');

    $mi = rex_sql::factory();
    // $mi->debugsql = 1;
    $mi->setTable('rex_module');
    $mi->setValue('eingabe', addslashes($moduleInput));
    $mi->setValue('ausgabe', addslashes($moduleOutput));

    if (isset($_REQUEST['module_id']) && $module_id == $_REQUEST['module_id']) {
        // altes Module aktualisieren
        $mi->setWhere('id="' . $module_id . '"');
        $mi->update();

        // article updaten
        rex_generateAll();

        echo rex_info($I18N->msg('module_updated') . ' | ' . $I18N->msg('delete_cache_message'));
    } else {
        // neues Modul einf&uuml;gen
        $mi->setValue('name', $module_name);
        $mi->insert();
        $module_id = (int)$mi->getLastId();

        echo rex_info($I18N->msg('magnific_popup_module_added', $module_name));
    }
}
?>

<div class="rex-addon-output">
    <h2 class="rex-hl2"><?php echo $I18N->msg('magnific_popup_image_module'); ?></h2>
    <div class="rex-area-content module">
        <ul>
            <?php
            if ($module_id > 0) {
                if (!isset($_REQUEST['install'])) {
                    echo '<li><a href="index.php?page=magnific_popup&amp;subpage=image_module&amp;install=1&amp;module_id=' . $module_id . '">' . $I18N->msg('magnific_popup_module_update') . '</a></li>';
                }
            } else {
                if (!isset($_REQUEST['install'])) {
                    echo '<li><a href="index.php?page=magnific_popup&amp;subpage=image_module&amp;install=1">' . $I18N->msg('magnific_popup_module_install') . '</a></li>';
                }
            }
            ?>
        </ul>
        <p class="headline"><?php echo $I18N->msg('magnific_popup_module_input'); ?></p><?php rex_highlight_string($moduleInput); ?>
        <p>&nbsp;</p>
        <p class="headline"><?php echo $I18N->msg('magnific_popup_module_output'); ?></p><?php rex_highlight_string($moduleOutput); ?>
    </div>
</div>
