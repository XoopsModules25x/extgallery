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

require_once __DIR__ . '/../../../include/cp_header.php';
include __DIR__ . '/moduleUpdateFunction.php';

// Change this variable if you use a cloned version of eXtGallery
$localModuleDir = 'extgallery';

$moduleName     = 'extgallery';
$downloadServer = _MU_MODULE_DOWNLOAD_SERVER;

$lastVersionString = getLastModuleVersion();
$moduleFileName    = $moduleName . '-' . $lastVersionString . '.tar.gz';
$langFileName      = $moduleName . '-lang-' . $lastVersionString . '_' . $xoopsConfig['language'] . '.tar.gz';

switch ($step) {

    case 'download':

        xoops_cp_header();

        if (isModuleUpToDate()) {
            echo _AM_EXTGALLERY_UPDATE_OK;
            xoops_cp_footer();
            break;
        }

        if (!$handle = @fopen($downloadServer . $moduleFileName, 'r')) {
            printf(_AM_EXTGALLERY_MD_FILE_DONT_EXIST, $downloadServer, $moduleFileName);
            xoops_cp_footer();
            break;
        }
        $localHandle = @fopen(XOOPS_ROOT_PATH . '/uploads/' . $moduleFileName, 'w+');

        // Downlad module archive
        if ($handle) {
            while (!feof($handle)) {
                $buffer = fread($handle, 8192);
                fwrite($localHandle, $buffer);
            }
            fclose($localHandle);
            fclose($handle);
        }

        // English file are included on module package
        if ('english' !== $xoopsConfig['language']) {
            if (!$handle = @fopen($downloadServer . $langFileName, 'r')) {
                printf(_AM_EXTGALLERY_LG_FILE_DONT_EXIST, $downloadServer, $langFileName);
            } else {
                $localHandle = @fopen(XOOPS_ROOT_PATH . '/uploads/' . $langFileName, 'w+');
                // Download language archive
                if ($handle) {
                    while (!feof($handle)) {
                        $buffer = fread($handle, 8192);
                        fwrite($localHandle, $buffer);
                    }
                    fclose($localHandle);
                    fclose($handle);
                }
            }
        }

        xoops_confirm(['step' => 'install'], 'upgrade.php', _AM_EXTGALLERY_DOWN_DONE, _AM_EXTGALLERY_INSTALL);

        xoops_cp_footer();

        break;

    case 'install':

        xoops_cp_header();

        if (!file_exists(XOOPS_ROOT_PATH . '/uploads/' . $moduleFileName)) {
            echo _AM_EXTGALLERY_MD_FILE_DONT_EXIST_SHORT;
            xoops_cp_footer();

            break;
        }

        $g_pcltar_lib_dir = XOOPS_ROOT_PATH . '/modules/' . $localModuleDir . '/class';
        include __DIR__ . '/../class/pcltar.lib.php';

        //TrOn(5);

        // Extract module files
        PclTarExtract(XOOPS_ROOT_PATH . '/uploads/' . $moduleFileName, XOOPS_ROOT_PATH . '/modules/' . $localModuleDir . '/', 'modules/' . $moduleName . '/');
        // Delete downloaded module's files
        unlink(XOOPS_ROOT_PATH . '/uploads/' . $moduleFileName);

        if (file_exists(XOOPS_ROOT_PATH . '/uploads/' . $langFileName)) {
            // Extract language files
            PclTarExtract(XOOPS_ROOT_PATH . '/uploads/' . $langFileName, XOOPS_ROOT_PATH . '/modules/' . $localModuleDir . '/', 'modules/' . $moduleName . '/');
            // Delete downloaded module's files
            unlink(XOOPS_ROOT_PATH . '/uploads/' . $langFileName);
        }

        // Delete folder created by a small issu in PclTar lib
        if (is_dir(XOOPS_ROOT_PATH . '/modules/' . $localModuleDir . '/modules')) {
            rmdir(XOOPS_ROOT_PATH . '/modules/' . $localModuleDir . '/modules');
        }

        // Delete template_c file
        if ($handle = opendir(XOOPS_ROOT_PATH . '/templates_c')) {
            while (false !== ($file = readdir($handle))) {
                if ('.' !== $file && '..' !== $file && 'index.html' !== $file) {
                    unlink(XOOPS_ROOT_PATH . '/templates_c/' . $file);
                }
            }

            closedir($handle);
        }
        //TrDisplay();

        xoops_confirm(['dirname' => $localModuleDir, 'op' => 'update_ok', 'fct' => 'modulesadmin'], XOOPS_URL . '/modules/system/admin.php', _AM_EXTGALLERY_INSTALL_DONE, _AM_EXTGALLERY_UPDATE);

        xoops_cp_footer();

        break;

    default:
    case 'default':

        redirect_header('index.php', 3, '');

        break;
}
