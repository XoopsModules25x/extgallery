<?php

use Xmf\Language;

include __DIR__ . '/../../mainfile.php';
$moduleDirName = basename(__DIR__);
include_once __DIR__ . '/include/common.php';

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

include_once __DIR__ . '/class/utilities.php';

$myts = MyTextSanitizer::getInstance();

Language::load('main', $moduleDirName);

//------------------------------------------------------
// Getting eXtCal object's handler
//$catHandler        = xoops_getModuleHandler(_EXTCAL_CLS_CAT, _EXTCAL_MODULE);
//$eventHandler      = xoops_getModuleHandler(_EXTCAL_CLS_EVENT, _EXTCAL_MODULE);
//$extcalTimeHandler = ExtcalTime::getHandler();
//$permHandler       = ExtcalPerm::getHandler();
//$xoopsUser         = $xoopsUser ?: null;
//------------------------------------------------------


