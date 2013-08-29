<?php

class Controller_admin extends Controller_Base {
    public function indexAction()
    {
        Model_User::authorize(Model_User::SCHOOL_ADMIN);
        $school = new Model_School();
        $schools = $school->detailed_list();
        $this->view->schools = $schools;
    }
    public function addAction()
    {
        if (isset($_POST['name']))
        {
            $school = new Model_School();
            $user = new Model_User();
            $school->add($_POST['name']);
            $user->add($_POST['admin_id'], $_POST['admin_name'], $_POST['password']);
            header('Location:'.$this->view->url('admin', 'index'));
        }
    }
}