<?php
/**
 * ExtGallery Class Manager
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
 * @version     $Id: plugin.php 8088 2011-11-06 09:38:12Z beckmi $
 */

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

class ExtgalleryPluginHandler {

    function ExtgalleryPluginHandler(&$db) {

    }

    function triggerEvent($event, &$param) {

        include XOOPS_ROOT_PATH."/modules/extgallery/plugin/plugin.php";

        foreach($extgalleryPlugin as $plugin=>$status) {

            if(!$status) {
                continue;
            }

            include_once XOOPS_ROOT_PATH."/modules/extgallery/plugin/$plugin/$plugin.php";

            $class = 'Extgallery'.ucfirst($plugin);

            $pluginObj = new $class();
            $pluginObj->$event($param);

        }

    }

    function includeLangFile() {

        include XOOPS_ROOT_PATH."/modules/extgallery/plugin/plugin.php";

        foreach($extgalleryPlugin as $plugin=>$status) {

            if(!$status) {
                continue;
            }

            include_once XOOPS_ROOT_PATH."/modules/extgallery/plugin/$plugin/language/english/main.php";

        }

    }

}

?>