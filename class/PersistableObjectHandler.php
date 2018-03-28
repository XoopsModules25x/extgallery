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

/**
 * Persistable Object Handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of derived class objects.
 *
 * @author    Jan Keller Pedersen <mithrandir@xoops.org> - IDG Danmark A/S <www.idg.dk>
 * @copyright copyright (c) 2000-2004 XOOPS.org
 * @package   Kernel
 */
class PersistableObjectHandler extends \XoopsPersistableObjectHandler //XoopsObjectHandler
{
    /**#@+
     * Information about the class, the handler is managing
     *
     * @var string
     */
    //    public $table;
    //    public $keyName;
    //    public $className;
    //    public $identifierName;
    /**#@-*/

    /**
     * Constructor - called from child classes
     *
     * @param \XoopsDatabase $db        {@link XoopsDatabase}
     *                                  object
     * @param string         $tablename Name of database table
     * @param string         $classname Name of Class, this handler is managing
     * @param string         $keyname   Name of the property, holding the key
     *
     * @param bool           $idenfierName
     */

    public function __construct(\XoopsDatabase $db, $tablename, $classname, $keyname, $idenfierName = false)
    {
        parent::__construct($db);
        //        $db = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->table     = $db->prefix($tablename);
        $this->keyName   = $keyname;
//        $this->className = '\\XoopsModules\\Extgallery\\' .$classname;
        $this->className = $classname;
        if (false !== $idenfierName) {
            $this->identifierName = $idenfierName;
        }
    }

    /**
     * create a new user
     *
     * @param bool $isNew Flag the new objects as "new"?
     *
     * @return \XoopsObject
     */

    public function create($isNew = true)
    {
        $temp = '\\XoopsModules\\Extgallery\\' . $this->className;
        $obj = new $temp;

        if (true === $isNew) {
            $obj->setNew();
        }
        return $obj;
    }

    /**
     * delete an object from the database
     *
     * @param mixed $id id of the object to delete
     * @param  bool $force
     * @return bool        FALSE if failed.
     */
    public function deleteById($id, $force = false)
    {
        if (is_array($this->keyName)) {
            $clause = [];
            for ($i = 0, $iMax = count($this->keyName); $i < $iMax; ++$i) {
                $clause[] = $this->keyName[$i] . ' = ' . $id[$i];
            }
            $whereclause = implode(' AND ', $clause);
        } else {
            $whereclause = $this->keyName . ' = ' . $id;
        }
        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $whereclause;
        if (false !== $force) {
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
        if (null !== $criteria && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        $result = false !== $force ? $this->db->queryF($sql) : $this->db->query($sql);
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function _toObject($data)
    {
        if (is_array($data)) {
            $ret = [];
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
     * @param array  $externalKeys
     * @param string $format
     *
     * @return array
     */
    public function objectToArray($objects, $externalKeys = [], $format = 's')
    {
        static $cached;

        $ret = [];
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
                    if (0 != $ret[$i][$key]) {
                        // Retriving data if isn't cached
                        if (!isset($cached[$externalKey['keyName']][$ret[$i][$key]])) {
                            if ($externalKey['core']) {
                                $handler = xoops_getHandler($externalKey['className']);
                            } else {
                                $handler = Extgallery\Helper::getInstance()->getHandler($externalKey['className']);
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
                if (0 != $ret[$key]) {
                    // Retriving data if isn't cached
                    if (!isset($cached[$externalKey['keyName']][$ret[$key]])) {
                        if ($externalKey['core']) {
                            $handler = xoops_getHandler($externalKey['className']);
                        } else {
                            $handler = Extgallery\Helper::getInstance()->getHandler($externalKey['className']);
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
        $ret = [];
        if (null !== $object) {
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
        $sql    = 'UPDATE ' . $this->table . ' SET ' . $fieldname . ' = ' . $fieldname . $op . '1';
        $sql    .= ' ' . $criteria->renderWhere();
        $result = $this->db->queryF($sql);
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @param null|\CriteriaElement $criteria
     * @param string               $sum
     *
     * @return array|int|string
     */
    public function getSum(\CriteriaElement $criteria = null, $sum = '*')
    {
        $field   = '';
        $groupby = false;
        if (null !== $criteria && is_subclass_of($criteria, 'CriteriaElement')) {
            if ('' != $criteria->groupby) {
                $groupby = true;
                $field   = $criteria->groupby . ', '; //Not entirely secure unless you KNOW that no criteria's groupby clause is going to be mis-used
            }
        }
        $sql = 'SELECT ' . $field . "SUM($sum) FROM " . $this->table;
        if (null !== $criteria && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' != $criteria->groupby) {
                $sql .= $criteria->getGroupby();
            }
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        if (false === $groupby) {
            list($sum) = $this->db->fetchRow($result);

            return $sum;
        } else {
            $ret = [];
            while (false !== (list($id, $sum) = $this->db->fetchRow($result))) {
                $ret[$id] = $sum;
            }

            return $ret;
        }
    }

    /**
     * @param \CriteriaElement $criteria
     * @param string           $max
     *
     * @return array|int|string
     */
    public function getMax(\CriteriaElement $criteria = null, $max = '*')
    {
        $field   = '';
        $groupby = false;
        if (null !== $criteria && is_subclass_of($criteria, 'CriteriaElement')) {
            if ('' != $criteria->groupby) {
                $groupby = true;
                $field   = $criteria->groupby . ', '; //Not entirely secure unless you KNOW that no criteria's groupby clause is going to be mis-used
            }
        }
        $sql = 'SELECT ' . $field . "MAX($max) FROM " . $this->table;
        if (null !== $criteria && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' != $criteria->groupby) {
                $sql .= $criteria->getGroupby();
            }
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        if (false === $groupby) {
            list($max) = $this->db->fetchRow($result);

            return $max;
        } else {
            $ret = [];
            while (false !== (list($id, $max) = $this->db->fetchRow($result))) {
                $ret[$id] = $max;
            }

            return $ret;
        }
    }

    /**
     * @param \CriteriaElement $criteria
     * @param string           $avg
     *
     * @return int
     */
    public function getAvg(\CriteriaElement $criteria = null, $avg = '*')
    {
        $field = '';

        $sql = 'SELECT ' . $field . "AVG($avg) FROM " . $this->table;
        if (null !== $criteria && is_subclass_of($criteria, 'CriteriaElement')) {
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
