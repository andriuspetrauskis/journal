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
        $this->validate($data);
        $pdo = Db::getPdo();
        $sql = "INSERT INTO ".$this->_getTableName().' ';

        $stmt = $pdo->prepare($sql);
    }

    public function get()
    {

    }

    public function getList()
    {

    }

    public function getDetailedList()
    {

    }

    public function set()
    {

    }

    public function validate($data)
    {

    }
}