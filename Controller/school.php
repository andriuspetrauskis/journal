<?php

class Controller_school extends Controller_Base {
    public function indexAction()
    {
       Model_User::authorize(Model_User::SCHOOL_ADMIN);
        $school = new Model_School();
        $schools = $school->detailed_list();
        $this->view->schools = array();
    }
}