<?php

class Helper {
    private static $data = array();
    public function parse_url($url)
    {
        $parts = explode('/',$url);
        $data['controller'] = isset($parts[1])?$parts[1]:'index';
        $data['action'] = isset($parts[2])?$parts[2]:'index';
        $data['params'] = array();
        unset($parts[0], $parts[1], $parts[2]);
        if($c = count($parts)) for($i=3;$i<$c+3; $i+=2){
            $data['params'][$parts[$i]] = $parts[$i+1];
        }
        return $data;
    }
    public function getData()
    {
        if(!self::$data) self::$data = $this->parse_url($_SERVER['QUERY_STRING']);
        return self::$data;
    }

    public function getController()
    {
        $data = $this->getData();
        $controller = $data['controller'];
        if (!$controller) $controller = 'index';
        return $controller;
    }
    public function getAction()
    {
        $data = $this->getData();
        $action = $data['action'];
        if (!$action) $action = 'index';
        return $action;
    }
    public function getParams()
    {
        $data = $this->getData();
        return $data['params'];
    }

    public function actionType()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return 'Ajax';
        return 'Action';
    }

    public function url($data)
    {
        return 'index.php?/'.implode('/', $data);
    }
}