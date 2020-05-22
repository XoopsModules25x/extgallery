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

/** @var Extgallery\Helper $helper */
$helper = Extgallery\Helper::getInstance();

if (\Xmf\Request::hasVar('op', 'POST')) {
    $op = $_POST['op'];
} else {
    $op = 'default';
}

switch ($op) {
    case 'galleryview':

        /** @var \XoopsModuleHandler $moduleHandler */
        /** @var \XoopsConfigHandler $configHandler */
        $configHandler    = xoops_getHandler('config');
        $moduleIdCriteria = new \Criteria('conf_modid', $xoopsModule->getVar('mid'));

        if (\Xmf\Request::hasVar('galleryview_panelwidth', 'POST')) {
            if ($helper->getConfig('galleryview_panelwidth') != $_POST['galleryview_panelwidth']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_panelwidth'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_panelwidth',
                    'conf_value'     => $_POST['galleryview_panelwidth'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_panelheight', 'POST')) {
            if ($helper->getConfig('galleryview_panelheight') != $_POST['galleryview_panelheight']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_panelheight'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_panelheight',
                    'conf_value'     => $_POST['galleryview_panelheight'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_framewidth', 'POST')) {
            if ($helper->getConfig('galleryview_framewidth') != $_POST['galleryview_framewidth']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_framewidth'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_framewidth',
                    'conf_value'     => $_POST['galleryview_framewidth'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_frameheight', 'POST')) {
            if ($helper->getConfig('galleryview_frameheight') != $_POST['galleryview_frameheight']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_frameheight'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_frameheight',
                    'conf_value'     => $_POST['galleryview_frameheight'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_tspeed', 'POST')) {
            if ($helper->getConfig('galleryview_tspeed') != $_POST['galleryview_tspeed']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_tspeed'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_tspeed',
                    'conf_value'     => $_POST['galleryview_tspeed'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_tterval', 'POST')) {
            if ($helper->getConfig('galleryview_tterval') != $_POST['galleryview_tterval']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_tterval'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_tterval',
                    'conf_value'     => $_POST['galleryview_tterval'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_overlayheight', 'POST')) {
            if ($helper->getConfig('galleryview_overlayheight') != $_POST['galleryview_overlayheight']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_overlayheight'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_overlayheight',
                    'conf_value'     => $_POST['galleryview_overlayheight'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_opacity', 'POST')) {
            if ($helper->getConfig('galleryview_opacity') != $_POST['galleryview_opacity']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_opacity'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_opacity',
                    'conf_value'     => $_POST['galleryview_opacity'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_overlayfs', 'POST')) {
            if ($helper->getConfig('galleryview_overlayfs') != $_POST['galleryview_overlayfs']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_overlayfs'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_overlayfs',
                    'conf_value'     => $_POST['galleryview_overlayfs'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_borderwidth', 'POST')) {
            if ($helper->getConfig('galleryview_borderwidth') != $_POST['galleryview_borderwidth']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_borderwidth'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_borderwidth',
                    'conf_value'     => $_POST['galleryview_borderwidth'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_bordercolor', 'POST')) {
            if ($helper->getConfig('galleryview_bordercolor') != $_POST['galleryview_bordercolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_bordercolor'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_bordercolor',
                    'conf_value'     => $_POST['galleryview_bordercolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_bgcolor', 'POST')) {
            if ($helper->getConfig('galleryview_bgcolor') != $_POST['galleryview_bgcolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_bgcolor'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_bgcolor',
                    'conf_value'     => $_POST['galleryview_bgcolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_overlaycolor', 'POST')) {
            if ($helper->getConfig('galleryview_overlaycolor') != $_POST['galleryview_overlaycolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_overlaycolor'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_overlaycolor',
                    'conf_value'     => $_POST['galleryview_overlaycolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_overlaytc', 'POST')) {
            if ($helper->getConfig('galleryview_overlaytc') != $_POST['galleryview_overlaytc']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_overlaytc'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_overlaytc',
                    'conf_value'     => $_POST['galleryview_overlaytc'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_captiontc', 'POST')) {
            if ($helper->getConfig('galleryview_captiontc') != $_POST['galleryview_captiontc']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_captiontc'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_captiontc',
                    'conf_value'     => $_POST['galleryview_captiontc'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_navtheme', 'POST')) {
            if ($helper->getConfig('galleryview_navtheme') != $_POST['galleryview_navtheme']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_navtheme'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_navtheme',
                    'conf_value'     => $_POST['galleryview_navtheme'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_position', 'POST')) {
            if ($helper->getConfig('galleryview_position') != $_POST['galleryview_position']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_position'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_position',
                    'conf_value'     => $_POST['galleryview_position'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleryview_easing', 'POST')) {
            if ($helper->getConfig('galleryview_easing') != $_POST['galleryview_easing']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleryview_easing'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleryview_easing',
                    'conf_value'     => $_POST['galleryview_easing'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        redirect_header('slideshow.php', 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);

        break;
    case 'galleria':

        /** @var \XoopsModuleHandler $moduleHandler */
        /** @var \XoopsConfigHandler $configHandler */
        $configHandler    = xoops_getHandler('config');
        $moduleIdCriteria = new \Criteria('conf_modid', $xoopsModule->getVar('mid'));
        if (\Xmf\Request::hasVar('galleria_height', 'POST')) {
            if ($helper->getConfig('galleria_height') != $_POST['galleria_height']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleria_height'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleria_height',
                    'conf_value'     => $_POST['galleria_height'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleria_panelwidth', 'POST')) {
            if ($helper->getConfig('galleria_panelwidth') != $_POST['galleria_panelwidth']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleria_panelwidth'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleria_panelwidth',
                    'conf_value'     => $_POST['galleria_panelwidth'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleria_bgcolor', 'POST')) {
            if ($helper->getConfig('galleria_bgcolor') != $_POST['galleria_bgcolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleria_bgcolor'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleria_bgcolor',
                    'conf_value'     => $_POST['galleria_bgcolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleria_bcolor', 'POST')) {
            if ($helper->getConfig('galleria_bcolor') != $_POST['galleria_bcolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleria_bcolor'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleria_bcolor',
                    'conf_value'     => $_POST['galleria_bcolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleria_bgimg', 'POST')) {
            if ($helper->getConfig('galleria_bgimg') != $_POST['galleria_bgimg']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleria_bgimg'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleria_bgimg',
                    'conf_value'     => $_POST['galleria_bgimg'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleria_autoplay', 'POST')) {
            if ($helper->getConfig('galleria_autoplay') != $_POST['galleria_autoplay']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleria_autoplay'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleria_autoplay',
                    'conf_value'     => $_POST['galleria_autoplay'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleria_transition', 'POST')) {
            if ($helper->getConfig('galleria_transition') != $_POST['galleria_transition']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleria_transition'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleria_transition',
                    'conf_value'     => $_POST['galleria_transition'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleria_tspeed', 'POST')) {
            if ($helper->getConfig('galleria_tspeed') != $_POST['galleria_tspeed']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleria_tspeed'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleria_tspeed',
                    'conf_value'     => $_POST['galleria_tspeed'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }
        redirect_header('slideshow.php', 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);

        break;
    case 'galleriffic':

        /** @var \XoopsModuleHandler $moduleHandler */
        $configHandler    = xoops_getHandler('config');
        $moduleIdCriteria = new \Criteria('conf_modid', $xoopsModule->getVar('mid'));

        if (\Xmf\Request::hasVar('galleriffic_height', 'POST')) {
            if ($helper->getConfig('galleriffic_height') != $_POST['galleriffic_height']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_height'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_height',
                    'conf_value'     => $_POST['galleriffic_height'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_width', 'POST')) {
            if ($helper->getConfig('galleriffic_width') != $_POST['galleriffic_width']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_width'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_width',
                    'conf_value'     => $_POST['galleriffic_width'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_bgcolor', 'POST')) {
            if ($helper->getConfig('galleriffic_bgcolor') != $_POST['galleriffic_bgcolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_bgcolor'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_bgcolor',
                    'conf_value'     => $_POST['galleriffic_bgcolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_bordercolor', 'POST')) {
            if ($helper->getConfig('galleriffic_bordercolor') != $_POST['galleriffic_bordercolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_bordercolor'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_bordercolor',
                    'conf_value'     => $_POST['galleriffic_bordercolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_fontcolor', 'POST')) {
            if ($helper->getConfig('galleriffic_fontcolor') != $_POST['galleriffic_fontcolor']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_fontcolor'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_fontcolor',
                    'conf_value'     => $_POST['galleriffic_fontcolor'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_autoplay', 'POST')) {
            if ($helper->getConfig('galleriffic_autoplay') != $_POST['galleriffic_autoplay']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_autoplay'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_autoplay',
                    'conf_value'     => $_POST['galleriffic_autoplay'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_nb_thumbs', 'POST')) {
            if ($helper->getConfig('galleriffic_nb_thumbs') != $_POST['galleriffic_nb_thumbs']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_nb_thumbs'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_nb_thumbs',
                    'conf_value'     => $_POST['galleriffic_nb_thumbs'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_nb_colthumbs', 'POST')) {
            if ($helper->getConfig('galleriffic_nb_colthumbs') != $_POST['galleriffic_nb_colthumbs']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_nb_colthumbs'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_nb_colthumbs',
                    'conf_value'     => $_POST['galleriffic_nb_colthumbs'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_nb_preload', 'POST')) {
            if ($helper->getConfig('galleriffic_nb_preload') != $_POST['galleriffic_nb_preload']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_nb_preload'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_nb_preload',
                    'conf_value'     => $_POST['galleriffic_nb_preload'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_tdelay', 'POST')) {
            if ($helper->getConfig('galleriffic_tdelay') != $_POST['galleriffic_tdelay']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_tdelay'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_tdelay',
                    'conf_value'     => $_POST['galleriffic_tdelay'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_tspeed', 'POST')) {
            if ($helper->getConfig('galleriffic_tspeed') != $_POST['galleriffic_tspeed']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_tspeed'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_tspeed',
                    'conf_value'     => $_POST['galleriffic_tspeed'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_show_descr', 'POST')) {
            if ($helper->getConfig('galleriffic_show_descr') != $_POST['galleriffic_show_descr']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_show_descr'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_show_descr',
                    'conf_value'     => $_POST['galleriffic_show_descr'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }

        if (\Xmf\Request::hasVar('galleriffic_download', 'POST')) {
            if ($helper->getConfig('galleriffic_download') != $_POST['galleriffic_download']) {
                $criteria = new \CriteriaCompo();
                $criteria->add($moduleIdCriteria);
                $criteria->add(new \Criteria('conf_name', 'galleriffic_download'));
                $config      = $configHandler->getConfigs($criteria);
                $config      = $config[0];
                $configValue = [
                    'conf_modid'     => $xoopsModule->getVar('mid'),
                    'conf_catid'     => 0,
                    'conf_name'      => 'galleriffic_download',
                    'conf_value'     => $_POST['galleriffic_download'],
                    'conf_formtype'  => 'hidden',
                    'conf_valuetype' => 'text',
                ];
                $config->setVars($configValue);
                $configHandler->insertConfig($config);
            }
        }
        redirect_header('slideshow.php', 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);

        break;
    case 'default':

    default:

        xoops_cp_header();

        //echo "<pre>";print_r($xoopsModuleConfig);echo "</pre>";
        $xoopsTpl->assign('displayslideshow', 'slideshow' === $helper->getConfig('display_type'));

        $form = new \XoopsThemeForm(_AM_EXTGALLERY_GVIEW_CONF, 'galleryview_conf', 'slideshow.php', 'post', true);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_PANELWIDE, 'galleryview_panelwidth', '5', '5', $helper->getConfig('galleryview_panelwidth')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_PANELHEIGHT, 'galleryview_panelheight', '5', '5', $helper->getConfig('galleryview_panelheight')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_FRAMEWIDTH, 'galleryview_framewidth', '5', '5', $helper->getConfig('galleryview_framewidth')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_FRAMEHEIGHT, 'galleryview_frameheight', '5', '5', $helper->getConfig('galleryview_frameheight')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_TSPEED, 'galleryview_tspeed', '5', '5', $helper->getConfig('galleryview_tspeed')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_TTERVAL, 'galleryview_tterval', '5', '5', $helper->getConfig('galleryview_tterval')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_OPACITY, 'galleryview_opacity', '5', '5', $helper->getConfig('galleryview_opacity')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_OVERLYAHEIGHT, 'galleryview_overlayheight', '5', '5', $helper->getConfig('galleryview_overlayheight')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_OVERLAYFS, 'galleryview_overlayfs', '5', '5', $helper->getConfig('galleryview_overlayfs')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GVIEW_BORDERWIDTH, 'galleryview_borderwidth', '5', '5', $helper->getConfig('galleryview_borderwidth')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GVIEW_BORDERCOLOR, 'galleryview_bordercolor', $helper->getConfig('galleryview_bordercolor')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GVIEW_BGCOLOR, 'galleryview_bgcolor', $helper->getConfig('galleryview_bgcolor')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GVIEW_OVERLAYCOLOR, 'galleryview_overlaycolor', $helper->getConfig('galleryview_overlaycolor')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GVIEW_OVERLAYTC, 'galleryview_overlaytc', $helper->getConfig('galleryview_overlaytc')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GVIEW_CAPTIONTC, 'galleryview_captiontc', $helper->getConfig('galleryview_captiontc')), false);
        $navthemeSelect = new \XoopsFormSelect(_AM_EXTGALLERY_GVIEW_NAVTHEME, 'galleryview_navtheme', $helper->getConfig('galleryview_navtheme'));
        $navthemeSelect->addOption('light', _AM_EXTGALLERY_GVIEW_LIGHT);
        $navthemeSelect->addOption('dark', _AM_EXTGALLERY_GVIEW_DARK);
        $navthemeSelect->addOption('custom', _AM_EXTGALLERY_GVIEW_CUSTOM);
        $form->addElement($navthemeSelect);
        $positionSelect = new \XoopsFormSelect(_AM_EXTGALLERY_GVIEW_POSITION, 'galleryview_position', $helper->getConfig('galleryview_position'));
        $positionSelect->addOption('bottom', _AM_EXTGALLERY_GVIEW_BOTTOM);
        $positionSelect->addOption('top', _AM_EXTGALLERY_GVIEW_TOP);
        $form->addElement($positionSelect);
        $easingSelect = new \XoopsFormSelect(_AM_EXTGALLERY_GVIEW_EASING, 'galleryview_easing', $helper->getConfig('galleryview_easing'));
        $easingSelect->addOption('swing', _AM_EXTGALLERY_GVIEW_EASING_OP1);
        $easingSelect->addOption('linear', _AM_EXTGALLERY_GVIEW_EASING_OP2);
        $easingSelect->addOption('easeInOutBack', _AM_EXTGALLERY_GVIEW_EASING_OP3);
        $easingSelect->addOption('easeInOutQuad', _AM_EXTGALLERY_GVIEW_EASING_OP4);
        $easingSelect->addOption('easeOutBounce', _AM_EXTGALLERY_GVIEW_EASING_OP5);
        $form->addElement($easingSelect);
        $form->addElement(new \XoopsFormHidden('op', 'galleryview'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('galleryviewform', $form->render());

        $form = new \XoopsThemeForm(_AM_EXTGALLERY_GRIA_CONF, 'galleria_conf', 'slideshow.php', 'post', true);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GRIA_HEIGHT, 'galleria_height', '5', '5', $helper->getConfig('galleria_height')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GRIA_PANELWIDTH, 'galleria_panelwidth', '5', '5', $helper->getConfig('galleria_panelwidth')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GRIA_BGCOLOR, 'galleria_bgcolor', $helper->getConfig('galleria_bgcolor')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GRIA_BCOLOR, 'galleria_bcolor', $helper->getConfig('galleria_bcolor')), false);
        $bgimgSelect = new \XoopsFormSelect(_AM_EXTGALLERY_GRIA_BGIMG, 'galleria_bgimg', $helper->getConfig('galleria_bgimg'));
        $bgimgSelect->addOption('classic-map', _AM_EXTGALLERY_GRIA_BGIMG_OP1);
        $bgimgSelect->addOption('classic-map-b', _AM_EXTGALLERY_GRIA_BGIMG_OP2);
        $form->addElement($bgimgSelect);
        $form->addElement(new \XoopsFormRadioYN(_AM_EXTGALLERY_GRIA_AUTOPLAY, 'galleria_autoplay', $helper->getConfig('galleria_autoplay')));
        $select_trans = new \XoopsFormSelect(_AM_EXTGALLERY_GRIA_TRANS, 'galleria_transition', $helper->getConfig('galleria_transition'));
        $select_trans->addOption('fade', _AM_EXTGALLERY_GRIA_TRANS_TYP1);
        $select_trans->addOption('flash', _AM_EXTGALLERY_GRIA_TRANS_TYP2);
        $select_trans->addOption('pulse', _AM_EXTGALLERY_GRIA_TRANS_TYP3);
        $select_trans->addOption('slide', _AM_EXTGALLERY_GRIA_TRANS_TYP4);
        $select_trans->addOption('fadeslide', _AM_EXTGALLERY_GRIA_TRANS_TYP5);
        $form->addElement($select_trans);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GRIA_TSPEED, 'galleria_tspeed', '5', '5', $helper->getConfig('galleria_tspeed')), false);
        $form->addElement(new \XoopsFormHidden('op', 'galleria'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('galleriaform', $form->render());

        $form = new \XoopsThemeForm(_AM_EXTGALLERY_GFIC_CONF, 'galleriffic_conf', 'slideshow.php', 'post', true);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GFIC_HEIGHT, 'galleriffic_height', '5', '5', $helper->getConfig('galleriffic_height')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GFIC_WIDTH, 'galleriffic_width', '5', '5', $helper->getConfig('galleriffic_width')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GFIC_BGCOLOR, 'galleriffic_bgcolor', $helper->getConfig('galleriffic_bgcolor')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GFIC_BCOLOR, 'galleriffic_bordercolor', $helper->getConfig('galleriffic_bordercolor')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTGALLERY_GFIC_FONTCOLOR, 'galleriffic_fontcolor', $helper->getConfig('galleriffic_fontcolor')), false);
        $form->addElement(new \XoopsFormRadioYN(_AM_EXTGALLERY_GFIC_AUTOPLAY, 'galleriffic_autoplay', $helper->getConfig('galleriffic_autoplay')));
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GFIC_NB_THUMBS, 'galleriffic_nb_thumbs', '5', '5', $helper->getConfig('galleriffic_nb_thumbs')), false);
        $select_nbcol = new \XoopsFormSelect(_AM_EXTGALLERY_GFIC_NB_COLTHUMBS, 'galleriffic_nb_colthumbs', $helper->getConfig('galleriffic_nb_colthumbs'));
        $select_nbcol->addOption('0', '0 - hidden');
        $select_nbcol->addOption('1', '1');
        $select_nbcol->addOption('2', '2');
        $select_nbcol->addOption('3', '3');
        $form->addElement($select_nbcol);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GFIC_NB_PRELOAD, 'galleriffic_nb_preload', '5', '5', $helper->getConfig('galleriffic_nb_preload')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GFIC_TDELAY, 'galleriffic_tdelay', '5', '5', $helper->getConfig('galleriffic_tdelay')), false);
        $form->addElement(new \XoopsFormText(_AM_EXTGALLERY_GFIC_TSPEED, 'galleriffic_tspeed', '5', '5', $helper->getConfig('galleriffic_tspeed')), false);
        $form->addElement(new \XoopsFormRadioYN(_AM_EXTGALLERY_GFIC_SHOW_DESCR, 'galleriffic_show_descr', $helper->getConfig('galleriffic_show_descr')));
        $form->addElement(new \XoopsFormRadioYN(_AM_EXTGALLERY_GFIC_DOWNLOAD, 'galleriffic_download', $helper->getConfig('galleriffic_download')));
        $form->addElement(new \XoopsFormHidden('op', 'galleriffic'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $xoopsTpl->assign('gallerifficform', $form->render());

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/extgallery/templates/admin/extgallery_admin_slideshow.tpl');
        xoops_cp_footer();

        break;
}
