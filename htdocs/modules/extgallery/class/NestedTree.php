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
 * @version     $Id: NestedTree.php 8088 2011-11-06 09:38:12Z beckmi $
 */

class NestedTree {

	var $db;
	var $table;
	var $fields;


	/**
	 * Constructor. Set the database table name and necessary field names
	 *
	 * @param   string  $table          Name of the tree database table
	 * @param   string  $idField        Name of the primary key ID field
	 * @param   string  $parentField    Name of the parent ID field
	 * @param   string  $sortField      Name of the field to sort data.
	 */
	function NestedTree(&$db, $table, $idField, $parentField, $sortField) {
		$this->db = $db;
		$this->table = $db->prefix($table);
		$this->fields = array (
			'id' => $idField,
			'parent' => $parentField,
			'sort' => $sortField
		);
	}

	/**
	* Fetch the node data for the node identified by $id
	*
	* @param   int     $id     The ID of the node to fetch
	* @return  object          An object containing the node's
	*                          data, or null if node not found
	*/
	function getNode($id) {
		$query = sprintf('select * from %s where %s = %d', $this->table, $this->fields['id'], $id);

		$result = $this->db->query($query);
		if ($row = $this->db->fetchArray($result)) {
			return $row;
		}
		return null;
	}

	/**
	* Fetch the descendants of a node, or if no node is specified, fetch the
	* entire tree. Optionally, only return child data instead of all descendant
	* data.
	*
	* @param   int     $id             The ID of the node to fetch descendant data for.
	*                                  Specify an invalid ID (e.g. 0) to retrieve all data.
	* @param   bool    $includeSelf    Whether or not to include the passed node in the
	*                                  the results. This has no meaning if fetching entire tree.
	* @param   bool    $childrenOnly   True if only returning children data. False if
	*                                  returning all descendant data
	* @return  array                   The descendants of the passed now
	*/
	function getDescendants($id = 0, $includeSelf = false, $childrenOnly = false) {
		$idField = $this->fields['id'];

		$node = $this->getNode($id);
		if (is_null($node)) {
			$nleft = 0;
			$nright = 0;
			$parent_id = 0;
		} else {
			$nleft = $node['nleft'];
			$nright = $node['nright'];
			$parent_id = $node[$this->fields['id']];
		}

		if ($childrenOnly) {
			if ($includeSelf) {
				$query = sprintf('select * from %s where %s = %d or %s = %d order by nleft', $this->table, $this->fields['id'], $parent_id, $this->fields['parent'], $parent_id);
			} else {
				$query = sprintf('select * from %s where %s = %d order by nleft', $this->table, $this->fields['parent'], $parent_id);
			}
		} else {
			if ($nleft > 0 && $includeSelf) {
				$query = sprintf('select * from %s where nleft >= %d and nright <= %d order by nleft', $this->table, $nleft, $nright);
			} else {
				if ($nleft > 0) {
					$query = sprintf('select * from %s where nleft > %d and nright < %d order by nleft', $this->table, $nleft, $nright);
				} else {
					$query = sprintf('select * from %s order by nleft', $this->table);
				}
			}
		}

		$result = $this->db->query($query);

		$arr = array ();
		while ($row = $this->db->fetchArray($result)) {
			$arr[$row[$idField]] = $row;
		}

		return $arr;
	}

	/**
	* Fetch the children of a node, or if no node is specified, fetch the
	* top level items.
	*
	* @param   int     $id             The ID of the node to fetch child data for.
	* @param   bool    $includeSelf    Whether or not to include the passed node in the
	*                                  the results.
	* @return  array                   The children of the passed node
	*/
	function getChildren($id = 0, $includeSelf = false) {
		return $this->getDescendants($id, $includeSelf, true);
	}

	/**
	* Fetch the path to a node. If an invalid node is passed, an empty array is returned.
	* If a top level node is passed, an array containing on that node is included (if
	* 'includeSelf' is set to true, otherwise an empty array)
	*
	* @param   int     $id             The ID of the node to fetch child data for.
	* @param   bool    $includeSelf    Whether or not to include the passed node in the
	*                                  the results.
	* @return  array                   An array of each node to passed node
	*/
	function getPath($id = 0, $includeSelf = false) {
		$node = $this->getNode($id);
		if (is_null($node))
			return array ();

		if ($includeSelf) {
			$query = sprintf('select * from %s where nleft <= %d and nright >= %d order by nlevel', $this->table, $node['nleft'], $node['nright']);
		} else {
			$query = sprintf('select * from %s where nleft < %d and nright > %d order by nlevel', $this->table, $node['nleft'], $node['nright']);
		}

		$result = $this->db->query($query);

		$idField = $this->fields['id'];
		$arr = array ();
		while ($row = $this->db->fetchArray($result)) {
			$arr[$row[$idField]] = $row;
		}

		return $arr;
	}

	/**
	* Check if one node descends from another node. If either node is not
	* found, then false is returned.
	*
	* @param   int     $descendant_id  The node that potentially descends
	* @param   int     $ancestor_id    The node that is potentially descended from
	* @return  bool                    True if $descendant_id descends from $ancestor_id, false otherwise
	*/
	function isDescendantOf($descendant_id, $ancestor_id) {
		$node = $this->getNode($ancestor_id);
		if (is_null($node))
			return false;

		$query = sprintf('select count(*) as is_descendant
		                              from %s
		                              where %s = %d
		                              and nleft > %d
		                              and nright < %d', $this->table, $this->fields['id'], $descendant_id, $node->nleft, $node->nright);

		$result = $this->db->query($query);

		if ($row = $this->db->fetchArray($result)) {
			return $row['is_descendant'] > 0;
		}

		return false;
	}

	/**
	* Check if one node is a child of another node. If either node is not
	* found, then false is returned.
	*
	* @param   int     $child_id       The node that is possibly a child
	* @param   int     $parent_id      The node that is possibly a parent
	* @return  bool                    True if $child_id is a child of $parent_id, false otherwise
	*/
	function isChildOf($child_id, $parent_id) {
		$query = sprintf('select count(*) as is_child from %s where %s = %d and %s = %d', $this->table, $this->fields['id'], $child_id, $this->fields['parent'], $parent_id);

		$result = $this->db->query($query);

		if ($row = $this->db->fetchArray($result)) {
			return $row['is_child'] > 0;
		}

		return false;
	}

	/**
	* Find the number of descendants a node has
	*
	* @param   int     $id     The ID of the node to search for. Pass 0 to count all nodes in the tree.
	* @return  int             The number of descendants the node has, or -1 if the node isn't found.
	*/
	function numDescendants($id) {
		if ($id == 0) {
			$query = sprintf('select count(*) as num_descendants from %s', $this->table);
			$result = $this->db->query($query);
			if ($row = $this->db->fetchArray($result))
				return $row['num_descendants'];
		} else {
			$node = $this->getNode($id);
			if (!is_null($node)) {
				return ($node['nright'] - $node['nleft'] - 1) / 2;
			}
		}
		return -1;
	}

	/**
	* Find the number of children a node has
	*
	* @param   int     $id     The ID of the node to search for. Pass 0 to count the first level items
	* @return  int             The number of descendants the node has, or -1 if the node isn't found.
	*/
	function numChildren($id) {
		$query = sprintf('select count(*) as num_children from %s where %s = %d', $this->table, $this->fields['parent'], $id);
		$result = $this->db->query($query);
		if ($row = $this->db->fetchArray($result))
			return $row['num_children'];

		return -1;
	}
	
	function numLeef($id) {
		$query = sprintf('select count(*) as num_leef from %s where nright - nleft = 1', $this->table);
		if($id != 0) {
                       $node = $this->getNode($id);
                       $query .= sprintf(' AND nleft > %d AND nright < %d', $node['nleft'], $node['nright']);
                  }
		$result = $this->db->query($query);
		if ($row = $this->db->fetchArray($result))
			return $row['num_leef'];

		return -1;
	}

	/**
	* Fetch the tree data, nesting within each node references to the node's children
	*
	* @return  array       The tree with the node's child data
	*/
	function getTreeWithChildren() {
		$idField = $this->fields['id'];
		$parentField = $this->fields['parent'];

		$query = sprintf('select * from %s order by %s', $this->table, $this->fields['sort']);

		$result = $this->db->query($query);

		// create a root node to hold child data about first level items
		$root = array();
		$root[$this->fields['id']] = 0;
		$root['children'] = array ();

		$arr = array (
			$root
		);

		// populate the array and create an empty children array
		while ($row = $this->db->fetchArray($result)) {
			$arr[$row[$this->fields['id']]] = $row;
			$arr[$row[$this->fields['id']]]['children'] = array ();
		}

		// now process the array and build the child data
		foreach ($arr as $id => $row) {
			if (isset ($row[$this->fields['parent']]))
				$arr[$row[$this->fields['parent']]]['children'][$id] = $id;
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

		foreach ($data as $id => $row) {

			// skip the root node
			if ($id == 0)
				continue;
			
			$query = sprintf('update %s set nlevel = %d, nleft = %d, nright = %d where %s = %d', $this->table, $row['nlevel'], $row['nleft'], $row['nright'], $this->fields['id'], $id);
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
	function _generateTreeData(& $arr, $id, $level, & $n) {
		$arr[$id]['nlevel'] = $level;
		$arr[$id]['nleft'] = $n++;

		// loop over the node's children and process their data
		// before assigning the nright value
		foreach ($arr[$id]['children'] as $child_id) {
			$this->_generateTreeData($arr, $child_id, $level +1, $n);
		}
		$arr[$id]['nright'] = $n++;
	}
}

?>