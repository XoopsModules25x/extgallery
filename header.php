<?php

use XoopsModules\Extgallery;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
$moduleDirName = basename(__DIR__);
require_once __DIR__ . '/include/common.php';

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

//require_once __DIR__ . '/class/Utility.php';

$grouppermHandler = xoops_getHandler('groupperm');
$groups       = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];

$myts = \MyTextSanitizer::getInstance();
/** @var Extgallery\Helper $helper */
$helper = Extgallery\Helper::getInstance();

$helper->loadLanguage('main');
$helper->loadLanguage('common');

//------------------------------------------------------
// Getting eXtCal object's handler
//$catHandler        = xoops_getModuleHandler(_EXTCAL_CLS_CAT, _EXTCAL_MODULE);
//$eventHandler      = xoops_getModuleHandler(_EXTCAL_CLS_EVENT, _EXTCAL_MODULE);
//$extcalTimeHandler = ExtcalTime::getHandler();
//$permHandler       = ExtcalPerm::getHandler();
// $GLOBALS['xoopsUser']         = $GLOBALS['xoopsUser'] ?: null;
//------------------------------------------------------
