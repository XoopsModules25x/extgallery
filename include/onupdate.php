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
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @author       XOOPS Development Team
 */

if ((!defined('XOOPS_ROOT_PATH')) || !($GLOBALS['xoopsUser'] instanceof \XoopsUser)
    || !$GLOBALS['xoopsUser']->IsAdmin()) {
    exit('Restricted access' . PHP_EOL);
}

/**
 * @param string $tablename
 *
 * @return bool
 */
function tableExists($tablename)
{
    $result = $GLOBALS['xoopsDB']->queryF("SHOW TABLES LIKE '$tablename'");

    return $GLOBALS['xoopsDB']->getRowsNum($result) > 0;
}

/**
 *
 * Prepares system prior to attempting to install module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_extgallery(\XoopsModule $module)
{
    /** @var Extgallery\Helper $helper */
    /** @var Extgallery\Utility $utility */
    $moduleDirName = basename(dirname(__DIR__));
    $helper       = Extgallery\Helper::getInstance();
    $utility      = new Extgallery\Utility();

    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);
    return $xoopsSuccess && $phpSuccess;
}

/**
 *
 * Performs tasks required during update of the module
 * @param XoopsModule $module {@link XoopsModule}
 * @param null        $previousVersion
 *
 * @return bool true if update successful, false if not
 */

use XoopsModules\Extgallery;

/**
 * @param \XoopsModule $module
 * @param null         $previousVersion
 * @return bool
 */
function xoops_module_update_extgallery(\XoopsModule $module, $previousVersion = null)
{
    global $xoopsDB;

    $moduleDirName = basename(dirname(__DIR__));
    $capsDirName   = strtoupper($moduleDirName);

    /** @var Extgallery\Helper $helper */
    /** @var Extgallery\Utility $utility */
    /** @var Extgallery\Common\Configurator $configurator */
    $helper  = Extgallery\Helper::getInstance();
    $utility = new Extgallery\Utility();
    $configurator = new Extgallery\Common\Configurator();

    $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
    $catHandler->rebuild();

    if ($previousVersion < 101) {
        $db = \XoopsDatabaseFactory::getDatabaseConnection();
        // Remove the UNIQUE key on the rating table. This constraint is software cheked now
        $sql = 'ALTER TABLE `' . $db->prefix($moduleDirName . '_publicrating') . '` DROP INDEX `photo_rate` ;';
        $db->query($sql);
    }

    if ($previousVersion < 102) {
        $db = \XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'ALTER TABLE `' . $db->prefix($moduleDirName . '_publiccat') . '` ADD `cat_imgurl` VARCHAR(150) NOT NULL AFTER `cat_nb_photo` ;';
        $db->query($sql);

        $sql = 'ALTER TABLE `' . $db->prefix($moduleDirName . '_publicphoto') . '` ADD `photo_title` VARCHAR(150) NOT NULL AFTER `photo_id` ;';
        $db->query($sql);

        $sql = 'ALTER TABLE `' . $db->prefix($moduleDirName . '_publicphoto') . '` ADD `photo_weight` INT(11) NOT NULL AFTER `photo_extra` ;';
        $db->query($sql);
    }

    if ($previousVersion < 104) {
        $db = \XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'ALTER TABLE `' . $db->prefix($moduleDirName . '_publicphoto') . "` ADD `dohtml` BOOL NOT NULL DEFAULT '0';";
        $db->query($sql);

        $sql = 'ALTER TABLE `' . $db->prefix($moduleDirName . '_publicphoto') . '` CHANGE `photo_desc` `photo_desc` TEXT;';
        $db->query($sql);

        // Set display parmission for all XOOPS base Groups
        $sql       = 'SELECT cat_id FROM `' . $db->prefix($moduleDirName . '_publiccat') . '`;';
        $result    = $db->query($sql);
        $module_id = $xoopsModule->getVar('mid');
        /** @var XoopsGroupPermHandler $gpermHandler */
        $gpermHandler = xoops_getHandler('groupperm');
        while (false !== ($cat = $db->fetchArray($result))) {
            $gpermHandler->addRight('public_displayed', $cat['cat_id'], XOOPS_GROUP_ADMIN, $module_id);
            $gpermHandler->addRight('public_displayed', $cat['cat_id'], XOOPS_GROUP_USERS, $module_id);
            $gpermHandler->addRight('public_displayed', $cat['cat_id'], XOOPS_GROUP_ANONYMOUS, $module_id);
        }
    }

    if ($previousVersion < 106) {
        if (!file_exists(XOOPS_ROOT_PATH . '/uploads/extgallery/index.html')) {
            $indexFile = XOOPS_ROOT_PATH . '/modules/extgallery/include/index.html';
            copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/index.html');
        }

        if (!file_exists(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/index.html')) {
            $indexFile = XOOPS_ROOT_PATH . '/modules/extgallery/include/index.html';
            copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/index.html');
        }
    }

    if ($previousVersion < 107) {

        // Fix extension Bug if it's installed
        if (file_exists(XOOPS_ROOT_PATH . '/class/textsanitizer/gallery/gallery.php')) {
            $conf                          = include XOOPS_ROOT_PATH . '/class/textsanitizer/config.php';
            $conf['extensions']['gallery'] = 1;
            file_put_contents(XOOPS_ROOT_PATH . '/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = " . var_export($conf, true) . "\r?>");
        }
    }

    if ($previousVersion < 109) {
        $db = \XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'ALTER TABLE `' . $db->prefix($moduleDirName . '_publiccat') . "` CHANGE `cat_weight` `cat_weight` INT( 11 ) NOT NULL DEFAULT '0' ;";
        $db->query($sql);
    }

    if ($previousVersion < 114) {
        // delete old HTML template files ============================
        $templateDirectory = $GLOBALS['xoops']->path('modules/' . $moduleDirName . '/templates/');
        if (is_dir($templateDirectory)) {
            $templateList = array_diff(scandir($templateDirectory, SCANDIR_SORT_NONE), ['..', '.']);
            foreach ($templateList as $k => $v) {
                $fileInfo = new \SplFileInfo($templateDirectory . $v);
                if ('html' === $fileInfo->getExtension() && 'index.html' !== $fileInfo->getFilename()) {
                    if (file_exists($templateDirectory . $v)) {
                        unlink($templateDirectory . $v);
                    }
                }
            }
        }
        // delete old block html template files ============================
        $templateDirectory = $GLOBALS['xoops']->path('modules/' . $moduleDirName . '/templates/blocks/');
        if (is_dir($templateDirectory)) {
            $templateList = array_diff(scandir($templateDirectory, SCANDIR_SORT_NONE), ['..', '.']);
            foreach ($templateList as $k => $v) {
                $fileInfo = new \SplFileInfo($templateDirectory . $v);
                if ('html' === $fileInfo->getExtension() && 'index.html' !== $fileInfo->getFilename()) {
                    if (file_exists($templateDirectory . $v)) {
                        unlink($templateDirectory . $v);
                    }
                }
            }
        }

        // delete old admin html template files ============================
        $templateDirectory = $GLOBALS['xoops']->path('modules/' . $module->getVar('dirname', 'n') . '/templates/admin/');
        if (is_dir($templateDirectory)) {
            $templateList = array_diff(scandir($templateDirectory, SCANDIR_SORT_NONE), ['..', '.']);
            foreach ($templateList as $k => $v) {
                $fileInfo = new \SplFileInfo($templateDirectory . $v);
                if ('html' === $fileInfo->getExtension() && 'index.html' !== $fileInfo->getFilename()) {
                    if (file_exists($templateDirectory . $v)) {
                        unlink($templateDirectory . $v);
                    }
                }
            }
        }

        $configurator = include __DIR__ . '/config.php';
        /** @var Extgallery\Utility $utility */
        $utility = new Extgallery\Utility();

        //  ---  COPY blank.png FILES ---------------
        if (count($configurator->copyBlankFiles) > 0) {
            $file = __DIR__ . '/../assets/images/blank.png';
            foreach (array_keys($configurator->copyFiles) as $i) {
                $dest = $configurator->copyFiles[$i] . '/blank.png';
                $utility::copyFile($file, $dest);
            }
        }

        //  ---  DELETE OLD FILES ---------------
        if (count($configurator->oldFiles) > 0) {
            //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
            foreach (array_keys($configurator->oldFiles) as $i) {
                $tempFile = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFiles[$i]);
                if (is_file($tempFile)) {
                    unlink($tempFile);
                }
            }
        }

        //---------------------

        //delete .html entries from the tpl table
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('tplfile') . " WHERE `tpl_module` = '" . $module->getVar('dirname', 'n') . '\' AND `tpl_file` LIKE \'%.html%\'';
        $xoopsDB->queryF($sql);

        // Load class XoopsFile ====================
        xoops_load('XoopsFile');

        //delete /images directory ============
        $imagesDirectory = $GLOBALS['xoops']->path('modules/' . $module->getVar('dirname', 'n') . '/images/');
        $folderHandler   = XoopsFile::getHandler('folder', $imagesDirectory);
        $folderHandler->delete($imagesDirectory);
    }

    $gpermHandler = xoops_getHandler('groupperm');

    return $gpermHandler->deleteByModule($module->getVar('mid'), 'item_read');
}
