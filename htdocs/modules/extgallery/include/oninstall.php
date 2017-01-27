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
 * @author       XOOPS Development Team
 */

/**
 *
 * Prepares system prior to attempting to install module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_extgallery(XoopsModule $module)
{
    $moduleDirName = basename(dirname(__DIR__));
    $className     = ucfirst($moduleDirName) . 'Utility';
    if (!class_exists($className)) {
        xoops_load('utility', $moduleDirName);
    }
    //check for minimum XOOPS version
    if (!$className::checkVerXoops($module)) {
        return false;
    }

    // check for minimum PHP version
    if (!$className::checkVerPhp($module)) {
        return false;
    }

    $mod_tables =& $module->getInfo('tables');
    foreach ($mod_tables as $table) {
        $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
    }

    return true;
}

/**
 *
 * Performs tasks required during installation of the module
 * @param XoopsModule $xoopsModule
 * @return bool true if installation successful, false if not
 * @internal param XoopsModule $module <a href='psi_element://XoopsModule'>XoopsModule</a>
 *
 */
function xoops_module_install_extgallery(XoopsModule $xoopsModule)
{
    $module_id = $xoopsModule->getVar('mid');
    /** @var XoopsGroupPermHandler $gpermHandler */
    $gpermHandler = xoops_getHandler('groupperm');
    /** @var XoopsConfigHandler $configHandler */
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

    include_once __DIR__ . '/../../../include/cp_header.php';

    if (!isset($moduleDirName)) {
        $moduleDirName = basename(dirname(__DIR__));
    }

    //    $moduleDirName = $xoopsModule->getVar('dirname');
    $configurator = include $GLOBALS['xoops']->path('modules/' . $moduleDirName . '/include/config.php');

    $classUtility = ucfirst($moduleDirName) . 'Utility';
    if (!class_exists($classUtility)) {
        xoops_load('utility', $moduleDirName);
    }

    //    include_once __DIR__ . '/config.php';

    if (count($configurator['uploadFolders']) > 0) {
        //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (array_keys($configurator['uploadFolders']) as $i) {
            $classUtility::createFolder($configurator['uploadFolders'][$i]);
        }
    }
    if (count($configurator['copyFiles']) > 0) {
        $file = __DIR__ . '/../assets/images/blank.png';
        foreach (array_keys($configurator['copyFiles']) as $i) {
            $dest = $configurator['copyFiles'][$i] . '/blank.png';
            $classUtility::copyFile($file, $dest);
        }
    }

    return true;
}
