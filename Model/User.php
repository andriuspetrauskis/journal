<?php

class Model_User {
    const GUEST = 0;
    const SYSTEM_ADMIN = 1;
    const SCHOOL_ADMIN = 2;
    const TEACHER = 4;
    const STUDENT = 8;
    private $_user_status = 0;
    private $_data;

    public function __construct($id=null)
    {
        if ($id) $this->get($id);
    }

    public function add($id, $password, $name)
    {
        $exec = false;
        try {
            $pdo = Db::getPdo();
            $stmt = $pdo->prepare("INSERT INTO users (user_id, password, full_name, status) VALUES(:uid, MD5(:pass), :name, :status)");
            $stmt -> bindParam(':uid', $id);
            $stmt -> bindParam(':pass', $password);
            $stmt -> bindParam(':name', $name);
            $stmt -> bindParam(':status', $this->_user_status);
            $exec = $stmt->execute();
        } catch(Exception $e) {
            $error = $e->getMessage();
            if (strpos($error, 'dublicate')) $error = 'Toks vartotojas jau yra';
            throw new Exception($error);
        }
        return $exec;
    }

    public function remove($id)
    {
        $pdo = Db::getPdo();
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :uid");
        $stmt -> bindParam(':uid', $id);
        $exec = $stmt->execute();
        return $exec;
    }

    public function get($id)
    {
        if (!$this->_data){
            $pdo = Db::getPdo();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :uid");
            $stmt -> bindParam(':uid', $id);
            $this->_data = $stmt->fetch();
        }
        return $this->_data;
    }
    public function getList($params=array(), $limit=0)
    {
        $sql = "SELECT * FROM users";
        if ($params)
        {
            $sql.=" WHERE ";
            $tsql = array();
            foreach ($params as $key=>$val)
            {
                $tsql[]=$key.' = :'.$key;
            }
            $sql .= implode(', ',$tsql);
        }
        if ($limit) $sql.=' LIMIT :limit';
        $pdo = Db::getPdo();
        $stmt = $pdo->prepare($sql);
        if ($params) foreach ($params as $key=>&$val)
        {
            $stmt->bindParam(':'.$key, $val);
        }
        if ($limit) $stmt->bindValue(':limit', $limit);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function authorize($level=self::GUEST)
    {
        if (!isset($_SESSION['user']) && $level)
        {
            throw new Exception('Jums reikia prisijungti');
        }
        if ($level && $_SESSION['user']->level > $level)
        {
            throw new Exception('Neturite teisių matyti šį puslapį');
        }
    }

    public function login($id, $pass)
    {
        $user_data = $this->getList(array('user_id'=>$id, 'password'=>md5($pass)), 1);
        return isset($user_data['id']);
    }

    public function __get($key)
    {
        if ($this->_data[$key]) return $this->_data[$key];

    }

}