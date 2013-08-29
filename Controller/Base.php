<?php

/**
 * param $view - Helper_View
 * */
class Controller_Base {
    protected $view = null;

    public function __construct()
    {
        $this->view = new Helper_View();
        if (method_exists($this, 'init')) $this->init();

    }



    public function __destruct()
    {
        if ($this->view->canRender()) $this->view->render();
    }
}