<?php
/**
 * ExtGallery Admin settings
 * Manage admin pages
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

require_once __DIR__ . '/admin_header.php';

include __DIR__ . '/../../../include/cp_header.php';
include __DIR__ . '/function.php';
include __DIR__ . '/moduleUpdateFunction.php';

$catHandler   = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
$photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');

xoops_cp_header();

// DNPROSSI - In PHP 5.3.0 "JPG Support" was renamed to "JPEG Support".
// This leads to the following error: "Undefined index: JPG Support in
// Fixed with version compare
if (PHP_VERSION_ID < 50300) {
    $jpegsupport = 'JPG Support';
} else {
    $jpegsupport = 'JPEG Support';
}
$code = 'function gd_info() {
       $array = Array(
                       "GD Version" => "",
                       "FreeType Support" => 0,
                       "FreeType Support" => 0,
                       "FreeType Linkage" => "",
                       "T1Lib Support" => 0,
                       "GIF Read Support" => 0,
                       "GIF Create Support" => 0,
                       "' . $jpegsupport . '" => 0,
                       "PNG Support" => 0,
                       "WBMP Support" => 0,
                       "XBM Support" => 0
                     );
       $gif_support = 0;

       ob_start();
       eval("phpinfo();");
       $info = ob_get_contents();
       ob_end_clean();

       foreach (explode("\n", $info) as $line) {
           if(strpos($line, "GD Version")!==false)
               $array["GD Version"] = trim(str_replace("GD Version", "", strip_tags($line)));
           if(strpos($line, "FreeType Support")!==false)
               $array["FreeType Support"] = trim(str_replace("FreeType Support", "", strip_tags($line)));
           if(strpos($line, "FreeType Linkage")!==false)
               $array["FreeType Linkage"] = trim(str_replace("FreeType Linkage", "", strip_tags($line)));
           if(strpos($line, "T1Lib Support")!==false)
               $array["T1Lib Support"] = trim(str_replace("T1Lib Support", "", strip_tags($line)));
           if(strpos($line, "GIF Read Support")!==false)
               $array["GIF Read Support"] = trim(str_replace("GIF Read Support", "", strip_tags($line)));
           if(strpos($line, "GIF Create Support")!==false)
               $array["GIF Create Support"] = trim(str_replace("GIF Create Support", "", strip_tags($line)));
           if(strpos($line, "GIF Support")!==false)
               $gif_support = trim(str_replace("GIF Support", "", strip_tags($line)));
           if(strpos($line, "' . $jpegsupport . '")!==false)
               $array["' . $jpegsupport . '"] = trim(str_replace("J' . $jpegsupport . '", "", strip_tags($line)));
           if(strpos($line, "PNG Support")!==false)
               $array["PNG Support"] = trim(str_replace("PNG Support", "", strip_tags($line)));
           if(strpos($line, "WBMP Support")!==false)
               $array["WBMP Support"] = trim(str_replace("WBMP Support", "", strip_tags($line)));
           if(strpos($line, "XBM Support")!==false)
               $array["XBM Support"] = trim(str_replace("XBM Support", "", strip_tags($line)));
       }

       if ($gif_support==="enabled") {
           $array["GIF Read Support"]  = 1;
           $array["GIF Create Support"] = 1;
       }

       if ($array["FreeType Support"]==="enabled") {
           $array["FreeType Support"] = 1;    }

       if($array["T1Lib Support"]==="enabled")
           $array["T1Lib Support"] = 1;

       if ($array["GIF Read Support"]==="enabled") {
           $array["GIF Read Support"] = 1;    }

       if($array["GIF Create Support"]==="enabled")
           $array["GIF Create Support"] = 1;

       if($array["' . $jpegsupport . '"]==="enabled")
           $array["' . $jpegsupport . '"] = 1;

       if($array["PNG Support"]==="enabled")
           $array["PNG Support"] = 1;

       if($array["WBMP Support"]==="enabled")
           $array["WBMP Support"] = 1;

       if($array["XBM Support"]==="enabled")
           $array["XBM Support"] = 1;

       return $array;
   }';

/**
 * @param $dir
 *
 * @return mixed
 */
function dskspace($dir)
{
    $s     = stat($dir);
    $space = $s[7];
    if (is_dir($dir)) {
        $dh = opendir($dir);
        while (false !== ($file = readdir($dh))) {
            if ('.' !== $file && '..' !== $file) {
                $space += dskspace($dir . '/' . $file);
            }
        }
        closedir($dh);
    }

    return $space;
}

/**
 * @return array
 */
function imageMagickSupportType()
{
    global $xoopsModuleConfig;

    $cmd = $xoopsModuleConfig['graphic_lib_path'] . 'convert -list format';
    exec($cmd, $data);

    $ret = [
        'GIF Support' => '<span style="color:#FF0000;"><b>KO</b></span>',
        'JPG Support' => '<span style="color:#FF0000;"><b>KO</b></span>',
        'PNG Support' => '<span style="color:#FF0000;"><b>KO</b></span>'
    ];

    foreach ($data as $line) {
        preg_match("`GIF\* GIF.*([rw]{2})`", $line, $matches);
        if (isset($matches[1]) && 'rw' === $matches[1]) {
            $ret['GIF Support'] = '<span style="color:#33CC33;"><b>OK</b></span>';
        }
        preg_match("`JPG\* JPEG.*([rw]{2})`", $line, $matches);
        if (isset($matches[1]) && 'rw' === $matches[1]) {
            $ret['JPG Support'] = '<span style="color:#33CC33;"><b>OK</b></span>';
        }
        preg_match("`PNG\* PNG.*([rw]{2})`", $line, $matches);
        if (isset($matches[1]) && 'rw' === $matches[1]) {
            $ret['PNG Support'] = '<span style="color:#33CC33;"><b>OK</b></span>';
        }
    }

    return $ret;
}

/**
 * @param $path
 *
 * @return bool
 */
function is__writable($path)
{
    //will work in despite of Windows ACLs bug
    //NOTE: use a trailing slash for folders!!!
    //see http://bugs.php.net/bug.php?id=27609
    //see http://bugs.php.net/bug.php?id=30931

    if ('/' === $path{strlen($path) - 1}) {
        // recursively return a temporary file path

        return is__writable($path . uniqid(mt_rand(), true) . '.tmp');
    } elseif (is_dir($path)) {
        return is__writable($path . '/' . uniqid(mt_rand(), true) . '.tmp');
    }
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f  = @fopen($path, 'a');
    if (false === $f) {
        return false;
    }
    fclose($f);
    if (!$rm) {
        unlink($path);
    }

    return true;
}

// dossier dans uploads
$folder = [
    XOOPS_ROOT_PATH . '/uploads/extgallery',
    XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo',
    XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/original',
    XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/large',
    XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/medium',
    XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/thumb'
];

$adminObject = \Xmf\Module\Admin::getInstance();

$adminObject->addInfoBox(_AM_EXTGALLERY_SERVER_CONF);
if ('gd' === $xoopsModuleConfig['graphic_lib']) {
    $gd = gd_info();
    // GD graphic lib
    $test1 = ('' == $gd['GD Version']) ? '<span style="color:#FF0000;"><b>KO</b></span>' : $gd['GD Version'];
    ($gd['GIF Read Support']
     && $gd['GIF Create Support']) ? $test2 = '<span style="color:#33CC33;"><b>OK</b></span>' : $test2 = '<span style="color:#FF0000;"><b>KO</b></span>';
    $gd['' . $jpegsupport . ''] ? $test3 = '<span style="color:#33CC33;"><b>OK</b></span>' : $test3 = '<span style="color:#FF0000;"><b>KO</b></span>';
    $gd['PNG Support'] ? $test4 = '<span style="color:#33CC33;"><b>OK</b></span>' : $test4 = '<span style="color:#FF0000;"><b>KO</b></span>';

    $adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_GRAPH_GD_LIB_VERSION . ' ' . $test1), '');
    $adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_GIF_SUPPORT . ' ' . $test2), '');
    $adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_JPEG_SUPPORT . ' ' . $test3), '');
    $adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_PNG_SUPPORT . ' ' . $test4), '');
}

if ('imagick' === $xoopsModuleConfig['graphic_lib']) {
    // ImageMagick graphic lib
    $cmd = $xoopsModuleConfig['graphic_lib_path'] . 'convert -version';
    exec($cmd, $data, $error);
    $test      = !isset($data[0]) ? '<span style="color:#FF0000;"><b>KO</b></span>' : $data[0];
    $imSupport = imageMagickSupportType();
    $adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_GRAPH_IM_LIB_VERSION . ' ' . $test), '');
    $adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_GIF_SUPPORT . ' ' . $imSupport['GIF Support']), '');
    $adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_JPEG_SUPPORT . ' ' . $imSupport['JPG Support']), '');
    $adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_PNG_SUPPORT . ' ' . $imSupport['PNG Support']), '');
}

$adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_UPLOAD_MAX_FILESIZE . get_cfg_var('upload_max_filesize')), '');
$adminObject->addInfoBoxLine(sprintf(_AM_EXTGALLERY_POST_MAX_SIZE . get_cfg_var('post_max_size')), '');

foreach (array_keys($folder) as $i) {
    $adminObject->addConfigBoxLine($folder[$i], 'folder');
    $adminObject->addConfigBoxLine([$folder[$i], '777'], 'chmod');
}
/** @var XoopsTpl $xoopsTpl */
$xoopsTpl->assign('navigation', $adminObject->displayNavigation(basename(__FILE__)));
$xoopsTpl->assign('index', $adminObject->displayIndex());

// Call template file
$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/extgallery/templates/admin/extgallery_admin_index.tpl');

xoops_cp_footer();
