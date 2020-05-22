<?php

namespace XoopsModules\Extgallery;

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
use XoopsModules\Tag;
use XoopsModules\Tag\Helper;

// defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class PhotoHandler
 */
class PhotoHandler extends Extgallery\PersistableObjectHandler
{
    public $photoUploader = null;

    /**
     * @param \XoopsDatabase|null $db
     * @param                     $type
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
        $photos   = $this->getObjects($criteria);
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

        $photo = $this->getObjects($criteria);
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
            $ret[] = (int)$myrow['photo_id'];
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

        /** @var Extgallery\Helper $helper */
        $helper = Extgallery\Helper::getInstance();

        /*  Text position param
        /
        /   0 : orig
        /   -1 : opposit
        /   1 : center
        /
        */
        if ('tl' === $helper->getConfig('watermark_position')) {
            $x = 0;
            $y = 0;
        } elseif ('tr' === $helper->getConfig('watermark_position')) {
            $x = -1;
            $y = 0;
        } elseif ('bl' === $helper->getConfig('watermark_position')) {
            $x = 0;
            $y = -1;
        } elseif ('br' === $helper->getConfig('watermark_position')) {
            $x = -1;
            $y = -1;
        } elseif ('tc' === $helper->getConfig('watermark_position')) {
            $x = 1;
            $y = 0;
        } elseif ('bc' === $helper->getConfig('watermark_position')) {
            $x = 1;
            $y = -1;
        } elseif ('lc' === $helper->getConfig('watermark_position')) {
            $x = 0;
            $y = 1;
        } elseif ('rc' === $helper->getConfig('watermark_position')) {
            $x = -1;
            $y = 1;
        } elseif ('cc' === $helper->getConfig('watermark_position')) {
            $x = 1;
            $y = 1;
        }

        $text = (0 == $helper->getConfig('watermark_type')) ? $GLOBALS['xoopsUser']->getVar('uname') : $helper->getConfig('watermark_text');

        $watermarkParams = [
            'text'         => $text,
            'x'            => $x,
            'y'            => $y,
            'color'        => $helper->getConfig('watermark_color'),
            'font'         => XOOPS_ROOT_PATH . '/modules/extgallery/fonts/' . $helper->getConfig('watermark_font'),
            'size'         => $helper->getConfig('watermark_fontsize'),
            'resize_first' => false,
            'padding'      => $helper->getConfig('watermark_padding'),
        ];
        $imageTransform->addText($watermarkParams);
    }

    /**
     * @param $imageTransform
     */
    public function _makeBorder(&$imageTransform)
    {
        /** @var Extgallery\Helper $helper */
        $helper = Extgallery\Helper::getInstance();

        $borders   = [];
        $borders[] = [
            'borderWidth' => $helper->getConfig('inner_border_size'),
            'borderColor' => $helper->getConfig('inner_border_color'),
        ];
        $borders[] = [
            'borderWidth' => $helper->getConfig('outer_border_size'),
            'borderColor' => $helper->getConfig('outer_border_color'),
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
        /** @var Extgallery\Helper $helper */
        $helper = Extgallery\Helper::getInstance();

        // Check if must save large photo
        if ($helper->getConfig('save_large')) {
            // Define Graphical library path
            if (!defined('IMAGE_TRANSFORM_IM_PATH') && 'imagick' === $helper->getConfig('graphic_lib')) {
                define('IMAGE_TRANSFORM_IM_PATH', $helper->getConfig('graphic_lib_path'));
            }
            $imageFactory   = new \Image_Transform();
            $imageTransform = $imageFactory->factory($helper->getConfig('graphic_lib'));

            $filePath = $this->getUploadPhotoPath();
            $imageTransform->load($filePath . $photoName);

            // Save large photo only if it's bigger than medium size
            if ($imageTransform->getImageWidth() > $helper->getConfig('medium_width')
                || $imageTransform->getImageHeight() > $helper->getConfig('medium_heigth')) {
                // Make watermark
                if ($helper->getConfig('enable_large_watermark')) {
                    $this->_makeWatermark($imageTransform);
                }

                // Make border
                if ($helper->getConfig('enable_large_border')) {
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
        /** @var Extgallery\Helper $helper */
        $helper = Extgallery\Helper::getInstance();

        // Define Graphical library path
        if (!defined('IMAGE_TRANSFORM_IM_PATH') && 'imagick' === $helper->getConfig('graphic_lib')) {
            define('IMAGE_TRANSFORM_IM_PATH', $helper->getConfig('graphic_lib_path'));
        }
        $imageFactory   = new \Image_Transform();
        $imageTransform = $imageFactory->factory($helper->getConfig('graphic_lib'));

        if (null === $filePath) {
            $filePath = $this->getUploadPhotoPath();
        }
        if (null === $mediumFilePath) {
            $mediumFilePath = $filePath . 'medium/' . $photoName;
        }
        $imageTransform->load($filePath . $photoName);

        // Fitting image to desired size
        if ($helper->getConfig('enable_medium_border')) {
            $borderSize = ($helper->getConfig('inner_border_size') * 2) + ($helper->getConfig('outer_border_size') * 2);
        } else {
            $borderSize = 0;
        }
        $imageTransform->fit($helper->getConfig('medium_width') - $borderSize, $helper->getConfig('medium_heigth') - $borderSize);
        $imageTransform->save($mediumFilePath, '', $helper->getConfig('medium_quality'));
        $imageTransform->free();

        if ($helper->getConfig('enable_medium_watermark') || $helper->getConfig('enable_medium_border')) {
            $imageTransform->load($mediumFilePath);

            // Make watermark
            if ($helper->getConfig('enable_medium_watermark')) {
                $this->_makeWatermark($imageTransform);
            }

            // Make border
            if ($helper->getConfig('enable_medium_border')) {
                $this->_makeBorder($imageTransform);
            }

            $imageTransform->save($mediumFilePath, '', $helper->getConfig('medium_quality'));
            $imageTransform->free();
        }
    }

    /**
     * @param $photoName
     */
    public function _makeThumb($photoName)
    {
        /** @var Extgallery\Helper $helper */
        $helper = Extgallery\Helper::getInstance();

        // Define Graphical library path
        if (!defined('IMAGE_TRANSFORM_IM_PATH') && 'imagick' === $helper->getConfig('graphic_lib')) {
            define('IMAGE_TRANSFORM_IM_PATH', $helper->getConfig('graphic_lib_path'));
        }
        $imageFactory   = new \Image_Transform();
        $imageTransform = $imageFactory->factory($helper->getConfig('graphic_lib'));

        $filePath  = $this->getUploadPhotoPath() . 'medium/' . $photoName;
        $thumbPath = $this->getUploadPhotoPath() . 'thumb/thumb_' . $photoName;

        $imageTransform->load($filePath);
        $imageTransform->fit($helper->getConfig('thumb_width'), $helper->getConfig('thumb_heigth'));
        $imageTransform->save($thumbPath, '', $helper->getConfig('thumb_quality'));
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
        /** @var Extgallery\Helper $helper */
        $helper = Extgallery\Helper::getInstance();

        // Define Graphical library path
        if (!defined('IMAGE_TRANSFORM_IM_PATH') && 'imagick' === $helper->getConfig('graphic_lib')) {
            define('IMAGE_TRANSFORM_IM_PATH', $helper->getConfig('graphic_lib_path'));
        }
        $imageFactory   = new \Image_Transform();
        $imageTransform = $imageFactory->factory($helper->getConfig('graphic_lib'));

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
        /** @var Extgallery\Helper $helper */
        $helper = Extgallery\Helper::getInstance();

        //DNPROSSI
        /*if ($helper->getConfig('enable_longdesc')) {
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
        preg_match_all($helper->getConfig('photoname_pattern'), mb_substr($photoName, 0, -12), $matches);
        preg_match_all($helper->getConfig('photoname_pattern'), $photoName, $matches);

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

        return $fileName[0] . '_' . $userId . '_' . mb_substr(md5(uniqid(mt_rand(), true)), 27) . '.' . $fileName[1];
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
        }

        return $this->getFileSize($photoName);
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

        $catId = \Xmf\Request::getInt('cat_id', 0, 'POST');

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

        $jupart  = \Xmf\Request::getInt('jupart', 0, 'POST');
        $jufinal = \Xmf\Request::getInt('jufinal', 1, 'POST');

        if ($this->photoUploader->fetchMedia($file) && $this->photoUploader->upload()) {
        } else {
            // We got a chunk, so we don't add photo to database
            if ($jupart && !$jufinal) {
                return 5;
            }

            return 4;
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

        if (\Xmf\Request::hasVar('photo_title', 'POST')) {
            $photoTitle = $_POST['photo_title'];
        }
        if (\Xmf\Request::hasVar('photo_desc', 'POST')) {
            $photoDesc = $_POST['photo_desc'];
        }
        if (\Xmf\Request::hasVar('photo_extra', 'POST')) {
            $photoExtra = $_POST['photo_extra'];
        }
        if (\Xmf\Request::hasVar('tag', 'POST')) {
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
            'X_ITEM_NBPHOTO' => 1,
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
        }
        $extraTags['X_ITEM_URL'] = XOOPS_URL . '/modules/extgallery/admin/photo.php';
        $notificationHandler->triggerEvent('global', 0, 'new_photo_pending', $extraTags);

        return 1;
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
        $photoTag = '')
    {
        require_once XOOPS_ROOT_PATH . '/modules/extgallery/class/pear/Image/Transform.php';

        $permHandler = Extgallery\PublicPermHandler::getInstance();
        /** @var Extgallery\Helper $helper */
        $helper = Extgallery\Helper::getInstance();

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
        if ($helper->getConfig('save_large') && $helper->getConfig('save_original')) {
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
            'dohtml'          => $helper->getConfig('allow_html'),
        ];

        // Deleting working photo
        unlink($this->getUploadPhotoPath() . $photoName);

        $this->createPhoto($data);

        //        if (1 == $helper->getConfig('usetag') || (is_dir('../tag') || is_dir('../../tag'))) {
        if (class_exists(Helper::class) && 1 == $helper->getConfig('usetag')) {
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
        if ($queryArray && is_array($queryArray)) {
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

        $photos = $this->getObjects($criteria);

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
                'uid'   => $photo->getVar('uid'),
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

        $criteria = new \Criteria('');
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
