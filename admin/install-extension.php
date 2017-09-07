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

require_once __DIR__ . '/admin_header.php';
if (isset($_POST['step'])) {
    $step = $_POST['step'];
} else {
    $step = 'default';
}

// Change this variable if you use a cloned version of eXtGallery
$localModuleDir = 'extgallery';

$downloadServer = 'http://downloads.sourceforge.net/xoops/';
//$downloadServer = 'http://localhost/divers/extgallery/';
$extensionFileName = 'extgallery-extension-hook.tar.gz';

switch ($step) {

    case 'download':

        xoops_cp_header();

        if (!$handle = @fopen($downloadServer . $extensionFileName, 'r')) {
            printf(_AM_EXTGALLERY_EXT_FILE_DONT_EXIST, $downloadServer, $extensionFileName);
            xoops_cp_footer();
            break;
        }
        $localHandle = @fopen(XOOPS_ROOT_PATH . '/uploads/' . $extensionFileName, 'w+');

        // Downlad module archive
        if ($handle) {
            while (!feof($handle)) {
                $buffer = fread($handle, 8192);
                fwrite($localHandle, $buffer);
            }
            fclose($localHandle);
            fclose($handle);
        }

        xoops_confirm(['step' => 'install'], 'install-extension.php', _AM_EXTGALLERY_DOWN_DONE, _AM_EXTGALLERY_INSTALL);

        xoops_cp_footer();

        break;

    case 'install':

        if (!file_exists(XOOPS_ROOT_PATH . '/uploads/' . $extensionFileName)) {
            xoops_cp_header();
            echo _AM_EXTGALLERY_EXT_FILE_DONT_EXIST_SHORT;
            xoops_cp_footer();

            break;
        }

        $g_pcltar_lib_dir = XOOPS_ROOT_PATH . '/modules/' . $localModuleDir . '/class';
        include __DIR__ . '/../class/pcltar.lib.php';

        // Extract extension files
        PclTarExtract(XOOPS_ROOT_PATH . '/uploads/' . $extensionFileName, XOOPS_ROOT_PATH . '/class/textsanitizer/', 'class/textsanitizer/');
        // Delete downloaded extension's files
        unlink(XOOPS_ROOT_PATH . '/uploads/' . $extensionFileName);

        // Delete folder created by a small issu in PclTar lib
        if (is_dir(XOOPS_ROOT_PATH . '/class/textsanitizer/class')) {
            rmdir(XOOPS_ROOT_PATH . '/class/textsanitizer/class');
        }

        // Activate extension
        $conf                          = include XOOPS_ROOT_PATH . '/class/textsanitizer/config.php';
        $conf['extensions']['gallery'] = 1;
        file_put_contents(XOOPS_ROOT_PATH . '/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = " . var_export($conf, true) . "\r?>");

        redirect_header('extension.php', 3, _AM_EXTGALLERY_EXTENSION_INSTALLED);

        break;

    default:
    case 'default':

        redirect_header('extension.php', 3, '');

        break;
}
