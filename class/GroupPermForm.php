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

require XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

/**
 * Class Extgallery\GroupPermForm
 */
class GroupPermForm extends \XoopsGroupPermForm
{
    /**
     * Extgallery\GroupPermForm constructor.
     * @param string $title
     * @param string $modid
     * @param string $permname
     * @param string $permdesc
     * @param string $url
     * @param bool   $anonymous
     */
    public function __construct($title, $modid, $permname, $permdesc, $url = '', $anonymous = true)
    {
        parent::__construct($title, $modid, $permname, $permdesc, $url, $anonymous);
    }

    /**
     *
     */
    public function render()
    {
        // load all child ids for javascript codes
        foreach (array_keys($this->_itemTree) as $item_id) {
            $this->_itemTree[$item_id]['allchild'] = [];
            $this->_loadAllChildItemIds($item_id, $this->_itemTree[$item_id]['allchild']);
        }
        /** @var \XoopsGroupPermHandler $gpermHandler */
        $gpermHandler = xoops_getHandler('groupperm');
        /** @var \XoopsMemberHandler $memberHandler */
        $memberHandler = xoops_getHandler('member');
        $glist         = $memberHandler->getGroupList();
        foreach (array_keys($glist) as $i) {
            if (XOOPS_GROUP_ANONYMOUS == $i && !$this->_showAnonymous) {
                continue;
            }
            // get selected item id(s) for each group
            $selected = $gpermHandler->getItemIds($this->_permName, $i, $this->_modid);
            $ele      = new Extgallery\GroupFormCheckBox($glist[$i], 'perms[' . $this->_permName . ']', $i, $selected);
            $ele->setOptionTree($this->_itemTree);
            $this->addElement($ele);
            unset($ele);
        }
        $tray = new \XoopsFormElementTray('');
        $tray->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $tray->addElement(new \XoopsFormButton('', 'reset', _CANCEL, 'reset'));
        $this->addElement($tray);
        echo '<h4>' . $this->getTitle() . '</h4>';
        if ($this->_permDesc) {
            echo $this->_permDesc . '<br><br>';
        }
        echo "<form name='" . $this->getName() . '\' id=\'' . $this->getName() . '\' action=\'' . $this->getAction() . '\' method=\'' . $this->getMethod() . '\'' . $this->getExtra() . ">\n<table width='100%' class='outer' cellspacing='1' valign='top'>\n";
        $elements =& $this->getElements();
        $hidden   = '';
        foreach (array_keys($elements) as $i) {
            if (!is_object($elements[$i])) {
                echo $elements[$i];
            } elseif (!$elements[$i]->isHidden()) {
                echo "<tr valign='top' align='left'><td class='head'>" . $elements[$i]->getCaption();
                if ('' != $elements[$i]->getDescription()) {
                    echo '<br><br><span style="font-weight: normal;">' . $elements[$i]->getDescription() . '</span>';
                }
                echo "</td>\n<td class='even'>\n";
                if (is_a($elements[$i], 'Extgallery\GroupFormCheckBox')) {
                    $elements[$i]->render();
                } else {
                    echo $elements[$i]->render();
                }
                echo "\n</td></tr>\n";
            } else {
                $hidden .= $elements[$i]->render();
            }
        }
        echo "</table>$hidden</form>";
        echo $this->renderValidationJS(true);
    }
}
