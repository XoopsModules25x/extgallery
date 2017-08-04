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

xoops_cp_header();

/**
 * @return bool
 */
function extensionInstalled()
{
    return file_exists(XOOPS_ROOT_PATH . '/class/textsanitizer/gallery/gallery.php');
}

/**
 * @return mixed
 */
function extensionActivated()
{
    $conf = include XOOPS_ROOT_PATH . '/class/textsanitizer/config.custom.php';

    return $conf['extensions']['gallery'];
}

function activateExtension()
{
    $conf                          = include XOOPS_ROOT_PATH . '/class/textsanitizer/config.custom.php';
    $conf['extensions']['gallery'] = 1;
    file_put_contents(XOOPS_ROOT_PATH . '/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = " . var_export($conf, true) . "\r?>");
}

function desactivateExtension()
{
    $conf                          = include XOOPS_ROOT_PATH . '/class/textsanitizer/config.custom.php';
    $conf['extensions']['gallery'] = 0;
    file_put_contents(XOOPS_ROOT_PATH . '/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = " . var_export($conf, true) . "\r?>");
}

/** @var XoopsTpl $xoopsTpl */
if (file_exists(XOOPS_ROOT_PATH . '/class/textsanitizer/gallery/gallery.php')) {
    $xoopsTpl->assign('extensioninstalled', true);
} else {
    $xoopsTpl->assign('extensioninstalled', false);
}

// Call template file
$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/extgallery/templates/admin/extgallery_admin_extension.tpl');
xoops_cp_footer();
