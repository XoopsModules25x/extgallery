<?php namespace XoopsModules\Extgallery;

use Xmf\Request;
use  XoopsModules\Extgallery\Common;


//require_once __DIR__ . '/../include/common.php';
/**
 * Class ExtgalleryUtility
 */
class Utility extends \XoopsObject
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait


    /**
     * @param $option
     * @return bool|mixed
     */
    public static function getModuleOption($option)
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
                $configurator = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
                if (isset($configurator[$option])) {
                    $retval = $configurator[$option];
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
    public static function getWysiwygForm($caption, $name, $value, $rows, $cols, $width, $height, $supplemental)
    {
        $editor_option            = strtolower(static::getModuleOption('form_options'));
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
}
