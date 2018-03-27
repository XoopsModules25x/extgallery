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


/**
 * Class PhotoHandler
 */
class PhotoHandler extends Extgallery\PersistableObjectHandler
{
    public $photoUploader = null;

    /**
     * @param $db
     * @param $type
     */
    public function __construct(\XoopsDatabase $db, $type)
    {
        parent::__construct($db, 'extgallery_' . $type . 'photo', ucfirst($type) . 'Photo', 'photo_id');
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function createPhoto($data)
    {
        $photo = $this->create();
        $photo->setVars($data);

        return $this->insert($photo, true);
    }

    /**
     * @param $photoId
     * @param $data
     *
     * @return bool
     */
    public function modifyPhoto($photoId, $data)
    {
        $photo = $this->get($photoId);
        $photo->setVars($data);

        return $this->insert($photo, true);
    }

    /**
     * @param $photo
     */
    public function deletePhoto(&$photo)
    {
        if ('' == $photo->getVar('photo_serveur')) {
            $this->deleteFile($photo);
        }
        $this->deleteById($photo->getVar('photo_id'), true);
    }

    /**
     * @param $catId
     */
    public function deletePhotoByCat($catId)
    {
        $criteria = new \Criteria('cat_id', $catId);
        $photos   =& $this->getObjects($criteria);
        foreach ($photos as $photo) {
            $this->deletePhoto($photo);
        }
    }

    public function deleteFile()
    {
        exit('deleteFile() method must be defined on sub classes');
    }

    /**
     * @param $photoId
     *
     * @return bool
     */
    public function getPhoto($photoId)
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('photo_id', $photoId));
        $criteria->add(new \Criteria('photo_approved', 1));

        $photo =& $this->getObjects($criteria);
        if (1 != count($photo)) {
            return false;
        }

        return $photo[0];
    }

    /**
     * @param $cat
     *
     * @return int
     */
    public function nbPhoto(&$cat)
    {
        $criteria = new \Criteria('cat_id', $cat->getVar('cat_id'));

        return $this->getCount($criteria);
    }

    /**
     * @param $catId
     * @param $start
     * @param $sortby
     * @param $orderby
     *
     * @return array
     */
    public function getAlbumPhotoPage($catId, $start, $sortby, $orderby)
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('cat_id', $catId));
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->setStart($start);
        $criteria->setLimit($GLOBALS['xoopsModuleConfig']['nb_column'] * $GLOBALS['xoopsModuleConfig']['nb_line']);
        if ('' == $criteria->getSort()) {
            $criteria->setSort($sortby);
            $criteria->setOrder($orderby);
        }

        return $this->getObjects($criteria);
    }

    /**
     * @param $catId
     * @param $start
     *
     * @return array
     */
    public function getAlbumPhotoAdminPage($catId, $start)
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('cat_id', $catId));
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->setStart($start);
        $criteria->setLimit($GLOBALS['xoopsModuleConfig']['admin_nb_photo']);
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder($GLOBALS['xoopsModuleConfig']['display_set_order']);

        return $this->getObjects($criteria);
    }

    /**
     * @param $catId
     *
     * @return array
     */
    public function getSlideshowAlbumPhoto($catId)
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('cat_id', $catId));
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder($GLOBALS['xoopsModuleConfig']['display_set_order']);

        return $this->getObjects($criteria, false, false);
    }

    /**
     * @param $catId
     *
     * @return array
     */
    public function getPhotoAlbumId($catId)
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('cat_id', $catId));
        $criteria->add(new \Criteria('photo_approved', 1));

        $sql = 'SELECT photo_id FROM ' . $this->db->prefix('extgallery_publicphoto') . ' ' . $criteria->renderWhere() . ' ORDER BY photo_weight, photo_id ASC;';

        $result = $this->db->query($sql);
        $ret    = [];
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $ret[] = $myrow['photo_id'];
        }

        return $ret;
    }

    /**
     * @param $catId
     * @param $photoId
     *
     * @return array
     */
    public function getAlbumPrevPhoto($catId, $photoId)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->add(new \Criteria('cat_id', $catId));
        $criteria->add(new \Criteria('photo_id', $photoId, '<'));
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder('DESC');
        $criteria->setLimit(1);

        return $this->getObjects($criteria);
    }

    /**
     * @param $catId
     * @param $photoId
     *
     * @return array
     */
    public function getAlbumNextPhoto($catId, $photoId)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->add(new \Criteria('cat_id', $catId));
        $criteria->add(new \Criteria('photo_id', $photoId, '>'));
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit(1);

        return $this->getObjects($criteria);
    }

    /**
     * @param $catId
     * @param $photoId
     *
     * @return int
     */
    public function getAlbumCurrentPhotoPlace($catId, $photoId)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $criteria->add(new \Criteria('cat_id', $catId));
        $criteria->add(new \Criteria('photo_id', $photoId, '<='));
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder('DESC');

        return $this->getCount($criteria);
    }

    /**
     * @param $catId
     *
     * @return array
     */
    public function getAlbumPhoto($catId)
    {
        $criteria = new \Criteria('cat_id', $catId);
        $criteria->setSort('photo_weight, photo_id');
        $criteria->setOrder('ASC');

        return $this->getObjects($criteria);
    }

    /**
     * @param $category
     *
     * @return array
     */
    public function getCatPhoto(&$category)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('nleft', $category->getVar('nleft'), '>='));
        $criteria->add(new \Criteria('nright', $category->getVar('nright'), '<='));

        $cats = $catHandler->getObjects($criteria);

        $count = count($cats);
        if ($count > 0) {
            $in = '(' . $cats[0]->getVar('cat_id');
            array_shift($cats);
            /** @var Extgallery\Category $cat */
            foreach ($cats as $cat) {
                $in .= ',' . $cat->getVar('cat_id');
            }
            $in       .= ')';
            $criteria = new \Criteria('cat_id', $in, 'IN');
        } else {
            $criteria = new \Criteria('cat_id', '(0)', 'IN');
        }

        return $this->getObjects($criteria);
    }

    /**
     * @param $catId
     *
     * @return int
     */
    public function getAlbumCount($catId)
    {
        $criteria = new \Criteria('cat_id', $catId);

        return $this->getCount($criteria);
    }

    /**
     * @param $photoId
     *
     * @return bool
     */
    public function updateHits($photoId)
    {
        $criteria = new \Criteria('photo_id', $photoId);

        return $this->updateCounter('photo_hits', $criteria);
    }

    /**
     * @param $photoId
     *
     * @return bool
     */
    public function updateNbRating($photoId)
    {
        $criteria = new \Criteria('photo_id', $photoId);

        return $this->updateCounter('photo_nbrating', $criteria);
    }

    /**
     * @param $photoId
     *
     * @return bool
     */
    public function updateDownload($photoId)
    {
        $criteria = new \Criteria('photo_id', $photoId);

        return $this->updateCounter('photo_download', $criteria);
    }

    /**
     * @param $photoId
     *
     * @return bool
     */
    public function updateEcard($photoId)
    {
        $criteria = new \Criteria('photo_id', $photoId);

        return $this->updateCounter('photo_ecard', $criteria);
    }

    public function getAllSize()
    {
        exit('getAllSize() method must be defined on sub classes');
    }

    /**
     * @param $imageTransform
     */
    public function _makeWatermark(&$imageTransform)
    {
        if (!function_exists('imagettfbbox')) {
            return;
        }

        global $xoopsModuleConfig;

        /*  Text position param
        /
        /   0 : orig
        /   -1 : opposit
        /   1 : center
        /
        */
        if ('tl' === $xoopsModuleConfig['watermark_position']) {
            $x = 0;
            $y = 0;
        } elseif ('tr' === $xoopsModuleConfig['watermark_position']) {
            $x = -1;
            $y = 0;
        } elseif ('bl' === $xoopsModuleConfig['watermark_position']) {
            $x = 0;
            $y = -1;
        } elseif ('br' === $xoopsModuleConfig['watermark_position']) {
            $x = -1;
            $y = -1;
        } elseif ('tc' === $xoopsModuleConfig['watermark_position']) {
            $x = 1;
            $y = 0;
        } elseif ('bc' === $xoopsModuleConfig['watermark_position']) {
            $x = 1;
            $y = -1;
        } elseif ('lc' === $xoopsModuleConfig['watermark_position']) {
            $x = 0;
            $y = 1;
        } elseif ('rc' === $xoopsModuleConfig['watermark_position']) {
            $x = -1;
            $y = 1;
        } elseif ('cc' === $xoopsModuleConfig['watermark_position']) {
            $x = 1;
            $y = 1;
        }

        $text = (0 == $xoopsModuleConfig['watermark_type']) ? $GLOBALS['xoopsUser']->getVar('uname') : $xoopsModuleConfig['watermark_text'];

        $watermarkParams = [
            'text'         => $text,
            'x'            => $x,
            'y'            => $y,
            'color'        => $xoopsModuleConfig['watermark_color'],
            'font'         => XOOPS_ROOT_PATH . '/modules/extgallery/fonts/' . $xoopsModuleConfig['watermark_font'],
            'size'         => $xoopsModuleConfig['watermark_fontsize'],
            'resize_first' => false,
            'padding'      => $xoopsModuleConfig['watermark_padding']
        ];
        $imageTransform->addText($watermarkParams);
    }

    /**
     * @param $imageTransform
     */
    public function _makeBorder(&$imageTransform)
    {
        global $xoopsModuleConfig;

        $borders   = [];
        $borders[] = [
            'borderWidth' => $xoopsModuleConfig['inner_border_size'],
            'borderColor' => $xoopsModuleConfig['inner_border_color']
        ];
        $borders[] = [
            'borderWidth' => $xoopsModuleConfig['outer_border_size'],
            'borderColor' => $xoopsModuleConfig['outer_border_color']
        ];
//        $imageTransform->addBorders($borders);
        foreach ($borders as $border) {
            $imageTransform->addBorder($border['borderWidth'], $border['borderColor']);
        }
    }

    public function getUploadPhotoPath()
    {
        exit('getUploadPhotoPath() method must be defined on sub classes');
    }

    /**
     * @param $photoName
     */
    public function _largePhotoTreatment($photoName)
    {
        global $xoopsModuleConfig;

        // Check if must save large photo
        if ($xoopsModuleConfig['save_large']) {

            // Define Graphical library path
            if (!defined('IMAGE_TRANSFORM_IM_PATH') && 'imagick' === $xoopsModuleConfig['graphic_lib']) {
                define('IMAGE_TRANSFORM_IM_PATH', $xoopsModuleConfig['graphic_lib_path']);
            }
            $imageFactory   = new \Image_Transform;
            $imageTransform = $imageFactory->factory($xoopsModuleConfig['graphic_lib']);

            $filePath = $this->getUploadPhotoPath();
            $imageTransform->load($filePath . $photoName);

            // Save large photo only if it's bigger than medium size
            if ($imageTransform->getImageWidth() > $xoopsModuleConfig['medium_width']
                || $imageTransform->getImageHeight() > $xoopsModuleConfig['medium_heigth']) {

                // Make watermark
                if ($xoopsModuleConfig['enable_large_watermark']) {
                    $this->_makeWatermark($imageTransform);
                }

                // Make border
                if ($xoopsModuleConfig['enable_large_border']) {
                    $this->_makeBorder($imageTransform);
                }

                $largeFilePath = $filePath . 'large/large_' . $photoName;
                $imageTransform->save($largeFilePath, '', 100);
                $imageTransform->free();
            }
        }
    }

    /**
     * @param             $photoName
     * @param null|string $filePath
     * @param null        $mediumFilePath
     */
    public function _mediumPhotoTreatment($photoName, $filePath = null, $mediumFilePath = null)
    {
        global $xoopsModuleConfig;

        // Define Graphical library path
        if (!defined('IMAGE_TRANSFORM_IM_PATH') && 'imagick' === $xoopsModuleConfig['graphic_lib']) {
            define('IMAGE_TRANSFORM_IM_PATH', $xoopsModuleConfig['graphic_lib_path']);
        }
        $imageFactory   = new \Image_Transform;
        $imageTransform = $imageFactory->factory($xoopsModuleConfig['graphic_lib']);

        if (null === $filePath) {
            $filePath = $this->getUploadPhotoPath();
        }
        if (null === $mediumFilePath) {
            $mediumFilePath = $filePath . 'medium/' . $photoName;
        }
        $imageTransform->load($filePath . $photoName);

        // Fitting image to desired size
        if ($xoopsModuleConfig['enable_medium_border']) {
            $borderSize = ($xoopsModuleConfig['inner_border_size'] * 2) + ($xoopsModuleConfig['outer_border_size'] * 2);
        } else {
            $borderSize = 0;
        }
        $imageTransform->fit($xoopsModuleConfig['medium_width'] - $borderSize, $xoopsModuleConfig['medium_heigth'] - $borderSize);
        $imageTransform->save($mediumFilePath, '', $xoopsModuleConfig['medium_quality']);
        $imageTransform->free();

        if ($xoopsModuleConfig['enable_medium_watermark'] || $xoopsModuleConfig['enable_medium_border']) {
            $imageTransform->load($mediumFilePath);

            // Make watermark
            if ($xoopsModuleConfig['enable_medium_watermark']) {
                $this->_makeWatermark($imageTransform);
            }

            // Make border
            if ($xoopsModuleConfig['enable_medium_border']) {
                $this->_makeBorder($imageTransform);
            }

            $imageTransform->save($mediumFilePath, '', $xoopsModuleConfig['medium_quality']);
            $imageTransform->free();
        }
    }

    /**
     * @param $photoName
     */
    public function _makeThumb($photoName)
    {
        global $xoopsModuleConfig;

        // Define Graphical library path
        if (!defined('IMAGE_TRANSFORM_IM_PATH') && 'imagick' === $xoopsModuleConfig['graphic_lib']) {
            define('IMAGE_TRANSFORM_IM_PATH', $xoopsModuleConfig['graphic_lib_path']);
        }
        $imageFactory   = new \Image_Transform;
        $imageTransform = $imageFactory->factory($xoopsModuleConfig['graphic_lib']);

        $filePath  = $this->getUploadPhotoPath() . 'medium/' . $photoName;
        $thumbPath = $this->getUploadPhotoPath() . 'thumb/thumb_' . $photoName;

        $imageTransform->load($filePath);
        $imageTransform->fit($xoopsModuleConfig['thumb_width'], $xoopsModuleConfig['thumb_heigth']);
        $imageTransform->save($thumbPath, '', $xoopsModuleConfig['thumb_quality']);
        $imageTransform->free();
    }

    /**
     * @param $photoName
     *
     * @return bool
     */
    public function _haveLargePhoto($photoName)
    {
        return file_exists($this->getUploadPhotoPath() . 'large/large_' . $photoName);
    }

    /**
     * @param $photoName
     *
     * @return array
     */
    public function _getImageDimension($photoName)
    {
        global $xoopsModuleConfig;

        // Define Graphical library path
        if (!defined('IMAGE_TRANSFORM_IM_PATH') && 'imagick' === $xoopsModuleConfig['graphic_lib']) {
            define('IMAGE_TRANSFORM_IM_PATH', $xoopsModuleConfig['graphic_lib_path']);
        }
        $imageFactory   = new \Image_Transform;
        $imageTransform = $imageFactory->factory($xoopsModuleConfig['graphic_lib']);

        $ret = [];
        if ($this->_haveLargePhoto($photoName)) {
            $imageTransform->load($this->getUploadPhotoPath() . 'large/large_' . $photoName);
            $ret['width']  = $imageTransform->getImageWidth();
            $ret['height'] = $imageTransform->getImageHeight();
        } else {
            $imageTransform->load($this->getUploadPhotoPath() . 'medium/' . $photoName);
            $ret['width']  = $imageTransform->getImageWidth();
            $ret['height'] = $imageTransform->getImageHeight();
        }
        $imageTransform->free();

        return $ret;
    }

    /**
     * @param $photoName
     *
     * @return string
     */
    public function getAutoDescription($photoName)
    {
        global $xoopsModuleConfig;

        //DNPROSSI
        /*if ($xoopsModuleConfig['enable_longdesc']) {
            $newphotoname = '';
            $newnewphotoname = '';
            $patterns = array();
            $patterns[0] = "/-/";
            $patterns[1] = "/_/";
            $replacements = array();
            $replacements[0] = " ";
            $replacements[1] = "'";
            $newphotoName = substr($photoName, strpos($photoName, "-") + 1);
            $newphotoName = substr($newphotoName, strpos($newphotoName, "-") + 1);

            return preg_replace($patterns, $replacements, substr($newphotoName,0,-12));
        } else { */
        $matches = [];
        preg_match_all($xoopsModuleConfig['photoname_pattern'], substr($photoName, 0, -12), $matches);
        preg_match_all($xoopsModuleConfig['photoname_pattern'], $photoName, $matches);

        return implode(' ', $matches[1]);
        //}
    }

    /**
     * @param $fileName
     *
     * @return string
     */
    public function makeFileName($fileName)
    {
        //DNPROSSI
        //$fileName = preg_replace("/[^a-zA-Z0-9()_\.-]/", "-", $fileName);
        $fileName = preg_replace("/[^a-zA-Z0-9_\.-]/", '-', $fileName);

        $fileName = explode('.', $fileName);
        $userId   = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;

        return $fileName[0] . '_' . $userId . '_' . substr(md5(uniqid(mt_rand(), true)), 27) . '.' . $fileName[1];
    }

    /**
     * @param $photoName
     *
     * @return float
     */
    public function getPhotoSize($photoName)
    {
        if ($this->_haveLargePhoto($photoName)) {
            return $this->getFileSize('large/large_' . $photoName);
        } else {
            return $this->getFileSize($photoName);
        }
    }

    /**
     * @param $fileName
     *
     * @return float
     */
    public function getFileSize($fileName)
    {
        return round(filesize($this->getUploadPhotoPath() . $fileName) / 1024, 2);
    }

    /**
     * @param $catId
     */
    public function rebuildThumbnail($catId)
    {
        $photos = $this->getAlbumPhoto($catId);
        foreach ($photos as $photo) {
            $this->_makeThumb($photo->getVar('photo_name'));
        }
    }

    /* Return Code :
        0 : Photo added
        1 : Photo pending
        2 : This is not an album
        3 : HTTP Upload error
        4 : File rejected
        5 : File chunk receive
        */
    /**
     * @param      $file
     * @param bool $checkMd5
     *
     * @return int
     */
    public function postPhotoTraitement($file, $checkMd5 = false)
    {
        //        require_once XOOPS_ROOT_PATH.'/modules/extgallery/class/photoUploader.php';

        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $catId = (int)$_POST['cat_id'];

        // If isn't an album when stop the traitment
        $cat = $catHandler->getCat($catId);
        if (null !== $cat && (1 != $cat->getVar('nright') - $cat->getVar('nleft'))) {
            return 2;
        }

        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png'];
        //        $allowedMimeTypes = array('jpg/jpeg', 'image/bmp', 'image/gif', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png');

        $uploadDir = XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/';

        //        $this->photoUploader = new Extgallery\PhotoUploader($uploadDir,  50000000, 5000, 5000);
        //        $this->photoUploader->checkMd5 = $checkMd5;
        //        $this->photoUploader->fetchPhoto($_FILES[$file]);

        //------------------------
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $this->photoUploader = new \XoopsMediaUploader($uploadDir, $allowedMimeTypes, 50000000, 5000, 5000);

        $jupart  = isset($_POST['jupart']) ? (int)$_POST['jupart'] : 0;
        $jufinal = isset($_POST['jufinal']) ? (int)$_POST['jufinal'] : 1;

        if ($this->photoUploader->fetchMedia($file) && $this->photoUploader->upload()) {
        } else {
            // We got a chunk, so we don't add photo to database
            if ($jupart && !$jufinal) {
                return 5;
            } else {
                return 4;
            }
        }

        //---------------------------

        /*

                $jupart = (isset($_POST['jupart'])) ? (int) $_POST['jupart'] : 0;
                $jufinal = (isset($_POST['jufinal'])) ? (int) $_POST['jufinal'] : 1;

                if ($this->photoUploader->isError()) {
                    return 4;
                // We got a chunk, so we don't add photo to database
                } elseif ($jupart && !$jufinal) {
                    return 5;
                }
        */

        //DNPROSSI - add missing title and description on upload
        $photoTitle = '';
        $photoDesc  = '';
        $photoExtra = '';
        $photoTag   = '';

        if (isset($_POST['photo_title'])) {
            $photoTitle = $_POST['photo_title'];
        }
        if (isset($_POST['photo_desc'])) {
            $photoDesc = $_POST['photo_desc'];
        }
        if (isset($_POST['photo_extra'])) {
            $photoExtra = $_POST['photo_extra'];
        }
        if (isset($_POST['tag'])) {
            $photoTag = $_POST['tag'];
        }

        $photoStatus = $this->addLocalPhoto($catId, $this->photoUploader->getSavedFileName(), $photoTitle, $photoDesc, $photoExtra, $photoTag);
        /** @var Extgallery\Category $cat */
        $cat = $catHandler->getCat($catId);
        $cat->setVar('cat_isalbum', 1);
        $catHandler->insert($cat);

        /** @var \XoopsNotificationHandler $notificationHandler */
        $notificationHandler = xoops_getHandler('notification');
        $extraTags           = [
            'X_ITEM_CAT'     => $cat->getVar('cat_name'),
            'X_ITEM_NBPHOTO' => 1
        ];

        if (1 == $photoStatus) {
            $extraTags['X_ITEM_URL'] = XOOPS_URL . '/modules/extgallery/public-album.php?id=' . $cat->getVar('cat_id');
            $notificationHandler->triggerEvent('global', 0, 'new_photo', $extraTags);
            $notificationHandler->triggerEvent('album', $cat->getVar('cat_id'), 'new_photo_album', $extraTags);

            // Update album count
            if (0 == $cat->getVar('cat_nb_photo')) {
                $criteria = new \CriteriaCompo();
                $criteria->add(new \Criteria('nleft', $cat->getVar('nleft'), '<'));
                $criteria->add(new \Criteria('nright', $cat->getVar('nright'), '>'));
                $catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album + 1', $criteria);
            }

            // Update photo count
            $criteria = new \CriteriaCompo();
            $criteria->add(new \Criteria('nleft', $cat->getVar('nleft'), '<='));
            $criteria->add(new \Criteria('nright', $cat->getVar('nright'), '>='));
            $catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo + 1', $criteria);

            return 0;
        } else {
            $extraTags['X_ITEM_URL'] = XOOPS_URL . '/modules/extgallery/admin/photo.php';
            $notificationHandler->triggerEvent('global', 0, 'new_photo_pending', $extraTags);

            return 1;
        }
    }

    /**
     * @param        $catId
     * @param        $dirtyPhotoName
     * @param string $photoTitle
     * @param string $photoDesc
     * @param string $photoExtra
     * @param string $photoTag
     *
     * @return mixed
     */
    public function addLocalPhoto(
        $catId,
        $dirtyPhotoName,
        $photoTitle = '',
        $photoDesc = '',
        $photoExtra = '',
        $photoTag = ''
    ) {
        require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/pear/Image/Transform.php';

        global $xoopsModuleConfig;
        $permHandler = Extgallery\PublicPermHandler::getInstance();

        // Replace all bad file name character
        $photoName = $this->makeFileName($dirtyPhotoName);
        rename($this->getUploadPhotoPath() . $dirtyPhotoName, $this->getUploadPhotoPath() . $photoName);

        //DNPROSSI - changed photo_desc to photo_title
        // Making auto description
        if ('' === $photoTitle) {
            $photoTitle = $this->getAutoDescription($photoName);
        }

        $originalName = '';
        // Save original photo
        if ($xoopsModuleConfig['save_large'] && $xoopsModuleConfig['save_original']) {
            $fileName     = explode('.', $photoName);
            $originalName = md5(uniqid(mt_rand(), true)) . '.' . $fileName[1];
            copy($this->getUploadPhotoPath() . $photoName, $this->getUploadPhotoPath() . 'original/' . $originalName);
        }

        $this->_largePhotoTreatment($photoName);

        $this->_mediumPhotoTreatment($photoName);

        $this->_makeThumb($photoName);

        $imageDimension = $this->_getImageDimension($photoName);

        $userId = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
        $data   = [
            'cat_id'          => $catId,
            'photo_title'     => $photoTitle,
            'photo_desc'      => $photoDesc,
            'photo_name'      => $photoName,
            'photo_orig_name' => $originalName,
            'uid'             => $userId,
            'photo_size'      => $this->getPhotoSize($photoName),
            'photo_res_x'     => $imageDimension['width'],
            'photo_res_y'     => $imageDimension['height'],
            'photo_date'      => time(),
            'photo_havelarge' => $this->_haveLargePhoto($photoName),
            'photo_approved'  => $permHandler->isAllowed($GLOBALS['xoopsUser'], 'public_autoapprove', $catId),
            'photo_extra'     => $photoExtra,
            'dohtml'          => $xoopsModuleConfig['allow_html']
        ];

        // Deleting working photo
        unlink($this->getUploadPhotoPath() . $photoName);

        $this->createPhoto($data);

        if (1 == $xoopsModuleConfig['usetag'] || (is_dir('../tag') || is_dir('../../tag'))) {
            $newid      = $this->db->getInsertId();
            $tagHandler = \XoopsModules\Tag\Helper::getInstance()->getHandler('Tag'); // xoops_getModuleHandler('tag', 'tag');
            $tagHandler->updateByItem($photoTag, $newid, 'extgallery', 0);
        }

        return $data['photo_approved'];
    }

    /**
     * @param $queryArray
     * @param $condition
     * @param $limit
     * @param $start
     * @param $userId
     *
     * @return array
     */
    public function getSearchedPhoto($queryArray, $condition, $limit, $start, $userId)
    {
        $criteria = new \CriteriaCompo();
        if ($userId > 0) {
            $criteria->add(new \Criteria('uid', $userId));
        }
        $criteria->add(new \Criteria('photo_approved', 1));
        if (is_array($queryArray) && count($queryArray) > 0) {
            $subCriteria = new \CriteriaCompo();
            foreach ($queryArray as $keyWord) {
                $keyWordCriteria = new \CriteriaCompo();
                $keyWordCriteria->add(new \Criteria('photo_title', '%' . $keyWord . '%', 'LIKE'));
                $keyWordCriteria->add(new \Criteria('photo_desc', '%' . $keyWord . '%', 'LIKE'), 'OR');
                $keyWordCriteria->add(new \Criteria('photo_name', '%' . $keyWord . '%', 'LIKE'), 'OR');
                $subCriteria->add($keyWordCriteria, $condition);
                unset($keyWordCriteria);
            }
            $criteria->add($subCriteria);
        }
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $criteria->setSort('photo_date');

        $photos =& $this->getObjects($criteria);

        $ret = [];
        foreach ($photos as $photo) {
            if ($photo->getVar('photo_title')) {
                $title = $photo->getVar('photo_title');
            } else {
                $title = $photo->getVar('photo_desc');
            }
            $data  = [
                'image' => 'assets/images/extgallery-posticon.gif',
                'link'  => 'public-photo.php?photoId=' . $photo->getVar('photo_id'),
                'title' => $title,
                'time'  => $photo->getVar('photo_date'),
                'uid'   => $photo->getVar('uid')
            ];
            $ret[] = $data;
        }

        return $ret;
    }

    /**
     * @return array
     */
    public function getPendingPhoto()
    {
        $criteria = new \Criteria('photo_approved', 0);

        return $this->getObjects($criteria);
    }

    /**
     * @param $criteria
     * @param $data
     */
    public function addInCriteria(&$criteria, $data)
    {
        $count = count($data);
        if ($count > 0) {
            $in = '(' . $data[0];
            array_shift($data);
            foreach ($data as $elmt) {
                $in .= ',' . $elmt;
            }
            $in .= ')';
            $criteria->add(new \Criteria('cat_id', $in, 'IN'));
        }
    }

    /**
     * @param $param
     *
     * @return array
     */
    public function getRandomPhoto($param)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');
        $criteria   = new \CriteriaCompo();
        if (null !== $catHandler->getCatRestrictCriteria()) {
            $criteria->add($catHandler->getCatRestrictCriteria());
        }
        $criteria->add(new \Criteria('photo_approved', 1));
        $this->addInCriteria($criteria, $param['cat']);
        $criteria->setSort('RAND()');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    /**
     * @param $param
     *
     * @return array
     */
    public function getLastPhoto($param)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $this->addInCriteria($criteria, $param['cat']);
        $criteria->setSort('photo_date');
        $criteria->setOrder('DESC');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    /**
     * @param $param
     *
     * @return array
     */
    public function getTopViewPhoto($param)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $this->addInCriteria($criteria, $param['cat']);
        $criteria->setSort('photo_hits');
        $criteria->setOrder('DESC');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    /**
     * @param $param
     *
     * @return array
     */
    public function getTopRatedPhoto($param)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $this->addInCriteria($criteria, $param['cat']);
        $criteria->setSort('photo_rating');
        $criteria->setOrder('DESC');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    /**
     * @param $param
     *
     * @return array
     */
    public function getTopEcardPhoto($param)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \CriteriaCompo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new \Criteria('photo_approved', 1));
        $this->addInCriteria($criteria, $param['cat']);
        $criteria->setSort('photo_ecard');
        $criteria->setOrder('DESC');
        $criteria->setLimit($param['limit']);

        return $this->getObjects($criteria);
    }

    /**
     * @param $param
     */
    public function getTopSubmitter($param)
    {
        $catHandler = Extgallery\Helper::getInstance()->getHandler('PublicCategory');

        $criteria = new \Criteria();
        $this->addInCriteria($criteria, $param['cat']);

        echo $criteria->renderWhere();
    }

    /**
     * @return mixed
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }
}
