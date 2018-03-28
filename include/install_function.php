<?php
/**
 * ExtGallery functions
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
 * @param $module
 * @return bool
 */

function xoops_module_pre_install_extgallery(\XoopsModule $module)
{
    // Check if this XOOPS version is supported
    $minSupportedVersion = explode('.', '2.5.0');
    $currentVersion      = explode('.', substr(XOOPS_VERSION, 6));

    if ($currentVersion[0] > $minSupportedVersion[0]) {
        return true;
    } elseif ($currentVersion[0] == $minSupportedVersion[0]) {
        if ($currentVersion[1] > $minSupportedVersion[1]) {
            return true;
        } elseif ($currentVersion[1] == $minSupportedVersion[1]) {
            if ($currentVersion[2] > $minSupportedVersion[2]) {
                return true;
            } elseif ($currentVersion[2] == $minSupportedVersion[2]) {
                return true;
            }
        }
    }

    return false;
}

/**
 * @param XoopsModule $module
 *
 * @return bool
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

    return true;
}
