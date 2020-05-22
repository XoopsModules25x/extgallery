<?php

$search  = ['(CHANGELOG.md)', '(LICENSE.md)'];
$replace = ['(index.php?page=magnific_popup&subpage=help&chapter=changelog)', '(index.php?page=magnific_popup&subpage=help&chapter=license)'];

echo rex_magnific_popup_utils::getHtmlFromMDFile('README.md', $search, $replace);
