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

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_extgallery(\XoopsModule $module)
{
    require_once __DIR__ . '/common.php';
    /** @var Extgallery\Utility $utility */
    $utility = new \XoopsModules\Extgallery\Utility();
    //check for minimum XOOPS version
    $xoopsSuccess = $utility::checkVerXoops($module);

    // check for minimum PHP version
    $phpSuccess = $utility::checkVerPhp($module);

    if (false !== $xoopsSuccess && false !== $phpSuccess) {
        $moduleTables = &$module->getInfo('tables');
        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }

    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during installation of the module
 * @param \XoopsModule $module
 * @return bool true if installation successful, false if not
 * @internal param XoopsModule $module <a href='psi_element://XoopsModule'>XoopsModule</a>
 */
function xoops_module_install_extgallery(\XoopsModule $module)
{
    require_once __DIR__ . '/../preloads/autoloader.php';

    $moduleDirName = basename(dirname(__DIR__));

    $module_id = $module->getVar('mid');
    /** @var \XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler = xoops_getHandler('groupperm');
    /** @var \XoopsModuleHandler $moduleHandler */
    $configHandler = xoops_getHandler('config');

    /**
     * Default public category permission mask
     */

    // Access right
    $grouppermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_ADMIN, $module_id);
    $grouppermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_USERS, $module_id);
    $grouppermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_ANONYMOUS, $module_id);

    // Public rate
    $grouppermHandler->addRight('extgallery_public_mask', 2, XOOPS_GROUP_ADMIN, $module_id);
    $grouppermHandler->addRight('extgallery_public_mask', 2, XOOPS_GROUP_USERS, $module_id);

    // Public eCard
    $grouppermHandler->addRight('extgallery_public_mask', 4, XOOPS_GROUP_ADMIN, $module_id);
    $grouppermHandler->addRight('extgallery_public_mask', 4, XOOPS_GROUP_USERS, $module_id);

    // Public download
    $grouppermHandler->addRight('extgallery_public_mask', 8, XOOPS_GROUP_ADMIN, $module_id);
    $grouppermHandler->addRight('extgallery_public_mask', 8, XOOPS_GROUP_USERS, $module_id);

    // Public upload
    $grouppermHandler->addRight('extgallery_public_mask', 16, XOOPS_GROUP_ADMIN, $module_id);

    // Public autoapprove
    $grouppermHandler->addRight('extgallery_public_mask', 32, XOOPS_GROUP_ADMIN, $module_id);

    // Public display
    $grouppermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_ADMIN, $module_id);
    $grouppermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_USERS, $module_id);
    $grouppermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_ANONYMOUS, $module_id);

    /**
     * Default User's category permission
     */

    // Private gallery

    // Private rate
    $grouppermHandler->addRight('extgallery_private', 2, XOOPS_GROUP_ADMIN, $module_id);
    $grouppermHandler->addRight('extgallery_private', 2, XOOPS_GROUP_USERS, $module_id);

    // Private eCard
    $grouppermHandler->addRight('extgallery_private', 4, XOOPS_GROUP_ADMIN, $module_id);
    $grouppermHandler->addRight('extgallery_private', 4, XOOPS_GROUP_USERS, $module_id);

    // Private download
    $grouppermHandler->addRight('extgallery_private', 8, XOOPS_GROUP_ADMIN, $module_id);
    $grouppermHandler->addRight('extgallery_private', 8, XOOPS_GROUP_USERS, $module_id);

    // Private autoapprove
    $grouppermHandler->addRight('extgallery_private', 16, XOOPS_GROUP_ADMIN, $module_id);
}
