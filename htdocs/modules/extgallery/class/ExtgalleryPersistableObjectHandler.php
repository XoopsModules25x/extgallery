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
 * @copyright   {@link http://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 * @version     $Id: ExtgalleryPersistableObjectHandler.php 8088 2011-11-06 09:38:12Z beckmi $
 */

/**
 * Persistable Object Handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of derived class objects.
 *
 * @author    Jan Keller Pedersen <mithrandir@xoops.org> - IDG Danmark A/S <www.idg.dk>
 * @copyright copyright (c) 2000-2004 XOOPS.org
 * @package   Kernel
 */
class ExtgalleryPersistableObjectHandler extends XoopsObjectHandler //XoopsPersistableObjectHandler
{
    /**#@+
     * Information about the class, the handler is managing
     *
     * @var string
     */
    public $table;
    public $keyName;
    public $className;
    public $identifierName;
    /**#@-*/

    /**
     * Constructor - called from child classes
     *
     * @param XoopsDatabase $db        {@link XoopsDatabase}
     *                                 object
     * @param string $tablename        Name of database table
     * @param string $classname        Name of Class, this handler is managing
     * @param string $keyname          Name of the property, holding the key
     *
     * @param bool $idenfierName
     *
     */
    public function __construct(XoopsDatabase $db, $tablename, $classname, $keyname, $idenfierName = false)
    {
        parent::__construct($db);
        //        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->table     = $db->prefix($tablename);
        $this->keyName   = $keyname;
        $this->className = $classname;
        if ($idenfierName != false) {
            $this->identifierName = $idenfierName;
        }
    }


    /**
     * create a new user
     *
     * @param bool $isNew Flag the new objects as "new"?
     *
     * @return XoopsObject
     */
    /* function &create($isNew = true) {
        //DNPROSSI - 5.3.0 Assigning the return value of new by reference is deprecated PHP 5.3
        //Kept for backward compatability
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            $obj = new $this->className();
        } else {
            $obj = new $this->className();
        }
        if ($isNew === true) {
            $obj->setNew();
        }

        return $obj;
    } */

    public function create($isNew = true)
    {
        $obj = new $this->className();
        if ($isNew === true) {
            $obj->setNew();
        }

        return $obj;
    }

    /**
     * retrieve an object
     *
     * @param  mixed $id       ID of the object - or array of ids for joint keys. Joint keys MUST be given in the same order as in the constructor
     * @param  bool $as_object whether to return an object or an array
     * @return mixed reference to the object, FALSE if failed
     */
    public function get($id, $as_object = true)
    {
        if (is_array($this->keyName)) {
            $criteria = new CriteriaCompo();
            for ($i = 0; $i < count($this->keyName); ++$i) {
                $criteria->add(new Criteria($this->keyName[$i], (int)$id[$i]));
            }
        } else {
            $criteria = new Criteria($this->keyName, (int)$id);
        }
        $criteria->setLimit(1);
        $obj_array =& $this->getObjects($criteria, false, $as_object);
        if (count($obj_array) != 1) {
            return $this->create();
        }

        return $obj_array[0];
    }

    /**
     * retrieve objects from the database
     *
     * @param CriteriaElement $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key           use the ID as key for the array?
     * @param bool $as_object           return an array of objects?
     *
     * @return array
     */
    public function &getObjects(CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret   = array();
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }

        $ret = $this->convertResultSet($result, $id_as_key, $as_object);

        return $ret;
    }

    /**
     * Convert a database resultset to a returnable array
     *
     * @param XoopsObject $result database resultset
     * @param bool $id_as_key     - should NOT be used with joint keys
     * @param bool $as_object
     *
     * @return array
     */
    public function convertResultSet($result, $id_as_key = false, $as_object = true)
    {
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $obj = $this->create(false);
            $obj->assignVars($myrow);
            if (!$id_as_key) {
                if ($as_object) {
                    $ret[] =& $obj;
                } else {
                    $row  = array();
                    $vars =& $obj->getVars();
                    foreach (array_keys($vars) as $i) {
                        $row[$i] = $obj->getVar($i);
                    }
                    $ret[] = $row;
                }
            } else {
                if ($as_object) {
                    $ret[$myrow[$this->keyName]] =& $obj;
                } else {
                    $row  = array();
                    $vars = $obj->getVars();
                    foreach (array_keys($vars) as $i) {
                        $row[$i] = $obj->getVar($i);
                    }
                    $ret[$myrow[$this->keyName]] = $row;
                }
            }
            unset($obj);
        }

        return $ret;
    }

    /**
     * Retrieve a list of objects as arrays - DON'T USE WITH JOINT KEYS
     *
     * @param CriteriaElement $criteria {@link CriteriaElement} conditions to be met
     * @param int $limit                Max number of objects to fetch
     * @param int $start                Which record to start at
     *
     * @return array
     */
    public function getList(CriteriaElement $criteria = null, $limit = 0, $start = 0)
    {
        $ret = array();
        if ($criteria == null) {
            $criteria = new CriteriaCompo();
        }

        if ($criteria->getSort() == '') {
            $criteria->setSort($this->identifierName);
        }

        $sql = 'SELECT ' . $this->keyName;
        if (!empty($this->identifierName)) {
            $sql .= ', ' . $this->identifierName;
        }
        $sql .= ' FROM ' . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }

        $myts = MyTextSanitizer::getInstance();
        while ($myrow = $this->db->fetchArray($result)) {
            //identifiers should be textboxes, so sanitize them like that
            $ret[$myrow[$this->keyName]] = empty($this->identifierName) ? 1 : $myts->htmlSpecialChars($myrow[$this->identifierName]);
        }

        return $ret;
    }

    /**
     * count objects matching a condition
     *
     * @param  CriteriaElement $criteria {@link CriteriaElement} to match
     * @return int    count of objects
     */
    public function getCount(CriteriaElement $criteria = null)
    {
        $field   = '';
        $groupby = false;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            if ($criteria->groupby != '') {
                $groupby = true;
                $field   = $criteria->groupby . ', '; //Not entirely secure unless you KNOW that no criteria's groupby clause is going to be mis-used
            }
        }
        $sql = 'SELECT ' . $field . 'COUNT(*) FROM ' . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ($criteria->groupby != '') {
                $sql .= $criteria->getGroupby();
            }
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        if ($groupby == false) {
            list($count) = $this->db->fetchRow($result);

            return $count;
        } else {
            $ret = array();
            while (list($id, $count) = $this->db->fetchRow($result)) {
                $ret[$id] = $count;
            }

            return $ret;
        }
    }

    /**
     * delete an object from the database
     *
     * @param  XoopsObject $id id of the object to delete
     * @param  bool $force
     * @return bool  FALSE if failed.
     */
    public function delete(XoopsObject $id, $force = false)
    {
        if (is_array($this->keyName)) {
            $clause = array();
            for ($i = 0; $i < count($this->keyName); ++$i) {
                $clause[] = $this->keyName[$i] . ' = ' . $id[$i];
            }
            $whereclause = implode(' AND ', $clause);
        } else {
            $whereclause = $this->keyName . ' = ' . $id;
        }
        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $whereclause;
        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * insert a new object in the database
     *
     * @param  XoopsObject $obj  reference to the object
     * @param  bool $force       whether to force the query execution despite security settings
     * @param  bool $checkObject check if the object is dirty and clean the attributes
     * @return bool   FALSE if failed, TRUE if already present and unchanged or successful
     */

    public function insert(XoopsObject $obj, $force = false, $checkObject = true)
    {
        if ($checkObject != false) {
            if (!is_object($obj)) {
                var_dump($obj);

                return false;
            }
            //if (!is_a($obj, $this->className)) {
            //$obj->setErrors(get_class($obj) . ' Differs from ' . $this->className);

            if (!(class_exists($this->className) && $obj instanceof $this->className)) {
                $obj->setErrors(get_class($obj) . ' Differs from ' . $this->className);

                return false;
            }
        }
        if (!$obj->cleanVars()) {
            return false;
        }

        foreach ($obj->cleanVars as $k => $v) {
            if ($obj->vars[$k]['data_type'] == XOBJ_DTYPE_INT) {
                $cleanvars[$k] = (int)$v;
            } elseif (is_array($v)) {
                $cleanvars[$k] = $this->db->quoteString(implode(',', $v));
            } else {
                $cleanvars[$k] = $this->db->quoteString($v);
            }
        }
        if ($obj->isNew()) {
            if (!is_array($this->keyName)) {
                if ($cleanvars[$this->keyName] < 1) {
                    $cleanvars[$this->keyName] = $this->db->genId($this->table . '_' . $this->keyName . '_seq');
                }
            }
            $sql = 'INSERT INTO ' . $this->table . ' (' . implode(',', array_keys($cleanvars)) . ') VALUES (' . implode(',', array_values($cleanvars)) . ')';
        } else {
            $sql = 'UPDATE ' . $this->table . ' SET';
            foreach ($cleanvars as $key => $value) {
                if ((!is_array($this->keyName) && $key == $this->keyName) || (is_array($this->keyName) && in_array($key, $this->keyName))) {
                    continue;
                }
                if (isset($notfirst)) {
                    $sql .= ',';
                }
                $sql .= ' ' . $key . ' = ' . $value;
                $notfirst = true;
            }
            if (is_array($this->keyName)) {
                $whereclause = '';
                for ($i = 0; $i < count($this->keyName); ++$i) {
                    if ($i > 0) {
                        $whereclause .= ' AND ';
                    }
                    $whereclause .= $this->keyName[$i] . ' = ' . $obj->getVar($this->keyName[$i]);
                }
            } else {
                $whereclause = $this->keyName . ' = ' . $obj->getVar($this->keyName);
            }
            $sql .= ' WHERE ' . $whereclause;
        }
        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if ($obj->isNew() && !is_array($this->keyName)) {
            $obj->assignVar($this->keyName, $this->db->getInsertId());
        }

        return true;
    }

    /**
     * Change a value for objects with a certain criteria
     *
     * @param string $fieldname         Name of the field
     * @param string $fieldvalue        Value to write
     * @param CriteriaElement $criteria {@link CriteriaElement}
     *
     * @param  bool $force
     * @return bool
     */
    public function updateAll($fieldname, $fieldvalue, $criteria = null, $force = false)
    {
        $set_clause = $fieldname . ' = ';
        if (is_numeric($fieldvalue)) {
            $set_clause .= $fieldvalue;
        } elseif (is_array($fieldvalue)) {
            $set_clause .= $this->db->quoteString(implode(',', $fieldvalue));
        } else {
            $set_clause .= $this->db->quoteString($fieldvalue);
        }
        $sql = 'UPDATE ' . $this->table . ' SET ' . $set_clause;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @param      $fieldname
     * @param      $fieldvalue
     * @param null $criteria
     * @param bool $force
     *
     * @return bool
     */
    public function updateFieldValue($fieldname, $fieldvalue, $criteria = null, $force = true)
    {
        $sql = 'UPDATE ' . $this->table . ' SET ' . $fieldname . ' = ' . $fieldvalue;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * delete all objects meeting the conditions
     *
     * @param  CriteriaElement $criteria {@link CriteriaElement} with conditions to meet
     * @return bool
     */

    public function deleteAll(CriteriaElement $criteria = null)
    {
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql = 'DELETE FROM ' . $this->table;
            $sql .= ' ' . $criteria->renderWhere();
            if (!$this->db->query($sql)) {
                return false;
            }
            $rows = $this->db->getAffectedRows();

            return $rows > 0 ? $rows : true;
        }

        return false;
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function _toObject($data)
    {
        if (is_array($data)) {
            $ret = array();
            foreach ($data as $v) {
                $object = new $this->className();
                $object->assignVars($v);
                $ret[] = $object;
            }

            return $ret;
        } else {
            $object = new $this->className();
            $object->assignVars($v);

            return $object;
        }
    }

    /**
     * @param        $objects
     * @param array $externalKeys
     * @param string $format
     *
     * @return array
     */
    public function objectToArray($objects, $externalKeys = array(), $format = 's')
    {
        static $cache;

        $ret = array();
        if (is_array($objects)) {
            $i = 0;
            foreach ($objects as $object) {
                $vars = $object->getVars();
                foreach ($vars as $k => $v) {
                    $ret[$i][$k] = $object->getVar($k, $format);
                }
                foreach ($externalKeys as $key) {
                    // Replace external key by corresponding object
                    $externalKey = $object->getExternalKey($key);
                    if ($ret[$i][$key] != 0) {
                        // Retriving data if isn't cached
                        if (!isset($cached[$externalKey['keyName']][$ret[$i][$key]])) {
                            if ($externalKey['core']) {
                                $handler = xoops_getHandler($externalKey['className']);
                            } else {
                                $handler = xoops_getModuleHandler($externalKey['className'], 'extgallery');
                            }
                            $cached[$externalKey['keyName']][$ret[$i][$key]] = $this->objectToArrayWithoutExternalKey($handler->{$externalKey['getMethodeName']}($ret[$i][$key]), $format);
                        }
                        $ret[$i][$externalKey['keyName']] = $cached[$externalKey['keyName']][$ret[$i][$key]];
                    }
                    unset($ret[$i][$key]);
                }
                ++$i;
            }
        } else {
            $vars = $objects->getVars();
            foreach ($vars as $k => $v) {
                $ret[$k] = $objects->getVar($k, $format);
            }
            foreach ($externalKeys as $key) {
                // Replace external key by corresponding object
                $externalKey = $objects->getExternalKey($key);
                if ($ret[$key] != 0) {
                    // Retriving data if isn't cached
                    if (!isset($cached[$externalKey['keyName']][$ret[$key]])) {
                        if ($externalKey['core']) {
                            $handler = xoops_getHandler($externalKey['className']);
                        } else {
                            $handler = xoops_getModuleHandler($externalKey['className'], 'extgallery');
                        }
                        $cached[$externalKey['keyName']][$ret[$key]] = $this->objectToArrayWithoutExternalKey($handler->{$externalKey['getMethodeName']}($ret[$key]), $format);
                    }
                    $ret[$externalKey['keyName']] = $cached[$externalKey['keyName']][$ret[$key]];
                }
                unset($ret[$key]);
            }
        }

        return $ret;
    }

    /**
     * @param        $object
     * @param string $format
     *
     * @return array
     */
    public function objectToArrayWithoutExternalKey($object, $format = 's')
    {
        $ret = array();
        if ($object != null) {
            $vars = $object->getVars();
            foreach ($vars as $k => $v) {
                $ret[$k] = $object->getVar($k, $format);
            }
        }

        return $ret;
    }

    /**
     * @param        $fieldname
     * @param        $criteria
     * @param string $op
     *
     * @return bool
     */
    public function updateCounter($fieldname, $criteria, $op = '+')
    {
        $sql = 'UPDATE ' . $this->table . ' SET ' . $fieldname . ' = ' . $fieldname . $op . '1';
        $sql .= ' ' . $criteria->renderWhere();
        $result = $this->db->queryF($sql);
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @param null $criteria
     * @param string $sum
     *
     * @return array|int|string
     */
    public function getSum($criteria = null, $sum = '*')
    {
        $field   = '';
        $groupby = false;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            if ($criteria->groupby != '') {
                $groupby = true;
                $field   = $criteria->groupby . ', '; //Not entirely secure unless you KNOW that no criteria's groupby clause is going to be mis-used
            }
        }
        $sql = 'SELECT ' . $field . "SUM($sum) FROM " . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ($criteria->groupby != '') {
                $sql .= $criteria->getGroupby();
            }
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        if ($groupby == false) {
            list($sum) = $this->db->fetchRow($result);

            return $sum;
        } else {
            $ret = array();
            while (list($id, $sum) = $this->db->fetchRow($result)) {
                $ret[$id] = $sum;
            }

            return $ret;
        }
    }

    /**
     * @param null $criteria
     * @param string $max
     *
     * @return array|int|string
     */
    public function getMax($criteria = null, $max = '*')
    {
        $field   = '';
        $groupby = false;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            if ($criteria->groupby != '') {
                $groupby = true;
                $field   = $criteria->groupby . ', '; //Not entirely secure unless you KNOW that no criteria's groupby clause is going to be mis-used
            }
        }
        $sql = 'SELECT ' . $field . "MAX($max) FROM " . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ($criteria->groupby != '') {
                $sql .= $criteria->getGroupby();
            }
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        if ($groupby == false) {
            list($max) = $this->db->fetchRow($result);

            return $max;
        } else {
            $ret = array();
            while (list($id, $max) = $this->db->fetchRow($result)) {
                $ret[$id] = $max;
            }

            return $ret;
        }
    }

    /**
     * @param null $criteria
     * @param string $avg
     *
     * @return int
     */
    public function getAvg($criteria = null, $avg = '*')
    {
        $field = '';

        $sql = 'SELECT ' . $field . "AVG($avg) FROM " . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        list($sum) = $this->db->fetchRow($result);

        return $sum;
    }

    /**
     * @return mixed
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }
}
