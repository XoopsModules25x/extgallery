<?php
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
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 * @version     $Id: catHandler.php 8088 2011-11-06 09:38:12Z beckmi $
 */

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once 'publicPerm.php';
include_once 'ExtgalleryPersistableObjectHandler.php';

class ExtgalleryCat extends XoopsObject
{

	var $externalKey = array();

	function ExtgalleryCat()
	{
		$this->initVar('cat_id', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('cat_pid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('nleft', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('nright', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('nlevel', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('cat_name', XOBJ_DTYPE_TXTBOX, '', true, 255);
		$this->initVar('cat_desc', XOBJ_DTYPE_TXTAREA, '', false);
		$this->initVar('cat_date', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('cat_isalbum', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('cat_weight', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('cat_nb_album', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('cat_nb_photo', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('cat_imgurl', XOBJ_DTYPE_URL, '', false, 150);
		$this->initVar('photo_id', XOBJ_DTYPE_INT, 0, false);

		$this->externalKey['photo_id'] = array('className'=>'publicphoto', 'getMethodeName'=>'getPhoto', 'keyName'=>'photo', 'core'=>false);
	}

	function getExternalKey($key) {
		return $this->externalKey[$key];
	}

}

class ExtgalleryCatHandler extends ExtgalleryPersistableObjectHandler {

	//var $_nestedTree;
	var $_photoHandler;

	function ExtgalleryCatHandler(&$db, $type)
	{
		$this->ExtgalleryPersistableObjectHandler($db, 'extgallery_'.$type.'cat', 'Extgallery'.ucfirst($type).'cat', 'cat_id');
		//$this->_nestedTree = new NestedTree($db, 'extgallery_'.$type.'cat', 'cat_id', 'cat_pid', 'cat_id');
		$this->_photoHandler = xoops_getmodulehandler($type.'photo', 'extgallery');
	}

	function createCat($data) {
		$cat = $this->create();
		$cat->setVars($data);

		if(!$this->_haveValidParent($cat)) {
			return false;
		}

		$this->insert($cat,true);
		$this->rebuild();
	}

	function modifyCat($data) {
		$cat = $this->get($data['cat_id']);
		$cat->setVars($data);

		if(!$this->_haveValidParent($cat)) {
			return false;
		}
		$this->insert($cat, true);

		// Rebluid the tree only if the structure is modified
		if(isset($data['cat_pid']) || isset($data['nlevel']) || isset($data['nright']) || isset($data['nleft']))
			$this->rebuild();
	}

	function deleteCat($catId) {
		$children = $this->getDescendants($catId, false, true);
		foreach($children as $child) {
			$this->_photoHandler->deletePhotoByCat($child->getVar('cat_id'));
			$this->deleteCat($child->getVar('cat_id'));
		}
		$this->_photoHandler->deletePhotoByCat($catId);
		$this->delete($catId);
	}

	function getDescendants($id = 0, $includeSelf = false, $childrenOnly = false, $withRestrict = true, $permType = "public_access") {

		$cat = $this->get($id);

		$nleft = $cat->getVar('nleft');
		$nright = $cat->getVar('nright');
		$parent_id = $cat->getVar('cat_id');

		$criteria = new CriteriaCompo();

		if ($childrenOnly) {
			$criteria->add(new Criteria('cat_pid',$parent_id),'OR');
			if($includeSelf) {
				$criteria->add(new Criteria('cat_id',$parent_id));
				//$query = sprintf('select * from %s where %s = %d or %s = %d order by nleft', $this->table, $this->fields['id'], $parent_id, $this->fields['parent'], $parent_id);
			}/* else {
				//$query = sprintf('select * from %s where %s = %d order by nleft', $this->table, $this->fields['parent'], $parent_id);
			}*/
		} else {
			if($nleft > 0 && $includeSelf) {
				$criteria->add(new Criteria('nleft',$nleft,'>='));
				$criteria->add(new Criteria('nright',$nright,'<='));
				//$query = sprintf('select * from %s where nleft >= %d and nright <= %d order by nleft', $this->table, $nleft, $nright);
			} else {
				if($nleft > 0) {
					$criteria->add(new Criteria('nleft',$nleft,'>'));
					$criteria->add(new Criteria('nright',$nright,'<'));
					//$query = sprintf('select * from %s where nleft > %d and nright < %d order by nleft', $this->table, $nleft, $nright);
				}/* else {
				$query = sprintf('select * from %s order by nleft', $this->table);
				}*/
			}
		}
		if($withRestrict) {
			$criteria->add($this->getCatRestrictCriteria($permType));
			$criteria->add($this->getCatRestrictCriteria('public_displayed'));
		}
		$criteria->setSort('nleft');

		return $this->getObjects($criteria);
	}

	function getCat($id = 0) {
		$criteria = new CriteriaCompo();
		$criteria->add($this->getCatRestrictCriteria('public_displayed'));
		$criteria->add(new Criteria('cat_id', $id));
		$ret = $this->getObjects($criteria);

		if(count($ret) > 0) {
			return $ret[0];
		} else {
			return NULL;
		}

	}

	function _haveValidParent() {
		exit("_haveValidParent() method must be defined on sub classes");
	}

	function _isAlbum(&$cat) {
		$nbPhoto = $this->nbPhoto($cat);
		return $nbPhoto != 0;
	}

	function nbPhoto(&$cat) {
		return $this->_photoHandler->nbPhoto($cat);
	}

	function getPath($id = 0, $includeSelf = false) {
		$cat = $this->get($id);
		if(is_null($cat))
		return array();

		$criteria = new CriteriaCompo();
		if($includeSelf) {
			$criteria->add(new Criteria('nleft',$cat->getVar('nleft'),'<='));
			$criteria->add(new Criteria('nright',$cat->getVar('nright'),'>='));
			//$query = sprintf('select * from %s where nleft <= %d and nright >= %d order by nlevel', $this->table, $node['nleft'], $node['nright']);
		} else {
			$criteria->add(new Criteria('nleft',$cat->getVar('nleft'),'<'));
			$criteria->add(new Criteria('nright',$cat->getVar('nright'),'>'));
			//$query = sprintf('select * from %s where nleft < %d and nright > %d order by nlevel', $this->table, $node['nleft'], $node['nright']);
		}
		$criteria->add($this->getCatRestrictCriteria());
		$criteria->add($this->getCatRestrictCriteria('public_displayed'));
		$criteria->setSort('nlevel');

		return $this->getObjects($criteria);
	}

	function getTree() {
		return $this->getDescendants(0, false, false, false);
	}

	function getChildren($id = 0, $includeSelf = false) {
		return $this->getDescendants($id, $includeSelf, true);
	}

	function nbAlbum($id = 0) {
		$criteria = new CriteriaCompo(new Criteria('nright - nleft',1));
		//$query = sprintf('select count(*) as num_leef from %s where nright - nleft = 1', $this->table);
		if($id != 0) {
			$cat = $this->get($id);
			$criteria->add(new Criteria('nleft',$cat->getVar('nleft'),'>'));
			$criteria->add(new Criteria('nright',$cat->getVar('nright'),'<'));
			//$query .= sprintf(' AND nleft > %d AND nright < %d', $node['nleft'], $node['nright']);
		}
		return $this->getCount($criteria);
	}

	function getSelect($name, $selectMode, $addEmpty = false, $selected = 0, $extra = "", $displayWeight = false, $permType = "public_access") {
		$cats = $this->getDescendants(0, false, false, true, $permType);
		return $this->makeSelect($cats, $name, $selectMode, $addEmpty, $selected, $extra, $displayWeight);
	}

	function getLeafSelect($name, $addEmpty = false, $selected = 0, $extra = "", $permType = "public_access") {
		return $this->getSelect($name, 'node', $addEmpty, $selected, $extra, false, $permType);
	}

	function getNodeSelect($name, $addEmpty = false, $selected = 0, $extra = "") {
		return $this->getSelect($name, 'leaf', $addEmpty, $selected, $extra);
	}

	function makeSelect(&$cats, $name, $selectMode, $addEmpty, $selected, $extra, $displayWeight) {
		$ret = '<select name="'.$name.'" id="'.$name.'"'.$extra.'>';
		if($addEmpty) {
			$ret .= '<option value="0">-----</option>';
		}
		foreach($cats as $cat) {

			$disableOption = "";
			if($selectMode == 'node' && ($cat->getVar('nright') - $cat->getVar('nleft') != 1)) {
				// If the brownser is IE the parent cat isn't displayed
				if(preg_match('`MSIE`',$_SERVER['HTTP_USER_AGENT']))
					continue;
				$disableOption = ' disabled="disabled"';
			} else if($selectMode == 'leaf' && ($cat->getVar('cat_isalbum') == 1)) {
				continue;
			}

			$selectedOption = "";
			if($cat->getVar('cat_id') == $selected) {
				$selectedOption = ' selected="selected"';
			}

			$prefix = "";
			for($i=0 ; $i < $cat->getVar('nlevel')-1 ; $i++) {
				$prefix .= "--";
			}
			$catName = $prefix.' '.$cat->getVar('cat_name');
			if($displayWeight)
				$catName .= ' ['.$cat->getVar('cat_weight').']';

			$ret .= '<option value="'.$cat->getVar('cat_id').'"'.$selectedOption.''.$disableOption.'>'.$catName.'</option>';
		}
		$ret .= '</select>';
		return $ret;
	}

	function getBlockSelect($selected = array()) {
		$cats = $this->getDescendants();
		$ret = '<select name="options[]" multiple="multiple">';
		$selectedOption = "";
		if($allCat = in_array(0, $selected)) {
			$selectedOption = ' selected="selected"';
		}
		$ret .= '<option value="0"'.$selectedOption.'>'._MB_EXTGALLERY_ALL_CATEGORIES.'</option>';
		foreach($cats as $cat) {
			$prefix = "";
			for($i=0 ; $i < $cat->getVar('nlevel')-1 ; $i++) {
				$prefix .= "-";
			}
			$selectedOption = "";
			$disableOption = "";

			if(!$allCat && in_array($cat->getVar('cat_id'), $selected)) {
				$selectedOption = ' selected="selected"';
			}

			if($cat->getVar('nright') - $cat->getVar('nleft') != 1) {
				$disableOption = ' disabled="disabled"';
			}

			$ret .= '<option value="'.$cat->getVar('cat_id').'"'.$selectedOption.''.$disableOption.'>'.$prefix.' '.$cat->getVar('cat_name').'</option>';
		}
		$ret .= '</select>';
		return $ret;
	}

	function getTreeWithChildren() {

		$criteria = new CriteriaCompo();
		$criteria->setSort('cat_weight, cat_name');
		//$query = sprintf('select * from %s order by %s', $this->table, $this->fields['sort']);

		//$result = $this->db->query($query);
		$categories = $this->getObjects($criteria, false, false);

		// create a root node to hold child data about first level items
		$root = array();
		$root['cat_id'] = 0;
		$root['children'] = array ();

		$arr = array (
			$root
		);

		// populate the array and create an empty children array
		/*while ($row = $this->db->fetchArray($result)) {
			$arr[$row[$this->fields['id']]] = $row;
			$arr[$row[$this->fields['id']]]['children'] = array ();
		}*/
		foreach($categories as $row) {
			$arr[$row['cat_id']] = $row;
			$arr[$row['cat_id']]['children'] = array ();
		}

		// now process the array and build the child data
		foreach ($arr as $id => $row) {
			if (isset ($row['cat_pid']))
				$arr[$row['cat_pid']]['children'][$id] = $id;
		}

		return $arr;
	}

	/**
	* Rebuilds the tree data and saves it to the database
	*/
	function rebuild() {
		$data = $this->getTreeWithChildren();

		$n = 0; // need a variable to hold the running n tally
		$level = 0; // need a variable to hold the running level tally

		// invoke the recursive function. Start it processing
		// on the fake "root node" generated in getTreeWithChildren().
		// because this node doesn't really exist in the database, we
		// give it an initial nleft value of 0 and an nlevel of 0.
		$this->_generateTreeData($data, 0, 0, $n);
		//echo "<pre>";print_r($data);echo "</pre>";
		// at this point the the root node will have nleft of 0, nlevel of 0
		// and nright of (tree size * 2 + 1)

		// Errase category and photo counter
		$query = sprintf('UPDATE %s SET cat_nb_album = 0, cat_nb_photo = 0;', $this->table);
		$this->db->queryF($query);

		foreach ($data as $id => $row) {

			// skip the root node
			if ($id == 0)
				continue;

			// Update the photo number
			if($row['nright'] - $row['nleft'] == 1) {
				// Get the number of photo in this album
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('cat_id',$id));
				$criteria->add(new Criteria('photo_approved',1));
				$nbPhoto = $this->_photoHandler->getCount($criteria);

				// Update all parent of this album
				$upNbAlbum = '';
				if($nbPhoto != 0)
					$upNbAlbum = 'cat_nb_album = cat_nb_album + 1, ';
				$sql = 'UPDATE %s SET '.$upNbAlbum.'cat_nb_photo = cat_nb_photo + %d WHERE nleft < %d AND nright > %d;';
				$query = sprintf($sql, $this->table, $nbPhoto, $row['nleft'], $row['nright']);
				$this->db->queryF($query);

				// Update this album if needed
				if($nbPhoto != 0) {
					$sql = 'UPDATE %s SET cat_nb_photo = %d WHERE %s = %d';
					$query = sprintf($sql, $this->table, $nbPhoto, $this->keyName, $id);
					$this->db->queryF($query);
				}
			}

			$query = sprintf('UPDATE %s SET nlevel = %d, nleft = %d, nright = %d WHERE %s = %d;', $this->table, $row['nlevel'], $row['nleft'], $row['nright'], $this->keyName, $id);
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
	* @param   array   &$arr   A reference to the data array, since we need to
	*                          be able to update the data in it
	* @param   int     $id     The ID of the current node to process
	* @param   int     $level  The nlevel to assign to the current node
	* @param   int     &$n     A reference to the running tally for the n-value
	*/
	function _generateTreeData(&$arr, $id, $level, &$n) {
		$arr[$id]['nlevel'] = $level;
		$arr[$id]['nleft'] = $n++;

		// loop over the node's children and process their data
		// before assigning the nright value
		foreach ($arr[$id]['children'] as $child_id) {
			$this->_generateTreeData($arr, $child_id, $level +1, $n);
		}
		$arr[$id]['nright'] = $n++;
	}

	function &getCatRestrictCriteria($permType = "public_access") {

		$permHandler = $this->_getPermHandler();
		$allowedCategories = $permHandler->getAuthorizedPublicCat($GLOBALS['xoopsUser'], $permType);

		$count = count($allowedCategories);
		if($count > 0) {
			$in = '('.$allowedCategories[0];
			array_shift($allowedCategories);
			foreach($allowedCategories as $allowedCategory) {
				$in .= ','.$allowedCategory;
			}
			$in .= ')';
			$criteria = new Criteria('cat_id', $in, 'IN');
		} else {
			$criteria = new Criteria('cat_id', '(0)', 'IN');
		}
		return $criteria;
	}

}

?>