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
 */

/**
 * @param  XoopsModule $xoopsModule
 * @param  null        $oldVersion
 * @return bool
 */

use XoopsModules\Extgallery;

/**
 * @param \XoopsModule $xoopsModule
 * @param null         $oldVersion
 * @return bool
 */
function xoops_module_update_extgallery(\XoopsModule $xoopsModule, $oldVersion = null)
{
    $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
    $catHandler->rebuild();

    if ($oldVersion < 101) {
        $db = \XoopsDatabaseFactory::getDatabaseConnection();
        // Remove the UNIQUE key on the rating table. This constraint is software cheked now
        $sql = 'ALTER TABLE `' . $db->prefix('extgallery_publicrating') . '` DROP INDEX `photo_rate` ;';
        $db->query($sql);
    }

    if ($oldVersion < 102) {
        $db = \XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'ALTER TABLE `' . $db->prefix('extgallery_publiccat') . '` ADD `cat_imgurl` VARCHAR(150) NOT NULL AFTER `cat_nb_photo` ;';
        $db->query($sql);

        $sql = 'ALTER TABLE `' . $db->prefix('extgallery_publicphoto') . '` ADD `photo_title` VARCHAR(150) NOT NULL AFTER `photo_id` ;';
        $db->query($sql);

        $sql = 'ALTER TABLE `' . $db->prefix('extgallery_publicphoto') . '` ADD `photo_weight` INT(11) NOT NULL AFTER `photo_extra` ;';
        $db->query($sql);
    }

    if ($oldVersion < 104) {
        $db = \XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'ALTER TABLE `' . $db->prefix('extgallery_publicphoto') . "` ADD `dohtml` BOOL NOT NULL DEFAULT '0';";
        $db->query($sql);

        $sql = 'ALTER TABLE `' . $db->prefix('extgallery_publicphoto') . '` CHANGE `photo_desc` `photo_desc` TEXT;';
        $db->query($sql);

        // Set display parmission for all XOOPS base Groups
        $sql       = 'SELECT cat_id FROM `' . $db->prefix('extgallery_publiccat') . '`;';
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

    if ($oldVersion < 106) {
        if (!file_exists(XOOPS_ROOT_PATH . '/uploads/extgallery/index.html')) {
            $indexFile = XOOPS_ROOT_PATH . '/modules/extgallery/include/index.html';
            copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/index.html');
        }

        if (!file_exists(XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/index.html')) {
            $indexFile = XOOPS_ROOT_PATH . '/modules/extgallery/include/index.html';
            copy($indexFile, XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/index.html');
        }
    }

    if ($oldVersion < 107) {

        // Fix extension Bug if it's installed
        if (file_exists(XOOPS_ROOT_PATH . '/class/textsanitizer/gallery/gallery.php')) {
            $conf                          = include XOOPS_ROOT_PATH . '/class/textsanitizer/config.php';
            $conf['extensions']['gallery'] = 1;
            file_put_contents(XOOPS_ROOT_PATH . '/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = " . var_export($conf, true) . "\r?>");
        }
    }

    if ($oldVersion < 109) {
        $db = \XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'ALTER TABLE `' . $db->prefix('extgallery_publiccat') . "` CHANGE `cat_weight` `cat_weight` INT( 11 ) NOT NULL DEFAULT '0' ;";
        $db->query($sql);
    }

    return true;
}
