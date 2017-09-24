<?php

$sql = new rex_sql();
//$sql->debugsql = true;

// remove single image imagetype
$sql->setQuery('SELECT id FROM `' . $REX['TABLE_PREFIX'] . "679_types` WHERE name LIKE 'magnific_popup_image_thumb'");

if (1 == $sql->getRows()) {
    $imageTypeId = $sql->getValue('id');

    // imagetype
    $sql->setQuery('DELETE FROM `' . $REX['TABLE_PREFIX'] . '679_types` WHERE id = ' . $imageTypeId);

    // effects
    $sql->setQuery('DELETE FROM `' . $REX['TABLE_PREFIX'] . '679_type_effects` WHERE type_id = ' . $imageTypeId);
}

// add gallery image imagetype
$sql->setQuery('SELECT id FROM `' . $REX['TABLE_PREFIX'] . "679_types` WHERE name LIKE 'magnific_popup_gallery_thumb'");

if (1 == $sql->getRows()) {
    $imageTypeId = $sql->getValue('id');

    // imagetype
    $sql->setQuery('DELETE FROM `' . $REX['TABLE_PREFIX'] . '679_types` WHERE id = ' . $imageTypeId);

    // effects
    $sql->setQuery('DELETE FROM `' . $REX['TABLE_PREFIX'] . '679_type_effects` WHERE type_id = ' . $imageTypeId);
}

// done!
$REX['ADDON']['install']['magnific_popup'] = false;
