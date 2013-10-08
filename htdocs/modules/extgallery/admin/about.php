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
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 * @version     $Id: about.php 8480 2011-12-13 11:17:38Z beckmi $
 */

include '../../../include/cp_header.php';
include 'function.php';

xoops_cp_header();

$module_info =& $module_handler->get( $xoopsModule->getVar("mid") );

$xoopsTpl->assign("module_name",            $xoopsModule->getVar("name") );
$xoopsTpl->assign("module_dirname",         $xoopsModule->getVar("dirname") );
$xoopsTpl->assign("module_image",           $module_info->getInfo("image") );
$xoopsTpl->assign("module_version",         $module_info->getInfo("version") );
$xoopsTpl->assign("module_description",     $module_info->getInfo("description") );
$xoopsTpl->assign("module_author",          $module_info->getInfo("author") );
$xoopsTpl->assign("module_credits",         $module_info->getInfo("credits") );
$xoopsTpl->assign("module_license_url",     $module_info->getInfo("license_url") );
$xoopsTpl->assign("module_license",         $module_info->getInfo("license") );
$xoopsTpl->assign("module_status",          $module_info->getInfo("module_status") );
$xoopsTpl->assign("module_website_url",     $module_info->getInfo("module_website_url") );
$xoopsTpl->assign("module_website_name",    $module_info->getInfo("module_website_name") );
$xoopsTpl->assign("author_website_url",     $module_info->getInfo("author_website_url") );
$xoopsTpl->assign("author_website_name",    $module_info->getInfo("author_website_name") );

global $xoopsModule;
$xoopsTpl->assign("module_update_date", formatTimestamp($xoopsModule->getVar("last_update"),"m") );

if ( is_readable( $changelog = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/changelog.txt" ) ){
    $xoopsTpl->assign("changelog",          implode("<br />", file( $changelog ) ) );
}

$xoTheme->addStylesheet('modules/extgallery/include/admin.css');

// Call template file
$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/extgallery/templates/admin/extgallery_admin_about.html');

xoops_cp_footer();