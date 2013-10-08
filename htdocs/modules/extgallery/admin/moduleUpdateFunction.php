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
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 * @version     $Id: moduleUpdateFunction.php 8088 2011-11-06 09:38:12Z beckmi $
 */

define('_MU_MODULE_VERSION_FILE_URL',"http://www.zoullou.net/extgalleryVersion.xml");
define('_MU_MODULE_DOWNLOAD_SERVER',"http://downloads.sourceforge.net/zoullou/");
define('_MU_MODULE_XOOPS_VERSION_SUPPORTED',"2.4.0");

function moduleLastVersionInfo() {

 static $result;

 if(isset($result)) {
  return $result;
 }

 $data = @file_get_contents(_MU_MODULE_VERSION_FILE_URL);
 // If the file isn't reachable
 if(!$data) {
  return false;
 }
 $parser = xml_parser_create('ISO-8859-1');
 xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
 xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
 xml_parse_into_struct($parser,$data,$values,$tags);
 xml_parser_free($parser);

 $result = array();

 // boucle à travers les structures
 foreach ($tags as $key=>$val) {
  if ($key == "module") {
   $ranges = $val;
   // each contiguous pair of array entries are the
   // lower and upper range for each joueur definition
   for ($i=0; $i < count($ranges); $i+=2) {
    $offset = $ranges[$i] + 1;
    $len = $ranges[$i + 1] - $offset;
    $dataValues = array_slice($values, $offset, $len);
    for ($j=0; $j < count($dataValues); $j++) {
     $value = isset($dataValues[$j]["value"]) ? $dataValues[$j]["value"] : "" ;
     $result[$dataValues[$j]["tag"]] = $value;
    }
   }
  } else {
   continue;
  }
 }

 return $result;

}

function getLastModuleVersion() {
 $moduleInfos = moduleLastVersionInfo();
 return $moduleInfos['version'];
}

function getModuleVersion() {

 $version = $GLOBALS['xoopsModule']->getVar('version');
 return substr($version,0,1).'.'.substr($version,1,1).'.'.substr($version,2);

}

function isModuleUpToDate() {

	if(compareVersion(getModuleVersion(), getLastModuleVersion()) != -1) {
  return true;
	} else {
	 return false;
	}

}

// Return -1 if v1 is lower than v2, 1 if v1 is greater than v2
// and 0 if equals
function compareVersion($v1, $v2) {

 $v1 = explode('.', $v1);
 $v2 = explode('.', $v2);

 if($v1[0] > $v2[0]) {
  return 1;
 } elseif($v1[0] == $v2[0]) {
  if($v1[1] > $v2[1]) {
   return 1;
  } elseif($v1[1] == $v2[1]) {
   if($v1[2] > $v2[2]) {
    return 1;
   } elseif ($v1[2] == $v2[2]) {
    return 0;
   }
  }
 }

 return -1;

}

function isXoopsVersionSupportInstalledModuleVersion() {

 if(compareVersion(substr(XOOPS_VERSION,6), _MU_MODULE_XOOPS_VERSION_SUPPORTED) != -1) {
  return true;
	} else {
	 return false;
	}

}

function isXoopsVersionSupportLastModuleVersion() {

 $moduleInfos = moduleLastVersionInfo();

 if(compareVersion(substr(XOOPS_VERSION,6), $moduleInfos['xoopsVersionNeeded']) != -1) {
  return true;
	} else {
	 return false;
	}

}

function getChangelog() {

 $moduleInfos = moduleLastVersionInfo();

 return $moduleInfos['versionChangelog'];

}

?>