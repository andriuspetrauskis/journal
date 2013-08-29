<?php

set_include_path(get_include_path().';'.getcwd().';..;');

function __autoload($name)
{
    $file_name = str_replace(array('_','-'), array('/', ''), $name).'.php';
    if (file_exists($file_name)) include_once $file_name;
}

session_name('jsessid');
session_start();

$helper = new Helper();

$controller = $helper->getController();
$controller_class = 'Controller_'.$controller;

$ctrl = new $controller_class;

$action = $helper->getAction().$helper->actionType();

$ctrl->$action();

