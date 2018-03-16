<?php namespace XoopsModules\Extgallery;

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
 * @copyright   {@link https://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */
use XoopsModules\Extgallery;

// defined('XOOPS_ROOT_PATH') || die('Restricted access');

//require XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

/**
 * Class Extgallery\GroupFormCheckBox
 */
class GroupFormCheckBox extends \XoopsGroupFormCheckBox
{
    /**
     * Extgallery\GroupFormCheckBox constructor.
     * @param      $caption
     * @param      $name
     * @param      $groupId
     * @param null $values
     */
    public function __construct($caption, $name, $groupId, $values = null)
    {
        parent::__construct($caption, $name, $groupId, $values);
    }

    /**
     *
     */
    public function render()
    {
        $ele_name = $this->getName();
        echo '<table class="outer"><tr><td class="odd"><table><tr>';
        $cols = 1;
        foreach ($this->_optionTree[0]['children'] as $topitem) {
            if ($cols > 4) {
                echo '</tr><tr>';
                $cols = 1;
            }
            $tree   = '<td valign="top">';
            $prefix = '';
            $this->_renderOptionTree($tree, $this->_optionTree[$topitem], $prefix);
            echo $tree;
            echo '</td>';
            ++$cols;
        }
        echo '</tr></table></td><td class="even" valign="top">';
        $option_ids = [];
        foreach (array_keys($this->_optionTree) as $id) {
            if (!empty($id)) {
                $option_ids[] = '\'' . $ele_name . '[groups][' . $this->_groupId . '][' . $id . ']' . '\'';
            }
        }
        $checkallbtn_id = $ele_name . '[checkallbtn][' . $this->_groupId . ']';
        $option_ids_str = implode(', ', $option_ids);
        echo _ALL . ' <input id="' . $checkallbtn_id . '" type="checkbox" value="" onclick="var optionids = new Array(' . $option_ids_str . "); xoopsCheckAllElements(optionids, '" . $checkallbtn_id . '\');">';
        echo '</td></tr></table>';
    }
}
