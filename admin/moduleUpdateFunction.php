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
define('_MU_MODULE_VERSION_FILE_URL', 'http://www.zoullou.net/extgalleryVersion.xml');
define('_MU_MODULE_DOWNLOAD_SERVER', 'http://downloads.sourceforge.net/zoullou/');
define('_MU_MODULE_XOOPS_VERSION_SUPPORTED', '2.5.9');

/**
 * @return array|bool
 */
function moduleLastVersionInfo()
{
    static $result;

    if (isset($result)) {
        return $result;
    }

    $data = @file_get_contents(_MU_MODULE_VERSION_FILE_URL);
    // If the file isn't reachable
    if (!$data) {
        return false;
    }
    $parser = xml_parser_create('ISO-8859-1');
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);

    $result = [];

    // boucle à travers les structures
    foreach ($tags as $key => $val) {
        if ('module' === $key) {
            $ranges = $val;
            // each contiguous pair of array entries are the
            // lower and upper range for each joueur definition
            for ($i = 0, $iMax = count($ranges); $i < $iMax; $i += 2) {
                $offset     = $ranges[$i] + 1;
                $len        = $ranges[$i + 1] - $offset;
                $dataValues = array_slice($values, $offset, $len);
                for ($j = 0, $jMax = count($dataValues); $j < $jMax; ++$j) {
                    $value                          = isset($dataValues[$j]['value']) ? $dataValues[$j]['value'] : '';
                    $result[$dataValues[$j]['tag']] = $value;
                }
            }
        } else {
            continue;
        }
    }

    return $result;
}

/**
 * @return mixed
 */
function getLastModuleVersion()
{
    $moduleInfos = moduleLastVersionInfo();

    return $moduleInfos['version'];
}

/**
 * @return string
 */
function getModuleVersion()
{
    $version = $GLOBALS['xoopsModule']->getVar('version');

    return substr($version, 0, 1) . '.' . substr($version, 1, 1) . '.' . substr($version, 2);
}

/**
 * @return bool
 */
function isModuleUpToDate()
{
    if (-1 != compareVersion(getModuleVersion(), getLastModuleVersion())) {
        return true;
    } else {
        return false;
    }
}

// Return -1 if v1 is lower than v2, 1 if v1 is greater than v2
// and 0 if equals
/**
 * @param $v1
 * @param $v2
 *
 * @return int
 */
function compareVersion($v1, $v2)
{
    $v1 = explode('.', $v1);
    $v2 = explode('.', $v2);

    if ($v1[0] > $v2[0]) {
        return 1;
    } elseif ($v1[0] == $v2[0]) {
        if ($v1[1] > $v2[1]) {
            return 1;
        } elseif ($v1[1] == $v2[1]) {
            if ($v1[2] > $v2[2]) {
                return 1;
            } elseif ($v1[2] == $v2[2]) {
                return 0;
            }
        }
    }

    return -1;
}

/**
 * @return bool
 */
function isXoopsVersionSupportInstalledModuleVersion()
{
    if (-1 != compareVersion(substr(XOOPS_VERSION, 6), _MU_MODULE_XOOPS_VERSION_SUPPORTED)) {
        return true;
    } else {
        return false;
    }
}

/**
 * @return bool
 */
function isXoopsVersionSupportLastModuleVersion()
{
    $moduleInfos = moduleLastVersionInfo();

    if (-1 != compareVersion(substr(XOOPS_VERSION, 6), $moduleInfos['xoopsVersionNeeded'])) {
        return true;
    } else {
        return false;
    }
}

/**
 * @return mixed
 */
function getChangelog()
{
    $moduleInfos = moduleLastVersionInfo();

    return $moduleInfos['versionChangelog'];
}
