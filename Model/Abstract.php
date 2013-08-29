<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrius
 * Date: 8/29/13
 * Time: 7:18 PM
 * To change this template use File | Settings | File Templates.
 */

class Model_Abstract {

    protected $_table_name = 'abstract';

    protected function _getTableName()
    {
        return $this->_table_name = str_replace('Model_', '', __CLASS__);
    }

    public function add($data)
    {
        $this->validate($data=array());
        $pdo = Db::getPdo();
        $sql = "INSERT INTO ".$this->_getTableName().' ';
        $sql.=' ('.implode(array_keys($data)).') VALUES ('.implode(', :', array_keys($data)).')';
        $stmt = $pdo->prepare($sql);
        foreach ($data as $k=>&$v) $stmt->bindParam(':'.$k, $v);
        $result = $stmt->execute();
        return $result;
    }

    public function get($data=array())
    {
        if (is_int($data)) $data = array('id' => $data);
        $pdo = Db::getPdo();
        $sql = "SELECT * FROM ".$this->_getTableName().' ';
        if ($data) {
            $sql.=' WHERE ';
            $keys = array_keys($data);
            foreach ($keys as $v) $sql.= $v.' = :'.$v.' ';
        }
        $stmt = $pdo->prepare($sql);
        foreach ($data as $k=>&$v) $stmt->bindParam(':'.$k, $v);
        $result = $stmt->fetch();
        return $result;
    }

    public function getList($data=array())
    {
        if (is_int($data)) $data = array('id' => $data);
        $pdo = Db::getPdo();
        $sql = "SELECT * FROM ".$this->_getTableName().' ';
        if ($data) {
            $sql.=' WHERE ';
            $keys = array_keys($data);
            foreach ($keys as $v) $sql.= $v.' = :'.$v.' ';
        }
        $stmt = $pdo->prepare($sql);
        foreach ($data as $k=>&$v) $stmt->bindParam(':'.$k, $v);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getDetailedList($selects=array('*'), $joins=array())
    {
        $pdo = Db::getPdo();
        $sql = "SELECT ".implode(', ', $selects)." FROM ".$this->_getTableName().' ';

        foreach ($joins as $j=>$on) $sql .= ' LEFT JOIN '.$j.' ON '.$on.' ';

        $stmt = $pdo->prepare($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function set($data=array(), $where=array())
    {
        $pdo = Db::getPdo();
        $sql = "UPDATE ".$this->_getTableName().' ';
        $sql .= ' SET ';
        $keys = array_keys($data);
        foreach ($keys as $v) $sql.= $v.' = :'.$v.' ';

        if ($where) {
            $sql.=' WHERE ';
            $keys = array_keys($where);
            foreach ($keys as $v) $sql.= $v.' = :'.$v.' ';
        }
        $stmt = $pdo->prepare($sql);
        foreach ($data as $k=>&$v) $stmt->bindParam(':'.$k, $v);
        foreach ($where as $k=>&$v) $stmt->bindParam(':'.$k, $v);
        $result = $stmt->execute();
        return $result;
    }

    public function validate($data)
    {
        foreach ($data as $item) if (strpos('\'', $item)!==0) throw new Exception('Klaida apdorojnat uzklausa');
    }
}