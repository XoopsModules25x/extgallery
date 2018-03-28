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
 * @author       XOOPS Development Team
 */

use XoopsModules\Extgallery;
use XoopsModules\Extgallery\Common;

/**
 *
 * Prepares system prior to attempting to install module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_extgallery(\XoopsModule $module)
{
    //    include __DIR__ . '/../preloads/autoloader.php';
    include __DIR__ . '/common.php';
    /** @var Extgallery\Utility $utility */
    $utility = new Extgallery\Utility();
    //check for minimum XOOPS version
    $xoopsSuccess = $utility::checkVerXoops($module);

    // check for minimum PHP version
    $phpSuccess   = $utility::checkVerPhp($module);

    if (false !== $xoopsSuccess && false !==  $phpSuccess) {
        $moduleTables =& $module->getInfo('tables');
        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }

    return $xoopsSuccess && $phpSuccess;
}

/**
 *
 * Performs tasks required during installation of the module
 * @param XoopsModule $module
 * @return bool true if installation successful, false if not
 * @internal param XoopsModule $module <a href='psi_element://XoopsModule'>XoopsModule</a>
 *
 */
function xoops_module_install_extgallery(\XoopsModule $module)
{
    $module_id = $module->getVar('mid');
    /** @var XoopsGroupPermHandler $gpermHandler */
    $gpermHandler = xoops_getHandler('groupperm');
    /** @var XoopsModuleHandler $moduleHandler */
    $configHandler = xoops_getHandler('config');

    /**
     * Default public category permission mask
     */

    // Access right
    $gpermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_ADMIN, $module_id);
    $gpermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_USERS, $module_id);
    $gpermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_ANONYMOUS, $module_id);

    // Public rate
    $gpermHandler->addRight('extgallery_public_mask', 2, XOOPS_GROUP_ADMIN, $module_id);
    $gpermHandler->addRight('extgallery_public_mask', 2, XOOPS_GROUP_USERS, $module_id);

    // Public eCard
    $gpermHandler->addRight('extgallery_public_mask', 4, XOOPS_GROUP_ADMIN, $module_id);
    $gpermHandler->addRight('extgallery_public_mask', 4, XOOPS_GROUP_USERS, $module_id);

    // Public download
    $gpermHandler->addRight('extgallery_public_mask', 8, XOOPS_GROUP_ADMIN, $module_id);
    $gpermHandler->addRight('extgallery_public_mask', 8, XOOPS_GROUP_USERS, $module_id);

    // Public upload
    $gpermHandler->addRight('extgallery_public_mask', 16, XOOPS_GROUP_ADMIN, $module_id);

    // Public autoapprove
    $gpermHandler->addRight('extgallery_public_mask', 32, XOOPS_GROUP_ADMIN, $module_id);

    // Public display
    $gpermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_ADMIN, $module_id);
    $gpermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_USERS, $module_id);
    $gpermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_ANONYMOUS, $module_id);

    /**
     * Default User's category permission
     */

    // Private gallery

    // Private rate
    $gpermHandler->addRight('extgallery_private', 2, XOOPS_GROUP_ADMIN, $module_id);
    $gpermHandler->addRight('extgallery_private', 2, XOOPS_GROUP_USERS, $module_id);

    // Private eCard
    $gpermHandler->addRight('extgallery_private', 4, XOOPS_GROUP_ADMIN, $module_id);
    $gpermHandler->addRight('extgallery_private', 4, XOOPS_GROUP_USERS, $module_id);

    // Private download
    $gpermHandler->addRight('extgallery_private', 8, XOOPS_GROUP_ADMIN, $module_id);
    $gpermHandler->addRight('extgallery_private', 8, XOOPS_GROUP_USERS, $module_id);

    // Private autoapprove
    $gpermHandler->addRight('extgallery_private', 16, XOOPS_GROUP_ADMIN, $module_id);

    /*

      // Create eXtGallery main upload directory
      $dir = XOOPS_ROOT_PATH . '/uploads/extgallery';
      if (!is_dir($dir)) {
          mkdir($dir, 0777);
      }
      chmod($dir, 0777);
      // Create directory for photo in public album
      $dir = XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo';
      if (!is_dir($dir)) {
          mkdir($dir, 0777);
      }
      chmod($dir, 0777);
      $dir = XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/original';
      if (!is_dir($dir)) {
          mkdir($dir, 0777);
      }
      chmod($dir, 0777);
      $dir = XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/large';
      if (!is_dir($dir)) {
          mkdir($dir, 0777);
      }
      chmod($dir, 0777);
      $dir = XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/medium';
      if (!is_dir($dir)) {
          mkdir($dir, 0777);
      }
      chmod($dir, 0777);
      $dir = XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/thumb';
      if (!is_dir($dir)) {
          mkdir($dir, 0777);
      }
      chmod($dir, 0777);



      // Create directory for photo in user's album
      //mkdir(XOOPS_ROOT_PATH."/uploads/extgallery/user-photo");

      // Copy index.html files on uploads folders
      $indexFile = XOOPS_ROOT_PATH . '/modules/extgallery/include/index.html';
      copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/index.html');
      copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/index.html');
      copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/original/index.html');
      copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/large/index.html');
      copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/medium/index.html');
      copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/thumb/index.html');

  */

    require_once __DIR__ . '/../../../include/cp_header.php';

    $moduleDirName = basename(dirname(__DIR__));

    /** @var Extgallery\Helper $helper */
    /** @var Extgallery\Utility $utility */
    /** @var Extgallery\Common\Configurator $configurator */
    $helper = Extgallery\Helper::getInstance();
    $utility      = new Extgallery\Utility();
    $configurator = new Common\Configurator();

    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');



    $moduleId     = $module->getVar('mid');
    $moduleId2    = $helper->getModule()->mid();
    //$moduleName = $module->getVar('name');
    $gpermHandler = xoops_getHandler('groupperm');

    /** @var Extgallery\Utility $utility */
    $utility = new Extgallery\Utility();

    //    require_once __DIR__ . '/config.php';

    if (count($configurator->uploadFolders) > 0) {
        //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (array_keys($configurator->uploadFolders) as $i) {
            $utility::createFolder($configurator->uploadFolders[$i]);
        }
    }
    if (count($configurator->copyBlankFiles) > 0) {
        $file = __DIR__ . '/../assets/images/blank.png';
        foreach (array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.png';
            $utility::copyFile($file, $dest);
        }
    }

    //  ---  CREATE FOLDERS ---------------
    if (count($configurator->uploadFolders) > 0) {
        //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (array_keys($configurator->uploadFolders) as $i) {
            $utility::createFolder($configurator->uploadFolders[$i]);
        }
    }

    //  ---  COPY blank.png FILES ---------------
    if (count($configurator->copyBlankFiles) > 0) {
        $file = __DIR__ . '/../assets/images/blank.png';
        foreach (array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.png';
            $utility::copyFile($file, $dest);
        }
    }

    /*
    //  ---  COPY test folder files ---------------
if (count($configurator->copyTestFolders) > 0) {
    //        $file = __DIR__ . '/../testdata/images/';
    foreach (array_keys($configurator->copyTestFolders) as $i) {
        $src  = $configurator->copyTestFolders[$i][0];
        $dest = $configurator->copyTestFolders[$i][1];
        $utility::xcopy($src, $dest);
    }
}
*/

    //delete .html entries from the tpl table
    $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('tplfile') . " WHERE `tpl_module` = '" . $module->getVar('dirname', 'n') . "' AND `tpl_file` LIKE '%.html%'";
    $GLOBALS['xoopsDB']->queryF($sql);

    return true;
}
