<?php
/**
 * ExtGallery Block settings
 * Manage tag Blocks
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
 * @author      Voltan (djvoltan@gmail.com)
 * @package     ExtGallery
 */

/**
 * @param $options
 *
 * @return array
 */
function extgallery_tag_block_cloud_show($options)
{
    $module_dirname = basename(dirname(__DIR__));
    // tags support
    if (xoops_isActiveModule('tag')) {
        require_once XOOPS_ROOT_PATH . '/modules/tag/blocks/block.php';

        return tag_block_cloud_show($options, $module_dirname);
    }
}

/**
 * @param $options
 *
 * @return string
 */
function extgallery_tag_block_cloud_edit($options)
{
    require_once XOOPS_ROOT_PATH . '/modules/tag/blocks/block.php';

    return tag_block_cloud_edit($options);
}

/**
 * @param $options
 *
 * @return array
 */
function extgallery_tag_block_top_show($options)
{
    $module_dirname = basename(dirname(__DIR__));

    // tags support
    if (xoops_isActiveModule('tag')) {
        require_once XOOPS_ROOT_PATH . '/modules/tag/blocks/block.php';

        return tag_block_top_show($options, $module_dirname);
    }
}

/**
 * @param $options
 *
 * @return string
 */
function extgallery_tag_block_top_edit($options)
{
    require_once XOOPS_ROOT_PATH . '/modules/tag/blocks/block.php';

    return tag_block_top_edit($options);
}
