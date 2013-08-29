<?php

class Controller_index extends Controller_Base {

    public function indexAction()
    {
        //display log in forms.
    }
    public function loginAction()
    {
        //check data and redirect, or show error
        $user = new Model_User();
        $log_in = $user->login($_POST['id'], $_POST['password']);
        if ($log_in){
            $u = $user->get($_POST['id']);
            $_SESSION['user'] = $user;
            $controller = 'index';
            switch($u['level'])
            {
                case Model_User::STUDENT: $controller = 'student'; break;
                case Model_User::TEACHER: $controller = 'teacher'; break;
                case Model_User::SCHOOL_ADMIN: $controller = 'school'; break;
                case Model_User::SYSTEM_ADMIN: $controller = 'admin'; break;
            }
            header('Location:'.$this->view->url($controller,'index'));
        } else {
            $_SESSION['message'] = array('text'=>'Blogi prisijungimo duomenys', 'type'=>'error');
            header('Location:'.$this->view->url('index','index'));
        }
    }

}