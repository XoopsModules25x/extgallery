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
 * @param $option
 * @return bool
 */

function gal_getmoduleoption($option)
{
    global $xoopsModuleConfig, $xoopsModule;
    static $tbloptions = [];
    if (is_array($tbloptions) && array_key_exists($option, $tbloptions)) {
        return $tbloptions[$option];
    }

    $retval = false;
    if (isset($xoopsModuleConfig)
        && (is_object($xoopsModule) && 'extgallery' === $xoopsModule->getVar('dirname')
            && $xoopsModule->getVar('isactive'))) {
        if (isset($xoopsModuleConfig[$option])) {
            $retval = $xoopsModuleConfig[$option];
        }
    } else {
        /** @var XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $module        = $moduleHandler->getByDirname('extgallery');

        /** @var XoopsModuleHandler $moduleHandler */
        $configHandler = xoops_getHandler('config');
        if ($module) {
            $moduleConfig = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
            if (isset($moduleConfig[$option])) {
                $retval = $moduleConfig[$option];
            }
        }
    }
    $tbloptions[$option] = $retval;

    return $retval;
}

/**
 * @param $caption
 * @param $name
 * @param $value
 * @param $rows
 * @param $cols
 * @param $width
 * @param $height
 * @param $supplemental
 *
 * @return bool|\XoopsFormEditor
 */
function gal_getWysiwygForm($caption, $name, $value, $rows, $cols, $width, $height, $supplemental)
{
    $editor_option            = strtolower(gal_getmoduleoption('form_options'));
    $editor                   = false;
    $editor_configs           = [];
    $editor_configs['name']   = $name;
    $editor_configs['value']  = $value;
    $editor_configs['rows']   = $rows;
    $editor_configs['cols']   = $cols;
    $editor_configs['width']  = $width;
    $editor_configs['height'] = $height;
    $editor_configs['editor'] = $editor_option;

    $editor = new \XoopsFormEditor($caption, $name, $editor_configs);

    return $editor;
}
