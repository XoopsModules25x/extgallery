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
 * Class Extgallery\CategoryHandler
 */
class CategoryHandler extends Extgallery\PersistableObjectHandler
{
    //var $_nestedTree;
    public $_photoHandler;

    /**
     * @param $db
     * @param $type
     */
    public function __construct(\XoopsDatabase $db, $type)
    {
        parent::__construct($db, 'extgallery_' . $type . 'cat', ucfirst($type) . 'Category', 'cat_id');
        //$this->_nestedTree = new NestedTree($db, 'extgallery_'.$type.'cat', 'cat_id', 'cat_pid', 'cat_id');
        $this->_photoHandler = Extgallery\Helper::getInstance()->getHandler(ucfirst($type) . 'Photo');
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function createCat($data)
    {
        $cat = $this->create();
        $cat->setVars($data);

        if (!$this->hasValidParent($cat)) {
            return false;
        }

        $this->insert($cat, true);
        $this->rebuild();

        return true;
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function modifyCat($data)
    {
        $cat = $this->get($data['cat_id']);
        $cat->setVars($data);

        if (!$this->hasValidParent($cat)) {
            return false;
        }
        $this->insert($cat, true);

        // Rebluid the tree only if the structure is modified
        if (isset($data['cat_pid']) || isset($data['nlevel']) || isset($data['nright']) || isset($data['nleft'])) {
            $this->rebuild();
        }
        return '';
    }

    /**
     * @param int $catId
     */
    public function deleteCat($catId)
    {
        $children = $this->getDescendants($catId, false, true);
        foreach ($children as $child) {
            $this->_photoHandler->deletePhotoByCat($child->getVar('cat_id'));
            $this->deleteCat($child->getVar('cat_id'));
        }
        $this->_photoHandler->deletePhotoByCat($catId);
        $this->deleteById($catId);
    }

    /**
     * @param int    $id
     * @param bool   $includeSelf
     * @param bool   $childrenOnly
     * @param bool   $withRestrict
     * @param string $permType
     *
     * @return array
     */
    public function getDescendants(
        $id = 0,
        $includeSelf = false,
        $childrenOnly = false,
        $withRestrict = true,
        $permType = 'public_access'
    ) {
        $cat = $this->get($id);

        $nleft     = $cat->getVar('nleft');
        $nright    = $cat->getVar('nright');
        $parent_id = $cat->getVar('cat_id');

        $criteria = new \CriteriaCompo();

        if ($childrenOnly) {
            $criteria->add(new \Criteria('cat_pid', $parent_id), 'OR');
            if ($includeSelf) {
                $criteria->add(new \Criteria('cat_id', $parent_id));
                //$query = sprintf('select * from %s where %s = %d or %s = %d order by nleft', $this->table, $this->fields['id'], $parent_id, $this->fields['parent'], $parent_id);
            }/* else {
                //$query = sprintf('select * from %s where %s = %d order by nleft', $this->table, $this->fields['parent'], $parent_id);
            }*/
        } else {
            if ($nleft > 0 && $includeSelf) {
                $criteria->add(new \Criteria('nleft', $nleft, '>='));
                $criteria->add(new \Criteria('nright', $nright, '<='));
            //$query = sprintf('select * from %s where nleft >= %d and nright <= %d order by nleft', $this->table, $nleft, $nright);
            } else {
                if ($nleft > 0) {
                    $criteria->add(new \Criteria('nleft', $nleft, '>'));
                    $criteria->add(new \Criteria('nright', $nright, '<'));
                    //$query = sprintf('select * from %s where nleft > %d and nright < %d order by nleft', $this->table, $nleft, $nright);
                }/* else {
                $query = sprintf('select * from %s order by nleft', $this->table);
                }*/
            }
        }
        if ($withRestrict) {
            $temp = $this->getCatRestrictCriteria($permType);
            if (null !== $temp) {
                $criteria->add($temp);
            }
            $temp = $this->getCatRestrictCriteria('public_displayed');
            if (null !== $temp) {
                $criteria->add($temp);
            }
        }
        $criteria->setSort('nleft');

        return $this->getObjects($criteria);
    }

    /**
     * @param int $id
     *
     * @return null
     */
    public function getCat($id = 0)
    {
        $criteria = new \CriteriaCompo();
        $criteria->add($this->getCatRestrictCriteria('public_displayed'));
        $criteria->add(new \Criteria('cat_id', $id));
        $ret =& $this->getObjects($criteria);

        if (count($ret) > 0) {
            return $ret[0];
        }

        return null;
    }

    public function hasValidParent()
    {
        exit('hasValidParent() method must be defined on sub classes');
    }

    /**
     * @param $cat
     *
     * @return bool
     */
    public function _isAlbum($cat)
    {
        $nbPhoto = $this->nbPhoto($cat);

        return 0 != $nbPhoto;
    }

    /**
     * @param Extgallery\Category $cat
     *
     * @return mixed
     */
    public function nbPhoto(&$cat)
    {
        /** @var Extgallery\CategoryHandler $this ->_photoHandler */
        return $this->_photoHandler->nbPhoto($cat);
    }

    /**
     * @param int  $id
     * @param bool $includeSelf
     *
     * @return array
     */
    public function getPath($id = 0, $includeSelf = false)
    {
        $cat = $this->get($id);
        if (null === $cat) {
            return [];
        }

        $criteria = new \CriteriaCompo();
        if ($includeSelf) {
            $criteria->add(new \Criteria('nleft', $cat->getVar('nleft'), '<='));
            $criteria->add(new \Criteria('nright', $cat->getVar('nright'), '>='));
        //$query = sprintf('select * from %s where nleft <= %d and nright >= %d order by nlevel', $this->table, $node['nleft'], $node['nright']);
        } else {
            $criteria->add(new \Criteria('nleft', $cat->getVar('nleft'), '<'));
            $criteria->add(new \Criteria('nright', $cat->getVar('nright'), '>'));
            //$query = sprintf('select * from %s where nleft < %d and nright > %d order by nlevel', $this->table, $node['nleft'], $node['nright']);
        }
        $criteria->add($this->getCatRestrictCriteria());
        $criteria->add($this->getCatRestrictCriteria('public_displayed'));
        $criteria->setSort('nlevel');

        return $this->getObjects($criteria);
    }

    /**
     * @return array
     */
    public function getTree()
    {
        return $this->getDescendants(0, false, false, false);
    }

    /**
     * @param int  $id
     * @param bool $includeSelf
     *
     * @return array
     */
    public function getChildren($id = 0, $includeSelf = false)
    {
        return $this->getDescendants($id, $includeSelf, true);
    }

    /**
     * @param int $id
     *
     * @return int
     */
    public function nbAlbum($id = 0)
    {
        $criteria = new \CriteriaCompo(new \Criteria('nright - nleft', 1));
        //$query = sprintf('select count(*) as num_leef from %s where nright - nleft = 1', $this->table);
        if (0 != $id) {
            $cat = $this->get($id);
            $criteria->add(new \Criteria('nleft', $cat->getVar('nleft'), '>'));
            $criteria->add(new \Criteria('nright', $cat->getVar('nright'), '<'));
            //$query .= sprintf(' AND nleft > %d AND nright < %d', $node['nleft'], $node['nright']);
        }

        return $this->getCount($criteria);
    }

    /**
     * @param        $name
     * @param        $selectMode
     * @param bool   $addEmpty
     * @param int    $selected
     * @param string $extra
     * @param bool   $displayWeight
     * @param string $permType
     *
     * @return string
     */
    public function getSelect(
        $name,
        $selectMode,
        $addEmpty = false,
        $selected = 0,
        $extra = '',
        $displayWeight = false,
        $permType = 'public_access'
    ) {
        $cats = $this->getDescendants(0, false, false, true, $permType);

        return $this->makeSelect($cats, $name, $selectMode, $addEmpty, $selected, $extra, $displayWeight);
    }

    /**
     * @param        $name
     * @param bool   $addEmpty
     * @param int    $selected
     * @param string $extra
     * @param string $permType
     *
     * @return string
     */
    public function getLeafSelect($name, $addEmpty = false, $selected = 0, $extra = '', $permType = 'public_access')
    {
        return $this->getSelect($name, 'node', $addEmpty, $selected, $extra, false, $permType);
    }

    /**
     * @param        $name
     * @param bool   $addEmpty
     * @param int    $selected
     * @param string $extra
     *
     * @return string
     */
    public function getNodeSelect($name, $addEmpty = false, $selected = 0, $extra = '')
    {
        return $this->getSelect($name, 'leaf', $addEmpty, $selected, $extra);
    }

    /**
     * @param array  $cats
     * @param string $name
     * @param string $selectMode
     * @param        $addEmpty
     * @param        $selected
     * @param        $extra
     * @param        $displayWeight
     *
     * @return string
     */
    public function makeSelect($cats, $name, $selectMode, $addEmpty, $selected, $extra, $displayWeight)
    {
        $ret = '<select name="' . $name . '" id="' . $name . '"' . $extra . '>';
        if ($addEmpty) {
            $ret .= '<option value="0">-----</option>';
        }
        /** @var Extgallery\Category $cat */
        foreach ($cats as $cat) {
            $disableOption = '';
            if ('node' === $selectMode && (1 != $cat->getVar('nright') - $cat->getVar('nleft'))) {
                // If the brownser is IE the parent cat isn't displayed
                //                if (preg_match('`MSIE`', $_SERVER['HTTP_USER_AGENT'])) {
                if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
                    continue;
                }
                $disableOption = ' disabled="disabled"';
            } elseif ('leaf' === $selectMode && (1 == $cat->getVar('cat_isalbum'))) {
                continue;
            }

            $selectedOption = '';
            if ($cat->getVar('cat_id') == $selected) {
                $selectedOption = ' selected';
            }

            $prefix = '';
            for ($i = 0; $i < $cat->getVar('nlevel') - 1; ++$i) {
                $prefix .= '--';
            }
            $catName = $prefix . ' ' . $cat->getVar('cat_name');
            if ($displayWeight) {
                $catName .= ' [' . $cat->getVar('cat_weight') . ']';
            }

            $ret .= '<option value="' . $cat->getVar('cat_id') . '"' . $selectedOption . '' . $disableOption . '>' . $catName . '</option>';
        }
        $ret .= '</select>';

        return $ret;
    }

    /**
     * @param array $selected
     *
     * @return string
     */
    public function getBlockSelect($selected = [])
    {
        $cats           = $this->getDescendants();
        $ret            = '<select name="options[]" multiple="multiple">';
        $selectedOption = '';
        if ($allCat = in_array(0, $selected)) {
            $selectedOption = ' selected';
        }
        $ret .= '<option value="0"' . $selectedOption . '>' . _MB_EXTGALLERY_ALL_CATEGORIES . '</option>';
        foreach ($cats as $cat) {
            $prefix = '';
            for ($i = 0; $i < $cat->getVar('nlevel') - 1; ++$i) {
                $prefix .= '-';
            }
            $selectedOption = '';
            $disableOption  = '';

            if (!$allCat && in_array($cat->getVar('cat_id'), $selected)) {
                $selectedOption = ' selected';
            }

            if (1 != $cat->getVar('nright') - $cat->getVar('nleft')) {
                $disableOption = ' disabled="disabled"';
            }

            $ret .= '<option value="' . $cat->getVar('cat_id') . '"' . $selectedOption . '' . $disableOption . '>' . $prefix . ' ' . $cat->getVar('cat_name') . '</option>';
        }
        $ret .= '</select>';

        return $ret;
    }

    /**
     * @return array
     */
    public function getTreeWithChildren()
    {
        $criteria = new \CriteriaCompo();
        $criteria->setSort('cat_weight, cat_name');
        //$query = sprintf('select * from %s order by %s', $this->table, $this->fields['sort']);

        //$result = $this->db->query($query);
        $categories =& $this->getObjects($criteria, false, false);

        // create a root node to hold child data about first level items
        $root             = [];
        $root['cat_id']   = 0;
        $root['children'] = [];

        $arr = [
            $root
        ];

        // populate the array and create an empty children array
        /*while (false !== ($row = $this->db->fetchArray($result))) {
            $arr[$row[$this->fields['id']]] = $row;
            $arr[$row[$this->fields['id']]]['children'] = array ();
        }*/
        foreach ($categories as $row) {
            $arr[$row['cat_id']]             = $row;
            $arr[$row['cat_id']]['children'] = [];
        }

        // now process the array and build the child data
        foreach ($arr as $id => $row) {
            if (isset($row['cat_pid'])) {
                $arr[$row['cat_pid']]['children'][$id] = $id;
            }
        }

        return $arr;
    }

    /**
     * Rebuilds the tree data and saves it to the database
     */
    public function rebuild()
    {
        $data = $this->getTreeWithChildren();

        $n     = 0; // need a variable to hold the running n tally
        $level = 0; // need a variable to hold the running level tally

        // invoke the recursive function. Start it processing
        // on the fake "root node" generated in getTreeWithChildren().
        // because this node doesn't really exist in the database, we
        // give it an initial nleft value of 0 and an nlevel of 0.
        $this->_generateTreeData($data, 0, 0, $n);
        //echo "<pre>";print_r($data);echo "</pre>";
        // at this point the root node will have nleft of 0, nlevel of 0
        // and nright of (tree size * 2 + 1)

        // Errase category and photo counter
        $query = sprintf('UPDATE `%s` SET cat_nb_album = 0, cat_nb_photo = 0;', $this->table);
        $this->db->queryF($query);

        foreach ($data as $id => $row) {

            // skip the root node
            if (0 == $id) {
                continue;
            }

            // Update the photo number
            if (1 == $row['nright'] - $row['nleft']) {
                // Get the number of photo in this album
                $criteria = new \CriteriaCompo();
                $criteria->add(new \Criteria('cat_id', $id));
                $criteria->add(new \Criteria('photo_approved', 1));
                /** @var Extgallery\CategoryHandler $this ->_photoHandler */
                $nbPhoto = $this->_photoHandler->getCount($criteria);

                // Update all parent of this album
                $upNbAlbum = '';
                if (0 != $nbPhoto) {
                    $upNbAlbum = 'cat_nb_album = cat_nb_album + 1, ';
                }
                $sql   = 'UPDATE `%s` SET ' . $upNbAlbum . 'cat_nb_photo = cat_nb_photo + %d WHERE nleft < %d AND nright > %d;';
                $query = sprintf($sql, $this->table, $nbPhoto, $row['nleft'], $row['nright']);
                $this->db->queryF($query);

                // Update this album if needed
                if (0 != $nbPhoto) {
                    $sql   = 'UPDATE `%s`SET cat_nb_photo = %d WHERE `%s` = %d';
                    $query = sprintf($sql, $this->table, $nbPhoto, $this->keyName, $id);
                    $this->db->queryF($query);
                }
            }

            $query = sprintf('UPDATE `%s`SET nlevel = %d, nleft = %d, nright = %d WHERE `%s` = %d;', $this->table, $row['nlevel'], $row['nleft'], $row['nright'], $this->keyName, $id);
            $this->db->queryF($query);
        }
    }

    /**
     * Generate the tree data. A single call to this generates the n-values for
     * 1 node in the tree. This function assigns the passed in n value as the
     * node's nleft value. It then processes all the node's children (which
     * in turn recursively processes that node's children and so on), and when
     * it is finally done, it takes the update n-value and assigns it as its
     * nright value. Because it is passed as a reference, the subsequent changes
     * in subrequests are held over to when control is returned so the nright
     * can be assigned.
     *
     * @param array &$arr  A reference to the data array, since we need to
     *                     be able to update the data in it
     * @param int   $id    The ID of the current node to process
     * @param int   $level The nlevel to assign to the current node
     * @param int   &$n    A reference to the running tally for the n-value
     */
    public function _generateTreeData(&$arr, $id, $level, &$n)
    {
        $arr[$id]['nlevel'] = $level;
        $arr[$id]['nleft']  = ++$n;

        // loop over the node's children and process their data
        // before assigning the nright value
        foreach ($arr[$id]['children'] as $child_id) {
            $this->_generateTreeData($arr, $child_id, $level + 1, $n);
        }
        $arr[$id]['nright'] = ++$n;
    }

    /**
     * @param string $permType
     *
     * @return bool|\Criteria
     */
    public function getCatRestrictCriteria($permType = 'public_access')
    {
        if (null !== $GLOBALS['xoopsUser'] && is_object($GLOBALS['xoopsUser'])) {
            $permHandler       = $this->getPermHandler();
            $allowedCategories = $permHandler->getAuthorizedPublicCat($GLOBALS['xoopsUser'], $permType);

            $count = count($allowedCategories);
            if ($count > 0) {
                $in = '(' . $allowedCategories[0];
                array_shift($allowedCategories);
                foreach ($allowedCategories as $allowedCategory) {
                    $in .= ',' . $allowedCategory;
                }
                $in       .= ')';
                $criteria = new \Criteria('cat_id', $in, 'IN');
            } else {
                $criteria = new \Criteria('cat_id', '(0)', 'IN');
            }

            return $criteria;
        }
        return false;
    }

    /**
     * @return Extgallery\PublicPermHandler
     */
    public function getPermHandler()
    {
        return Extgallery\PublicPermHandler::getInstance();
    }
}
