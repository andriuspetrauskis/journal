<?php

class Controller_school extends Controller_Base {
    public function indexAction()
    {
       Model_User::authorize(Model_User::SCHOOL_ADMIN);

        $class = new Model_Class();
        $classes = $class->detailed_list();
        $this->view->classes = $classes;

        $student = new Model_Student();
        $students = $student->detailed_list();
        $this->view->students = $students;

        $subject = new Model_Subject();
        $subjects = $subject->detailed_list();
        $this->view->subjects = $subjects;

        $teacher = new Model_Teacher();
        $teachers = $teacher->detailed_list();
        $this->view->teachers = $teachers;

    }

    public function add_teacherAction()
    {

    }
    public function add_classAction()
    {
        $class = new Model_Class();
        $class->add();
    }
    public function add_studentAction()
    {

    }
    public function add_subjectAction()
    {

    }
}