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

use XoopsModules\Extgallery;

require_once __DIR__ . '/admin_header.php';
//include __DIR__ . '/../class/grouppermform.php';

if (isset($_POST['step'])) {
    $step = $_POST['step'];
} else {
    $step = 'default';
}

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = 'default';
}

$module_id = $xoopsModule->getVar('mid');

switch ($step) {
    case 'enreg':
        /** @var XoopsGroupPermHandler $gpermHandler */
        $gpermHandler = xoops_getHandler('groupperm');
        if ('public' === $_POST['type']) {
            // Delete old public mask
            $criteria = new \CriteriaCompo();
            $criteria->add(new \Criteria('gperm_name', 'extgallery_public_mask'));
            $criteria->add(new \Criteria('gperm_modid', $module_id));
            $gpermHandler->deleteAll($criteria);

            foreach ($_POST['perms']['extgallery_public_mask']['group'] as $groupId => $perms) {
                foreach (array_keys($perms) as $perm) {
                    $gpermHandler->addRight('extgallery_public_mask', $perm, $groupId, $module_id);
                }
            }
        }

        redirect_header('perm-quota.php', 3, _AM_EXTGALLERY_PERM_MASK_UPDATED);

        break;

    case 'default':
    default:

        $permArray       = include XOOPS_ROOT_PATH . '/modules/extgallery/include/perm.php';
        $modulePermArray = $permArray['modulePerm'];
        $pluginPermArray = $permArray['pluginPerm'];

        xoops_cp_header();
        ob_end_flush();
        /** @var XoopsMemberHandler $memberHandler */
        $memberHandler = xoops_getHandler('member');
        /** @var XoopsGroupPermHandler $gpermHandler */
        $gpermHandler = xoops_getHandler('groupperm');
        /** @var Extgallery\PluginHandler $pluginHandler */
        $pluginHandler = Extgallery\Helper::getInstance()->getHandler('Plugin');

        $pluginHandler->includeLangFile();

        // Retriving the group list
        $glist = $memberHandler->getGroupList();

        /**
         * @param $array
         * @param $v
         *
         * @return string
         */
        function getChecked($array, $v)
        {
            if (in_array($v, $array)) {
                return ' checked';
            } else {
                return '';
            }
        }

        echo '<script type="text/javascript" src="../assets/js/admin.js"></script>';

        $nbPerm = count($modulePermArray);
        $nbPerm += count($pluginPermArray) + 1;

        echo '<fieldset><legend style="font-weight:bold; color:#990000;">' . _AM_EXTGALLERY_SELECT_PERM . '</legend>';
        echo '<p>' . _AM_EXTGALLERY_SELECT_PERM_DESC . '</p><br>';
        echo "<form name='opform' id='opform' action='perm-quota.php' method='GET'>\n
        <select size='1'onchange=\"document.forms.opform.submit()\" name='op' id='op'>\n
        <option value=''></option>\n";

        foreach ($modulePermArray as $perm) {
            if ($op == $perm['name']) {
                echo "<option value='" . $perm['name'] . '\' selected>' . constant($perm['title']) . "</option>\n";
            } else {
                echo "<option value='" . $perm['name'] . '\'>' . constant($perm['title']) . "</option>\n";
            }
        }

        foreach ($pluginPermArray as $perm) {
            if ($op == $perm['name']) {
                echo "<option value='" . $perm['name'] . '\' selected>' . constant($perm['title']) . "</option>\n";
            } else {
                echo "<option value='" . $perm['name'] . '\'>' . constant($perm['title']) . "</option>\n";
            }
        }

        echo "</select>\n
        </form>\n<br>\n";
        echo '</fieldset><br>';

        // Retriving category list for Group perm form
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
        $cats       = $catHandler->getTree();

        foreach ($modulePermArray as $perm) {
            if ($op != $perm['name']) {
                continue;
            }

            $form = new Extgallery\GroupPermForm(constant($perm['title']), $module_id, $perm['name'], constant($perm['desc']), 'admin/perm-quota.php');
            foreach ($cats as $cat) {
                $form->addItem($cat->getVar('cat_id'), $cat->getVar('cat_name'), $cat->getVar('cat_pid'));
            }

            echo '<fieldset id="'
                 . $perm['name']
                 . 'Bookmark"><legend><a href="#'
                 . $perm['name']
                 . 'Bookmark" style="font-weight:bold; color:#990000;" onClick="toggle(\''
                 . $perm['name']
                 . '\'); toggleIcon(\''
                 . $perm['name']
                 . 'Icon\');"><img id="'
                 . $perm['name']
                 . 'Icon" src="../assets/images/minus.gif">&nbsp;'
                 . constant($perm['title'])
                 . '</a></legend><div id="'
                 . $perm['name']
                 . '">';
            echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">' . _AM_EXTGALLERY_INFORMATION . '</legend>';
            echo constant($perm['info']);
            echo '</fieldset>';
            echo $form->render() . '<br>';
            echo '</div></fieldset><br>';

            break;
        }

        foreach ($pluginPermArray as $perm) {
            if ($op != $perm['name']) {
                continue;
            }

            $form = new Extgallery\GroupPermForm(constant($perm['title']), $module_id, $perm['name'], constant($perm['desc']), 'admin/perm-quota.php');
            foreach ($cats as $cat) {
                $form->addItem($cat->getVar('cat_id'), $cat->getVar('cat_name'), $cat->getVar('cat_pid'));
            }

            echo '<fieldset id="'
                 . $perm['name']
                 . 'Bookmark"><legend><a href="#'
                 . $perm['name']
                 . 'Bookmark" style="font-weight:bold; color:#990000;" onClick="toggle(\''
                 . $perm['name']
                 . '\'); toggleIcon(\''
                 . $perm['name']
                 . 'Icon\');"><img id="'
                 . $perm['name']
                 . 'Icon" src="../assets/images/minus.gif">&nbsp;'
                 . constant($perm['title'])
                 . '</a></legend><div id="'
                 . $perm['name']
                 . '">';
            echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">' . _AM_EXTGALLERY_INFORMATION . '</legend>';
            echo constant($perm['info']);
            echo '</fieldset>';
            echo $form->render() . '<br>';
            echo '</div></fieldset><br>';

            break;
        }

        /**
         * Public category permission mask
         */
        echo '<fieldset id="defaultBookmark"><legend><a href="#defaultBookmark" style="font-weight:bold; color:#990000;" onClick="toggle(\'default\'); toggleIcon(\'defaultIcon\');"><img id="defaultIcon" src="../assets/images/minus.gif">&nbsp;'
             . _AM_EXTGALLERY_PUBLIC_PERM_MASK
             . '</a></legend><div id="default">';
        echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">' . _AM_EXTGALLERY_INFORMATION . '</legend>';
        echo _AM_EXTGALLERY_PUBLIC_PERM_MASK_INFO;
        echo '</fieldset><br>';
        echo '<table class="outer" style="width:100%;">';
        echo '<form method="post" action="perm-quota.php">';
        echo '<tr>';
        echo '<th colspan="' . $nbPerm . '" style="text-align:center;">' . _AM_EXTGALLERY_PUBLIC_PERM_MASK . '</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<td class="head">' . _AM_EXTGALLERY_GROUP_NAME . '</td>';

        foreach ($modulePermArray as $perm) {
            echo '<td class="head" style="text-align:center;">' . constant($perm['maskTitle']) . '</td>';
        }

        foreach ($pluginPermArray as $perm) {
            echo '<td class="head" style="text-align:center;">' . constant($perm['maskTitle']) . '</td>';
        }

        echo '</tr>';
        $i = 0;
        foreach ($glist as $k => $v) {
            $style = (0 == ++$i % 2) ? 'odd' : 'even';
            echo '<tr>';
            echo '<td class="' . $style . '">' . $v . '</td>';

            foreach ($modulePermArray as $perm) {
                $permAccessGroup = $gpermHandler->getGroupIds('extgallery_public_mask', $perm['maskId'], $module_id);
                echo '<td class="' . $style . '" style="text-align:center;"><input name="perms[extgallery_public_mask][group][' . $k . '][' . $perm['maskId'] . ']" type="checkbox"' . getChecked($permAccessGroup, $k) . '></td>';
            }

            foreach ($pluginPermArray as $perm) {
                $permAccessGroup = $gpermHandler->getGroupIds('extgallery_public_mask', $perm['maskId'], $module_id);
                echo '<td class="' . $style . '" style="text-align:center;"><input name="perms[extgallery_public_mask][group][' . $k . '][' . $perm['maskId'] . ']" type="checkbox"' . getChecked($permAccessGroup, $k) . '></td>';
            }

            echo '</tr>';
        }
        echo '<input type="hidden" name="type" value="public">';
        echo '<input type="hidden" name="step" value="enreg">';
        echo '<tr><td colspan="' . $nbPerm . '" style="text-align:center;" class="head"><input type="submit" value="' . _SUBMIT . '"></td></tr></form>';
        echo '</table><br>';

        echo '</div></fieldset><br>';

        xoops_cp_footer();

        break;

}
