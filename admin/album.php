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

//$GLOBALS['xoopsOption']['template_main'] = 'extgallery_admin_album.tpl';

if (isset($_POST['op'])) {
    $op = $_POST['op'];
} else {
    $op = 'default';
}

switch ($op) {

    case 'overlay':
        /** @var XoopsModuleHandler $moduleHandler */
        $configHandler    = xoops_getHandler('config');
        $moduleIdCriteria = new \Criteria('conf_modid', $xoopsModule->getVar('mid'));

        if (isset($_POST['album_overlay_bg'])) {
            if ($xoopsModuleConfig['album_overlay_bg'] != $_POST['album_overlay_bg']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_overlay_bg'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_overlay_bg',
                    'conf_value'     => $_POST['album_overlay_bg'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_overlay_width'])) {
            if ($xoopsModuleConfig['album_overlay_width'] != $_POST['album_overlay_width']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_overlay_width'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_overlay_width',
                    'conf_value'     => $_POST['album_overlay_width'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_overlay_height'])) {
            if ($xoopsModuleConfig['album_overlay_height'] != $_POST['album_overlay_height']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_overlay_height'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_overlay_height',
                    'conf_value'     => $_POST['album_overlay_height'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        redirect_header('album.php', 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);
        break;

    case 'tooltip':
        /** @var XoopsModuleHandler $moduleHandler */
        $configHandler    = xoops_getHandler('config');
        $moduleIdCriteria = new \Criteria('conf_modid', $xoopsModule->getVar('mid'));

        if (isset($_POST['album_tooltip_width'])) {
            if ($xoopsModuleConfig['album_tooltip_width'] != $_POST['album_tooltip_width']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_tooltip_width'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_tooltip_width',
                    'conf_value'     => $_POST['album_tooltip_width'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                if (isset($_POST['album_tooltip_width'])) {
                    if ($xoopsModuleConfig['album_tooltip_width'] != $_POST['album_tooltip_width']) {
                        $criteria = new \CriteriaCompo();
                        $criteria->add($moduleIdCriteria);
                        $criteria->add(new \Criteria('conf_name', 'album_tooltip_width'));
                        /** @var \XoopsObject $config */
                        $config      = $configHandler->getConfigs($criteria);
                        $config      = $config[0];
                        $configValue = [
                            'conf_modid'     => $xoopsModule->getVar('mid'),
                            'conf_catid'     => 0,
                            'conf_name'      => 'album_tooltip_width',
                            'conf_value'     => $_POST['album_tooltip_width'],
                            'conf_formtype'  => 'hidden',
                            'conf_valuetype' => 'text'
                        ];
                        $config->setVars($configValue);
                        $configHandler->insertConfig($config);
                    }
                }
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_tooltip_borderwidth'])) {
            if ($xoopsModuleConfig['album_tooltip_borderwidth'] != $_POST['album_tooltip_borderwidth']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_tooltip_borderwidth'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_tooltip_borderwidth',
                    'conf_value'     => $_POST['album_tooltip_borderwidth'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_tooltip_bordercolor'])) {
            if ($xoopsModuleConfig['album_tooltip_bordercolor'] != $_POST['album_tooltip_bordercolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_tooltip_bordercolor'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_tooltip_bordercolor',
                    'conf_value'     => $_POST['album_tooltip_bordercolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        redirect_header('album.php', 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);
        break;

    case 'fancybox':
        /** @var XoopsModuleHandler $moduleHandler */
        $configHandler    = xoops_getHandler('config');
        $moduleIdCriteria = new \Criteria('conf_modid', $xoopsModule->getVar('mid'));

        if (isset($_POST['album_fancybox_color'])) {
            if ($xoopsModuleConfig['album_fancybox_color'] != $_POST['album_fancybox_color']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_fancybox_color'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_fancybox_color',
                    'conf_value'     => $_POST['album_fancybox_color'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_fancybox_opacity'])) {
            if ($xoopsModuleConfig['album_fancybox_opacity'] != $_POST['album_fancybox_opacity']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_fancybox_opacity'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_fancybox_opacity',
                    'conf_value'     => $_POST['album_fancybox_opacity'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_fancybox_tin'])) {
            if ($xoopsModuleConfig['album_fancybox_tin'] != $_POST['album_fancybox_tin']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_fancybox_tin'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_fancybox_tin',
                    'conf_value'     => $_POST['album_fancybox_tin'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_fancybox_tout'])) {
            if ($xoopsModuleConfig['album_fancybox_tout'] != $_POST['album_fancybox_tout']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_fancybox_tout'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_fancybox_tout',
                    'conf_value'     => $_POST['album_fancybox_tout'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_fancybox_title'])) {
            if ($xoopsModuleConfig['album_fancybox_title'] != $_POST['album_fancybox_title']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_fancybox_title'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_fancybox_title',
                    'conf_value'     => $_POST['album_fancybox_title'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_fancybox_showtype'])) {
            if ($xoopsModuleConfig['album_fancybox_showtype'] != $_POST['album_fancybox_showtype']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_fancybox_showtype'));
                /** @var \XoopsObject $config */
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_fancybox_showtype',
                    'conf_value'     => $_POST['album_fancybox_showtype'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        redirect_header('album.php', 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);
        break;

    case 'prettyphoto':
        /** @var XoopsModuleHandler $moduleHandler */
        $configHandler    = xoops_getHandler('config');
        $moduleIdCriteria = new \Criteria('conf_modid', $xoopsModule->getVar('mid'));

        if (isset($_POST['album_prettyphoto_theme'])) {
            if ($xoopsModuleConfig['album_prettyphoto_theme'] != $_POST['album_prettyphoto_theme']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_prettyphoto_theme'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_prettyphoto_theme',
                    'conf_value'     => $_POST['album_prettyphoto_theme'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_prettyphoto_speed'])) {
            if ($xoopsModuleConfig['album_prettyphoto_speed'] != $_POST['album_prettyphoto_speed']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_prettyphoto_speed'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_prettyphoto_speed',
                    'conf_value'     => $_POST['album_prettyphoto_speed'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_prettyphoto_slidspe'])) {
            if ($xoopsModuleConfig['album_prettyphoto_slidspe'] != $_POST['album_prettyphoto_slidspe']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_prettyphoto_slidspe'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_prettyphoto_slidspe',
                    'conf_value'     => $_POST['album_prettyphoto_slidspe'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (isset($_POST['album_prettyphoto_autopla'])) {
            if ($xoopsModuleConfig['album_prettyphoto_autopla'] != $_POST['album_prettyphoto_autopla']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'album_prettyphoto_autopla'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'album_prettyphoto_autopla',
                    'conf_value'     => $_POST['album_prettyphoto_autopla'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text'
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        redirect_header('album.php', 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);
        break;

    case 'default':
    default:
        xoops_cp_header();

        $xoopsTpl->assign('displayalbum', 'album' === $xoopsModuleConfig['display_type']);

        $form = new \XoopsThemeForm(_AM_EXTGALLERY_OVERLAY_CONF, 'overlay_conf', 'album.php', 'post', true);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_OVERLAY_BG, 'album_overlay_bg', $xoopsModuleConfig['album_overlay_bg']), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_OVERLAY_WIDTH, 'album_overlay_width', '5', '5', $xoopsModuleConfig['album_overlay_width']), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_OVERLAY_HEIGHT, 'album_overlay_height', '5', '5', $xoopsModuleConfig['album_overlay_height']), false);
        $form->addElement(new \XoopsFormHidden('op', 'overlay'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('overlayform', $form->render());

        $form = new \XoopsThemeForm(_AM_EXTGALLERY_TOOLTIP_CONF, 'tooltip_conf', 'album.php', 'post', true);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_TOOLTIP_WIDTH, 'album_tooltip_width', '6', '6', $xoopsModuleConfig['album_tooltip_width']), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_TOOLTIP_BORDER_WIDTH, 'album_tooltip_borderwidth', '6', '6', $xoopsModuleConfig['album_tooltip_borderwidth']), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_TOOLTIP_BORDERCOLOR, 'album_tooltip_bordercolor', $xoopsModuleConfig['album_tooltip_bordercolor']), false);
        $form->addElement(new \XoopsFormHidden('op', 'tooltip'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('tooltipform', $form->render());

        $form = new \XoopsThemeForm(_AM_EXTGALLERY_FANCYBOX_CONF, 'fancybox_conf', 'album.php', 'post', true);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_FANCYBOX_BGCOLOR, 'album_fancybox_color', $xoopsModuleConfig['album_fancybox_color']), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_FANCYBOX_OPACITY, 'album_fancybox_opacity', '6', '6', $xoopsModuleConfig['album_fancybox_opacity']), false);
        $fancyboxtinSelect = new \XoopsFormSelect(_AM_EXTGALLERY_FANCYBOX_TIN, 'album_fancybox_tin', $xoopsModuleConfig['album_fancybox_tin']);
        $fancyboxtinSelect->addOption('none', _AM_EXTGALLERY_FANCYBOX_NONE);
        $fancyboxtinSelect->addOption('elastic', _AM_EXTGALLERY_FANCYBOX_ELASTIC);
        $form->addElement($fancyboxtinSelect);
        $fancyboxtoutSelect = new \XoopsFormSelect(_AM_EXTGALLERY_FANCYBOX_TOUT, 'album_fancybox_tout', $xoopsModuleConfig['album_fancybox_tout']);
        $fancyboxtoutSelect->addOption('none', _AM_EXTGALLERY_FANCYBOX_NONE);
        $fancyboxtoutSelect->addOption('elastic', _AM_EXTGALLERY_FANCYBOX_ELASTIC);
        $form->addElement($fancyboxtoutSelect);
        $fancyboxtpSelect = new \XoopsFormSelect(_AM_EXTGALLERY_FANCYBOX_TITLEPOSITION, 'album_fancybox_title', $xoopsModuleConfig['album_fancybox_title']);
        $fancyboxtpSelect->addOption('over', _AM_EXTGALLERY_FANCYBOX_OVER);
        $fancyboxtpSelect->addOption('inside', _AM_EXTGALLERY_FANCYBOX_INSIDE);
        $fancyboxtpSelect->addOption('outside', _AM_EXTGALLERY_FANCYBOX_OUTSIDE);
        $form->addElement($fancyboxtpSelect);
        $fancyboxshowSelect = new \XoopsFormSelect(_AM_EXTGALLERY_FANCYBOX_SHOWTYPE, 'album_fancybox_showtype', $xoopsModuleConfig['album_fancybox_showtype']);
        $fancyboxshowSelect->addOption('single', _AM_EXTGALLERY_FANCYBOX_SINGLE);
        $fancyboxshowSelect->addOption('group', _AM_EXTGALLERY_FANCYBOX_GROUP);
        $form->addElement($fancyboxshowSelect);
        $form->addElement(new \XoopsFormHidden('op', 'fancybox'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('fancyboxform', $form->render());

        $form              = new \XoopsThemeForm(_AM_EXTGALLERY_PRETTPHOTO_CONF, 'prettyphoto_conf', 'album.php', 'post', true);
        $prettyspeedSelect = new \XoopsFormSelect(_AM_EXTGALLERY_PRETTPHOTO_SPEED, 'album_prettyphoto_speed', $xoopsModuleConfig['album_prettyphoto_speed']);
        $prettyspeedSelect->addOption('fast', _AM_EXTGALLERY_PRETTPHOTO_FAST);
        $prettyspeedSelect->addOption('slow', _AM_EXTGALLERY_PRETTPHOTO_SLOW);
        $form->addElement($prettyspeedSelect);
        $prettythemeSelect = new \XoopsFormSelect(_AM_EXTGALLERY_PRETTPHOTO_THEME, 'album_prettyphoto_theme', $xoopsModuleConfig['album_prettyphoto_theme']);
        $prettythemeSelect->addOption('dark_rounded', _AM_EXTGALLERY_PRETTPHOTO_THEME1);
        $prettythemeSelect->addOption('dark_square', _AM_EXTGALLERY_PRETTPHOTO_THEME2);
        $prettythemeSelect->addOption('facebook', _AM_EXTGALLERY_PRETTPHOTO_THEME3);
        $prettythemeSelect->addOption('light_rounded', _AM_EXTGALLERY_PRETTPHOTO_THEME4);
        $prettythemeSelect->addOption('light_square', _AM_EXTGALLERY_PRETTPHOTO_THEME5);
        $form->addElement($prettythemeSelect);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_PRETTPHOTO_SLIDESPEED, 'album_prettyphoto_slidspe', '5', '5', $xoopsModuleConfig['album_prettyphoto_slidspe']), false);
        $prettyautoplaySelect = new \XoopsFormSelect(_AM_EXTGALLERY_PRETTPHOTO_AUTOPLAY, 'album_prettyphoto_autopla', $xoopsModuleConfig['album_prettyphoto_autopla']);
        $prettyautoplaySelect->addOption('true', _AM_EXTGALLERY_PRETTPHOTO_AUTOPLAY_T);
        $prettyautoplaySelect->addOption('false', _AM_EXTGALLERY_PRETTPHOTO_AUTOPLAY_F);
        $form->addElement($prettyautoplaySelect);
        $form->addElement(new \XoopsFormHidden('op', 'prettyphoto'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('prettyphotoform', $form->render());

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/extgallery/templates/admin/extgallery_admin_album.tpl');
        xoops_cp_footer();

        break;

}
