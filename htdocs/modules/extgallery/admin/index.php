<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project http://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author     XOOPS Development Team
 */

include_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();

$classUtilities = ucfirst($moduleDirName) . 'Utilities';
if (!class_exists($classUtilities)) {
    xoops_load('utilities', $moduleDirName);
}

foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
    $classUtilities::createFolder($uploadFolders[$i]);
    $adminObject->addConfigBoxLine($uploadFolders[$i], 'folder');
    //    $indexAdmin->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}


// DNPROSSI - In PHP 5.3.0 "JPG Support" was renamed to "JPEG Support".
// This leads to the following error: "Undefined index: JPG Support in
// Fixed with version compare
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    $jpegsupport = 'JPG Support';
} else {
    $jpegsupport = 'JPEG Support';
}

$adminObject->addInfoBox(_AM_EXTGALLERY_SERVER_CONF);
if ($xoopsModuleConfig['graphic_lib'] === 'GD') {
    $gd = gd_info();
    // GD graphic lib
    $test1 = ($gd['GD Version'] == '') ? "<span style=\"color:#FF0000;\"><b>KO</b></span>" : $gd['GD Version'];
    ($gd['GIF Read Support']
     && $gd['GIF Create Support']) ? $test2 = "<span style=\"color:#33CC33;\"><b>OK</b></span>" : $test2 = "<span style=\"color:#FF0000;\"><b>KO</b></span>";
    $gd['' . $jpegsupport . ''] ? $test3 = "<span style=\"color:#33CC33;\"><b>OK</b></span>" : $test3 = "<span style=\"color:#FF0000;\"><b>KO</b></span>";
    $gd['PNG Support'] ? $test4 = "<span style=\"color:#33CC33;\"><b>OK</b></span>" : $test4 = "<span style=\"color:#FF0000;\"><b>KO</b></span>";

    $adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_GRAPH_GD_LIB_VERSION . ' ' . $test1);
    $adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_GIF_SUPPORT . ' ' . $test2);
    $adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_JPEG_SUPPORT . ' ' . $test3);
    $adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_PNG_SUPPORT . ' ' . $test4);
}

if ($xoopsModuleConfig['graphic_lib'] === 'IM') {
    // ImageMagick graphic lib
    $cmd = $xoopsModuleConfig['graphic_lib_path'] . 'convert -version';
    exec($cmd, $data, $error);
    $test      = !isset($data[0]) ? "<span style=\"color:#FF0000;\"><b>KO</b></span>" : $data[0];
    $imSupport = imageMagickSupportType();
    $adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_GRAPH_IM_LIB_VERSION . ' ' . $test);
    $adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_GIF_SUPPORT . ' ' . $imSupport['GIF Support']);
    $adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_JPEG_SUPPORT . ' ' . $imSupport['JPG Support']);
    $adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_PNG_SUPPORT . ' ' . $imSupport['PNG Support']);
}

$adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_UPLOAD_MAX_FILESIZE . get_cfg_var('upload_max_filesize'));
$adminObject->addInfoBoxLine(_AM_EXTGALLERY_SERVER_CONF, _AM_EXTGALLERY_POST_MAX_SIZE . get_cfg_var('post_max_size'));


echo $adminObject->addNavigation(basename(__FILE__));
echo $adminObject->renderIndex();

include_once __DIR__ . '/admin_footer.php';
