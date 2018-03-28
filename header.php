<?php

use XoopsModules\Extgallery;

include __DIR__ . '/../../mainfile.php';
$moduleDirName = basename(__DIR__);
require_once __DIR__ . '/include/common.php';

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

//require_once __DIR__ . '/class/Utility.php';

$myts = \MyTextSanitizer::getInstance();
$helper = Extgallery\Helper::getInstance();

$helper->loadLanguage('main');

//------------------------------------------------------
// Getting eXtCal object's handler
//$catHandler        = xoops_getModuleHandler(_EXTCAL_CLS_CAT, _EXTCAL_MODULE);
//$eventHandler      = xoops_getModuleHandler(_EXTCAL_CLS_EVENT, _EXTCAL_MODULE);
//$extcalTimeHandler = ExtcalTime::getHandler();
//$permHandler       = ExtcalPerm::getHandler();
//$GLOBALS['xoopsUser']         = $GLOBALS['xoopsUser'] ?: null;
//------------------------------------------------------
