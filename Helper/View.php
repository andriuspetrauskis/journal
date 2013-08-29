<?php

class Helper_View {
    private $_render = true;

    public function canRender($can=null){
        if ($can !== null) $this->_render = $can;
        return $this->_render;
    }

    public function render($name=null,$full_render=true) {
        if ($full_render) include 'templates/top.phtml';
        if (!$name) {
            $h = new Helper();
            $d = $h->getData();
            $controller = $d['controller'];
            $action = $d['action'];
            $name = strtolower('templates/'.$controller.'/'.$action.'.phtml');
        }
        //if(file_exists($name))
            include $name;
        //else throw new Exception('Template '.$name.' not found '.getcwd() );
        if ($full_render) include 'templates/bottom.phtml';
        $this->canRender(false);
    }

    public function url(){
        if (is_array(func_get_arg(0))) $data = func_get_arg(0);
        else $data = func_get_args();
        $h = new Helper();
        return $h->url($data);
    }

}