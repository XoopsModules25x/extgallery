<?php

$search  = array('(CHANGELOG.md)', '(LICENSE.md)');
$replace = array('(index.php?page=magnific_popup&subpage=help&chapter=changelog)', '(index.php?page=magnific_popup&subpage=help&chapter=license)');

echo rex_magnific_popup_utils::getHtmlFromMDFile('README.md', $search, $replace);
