<?php
require_once(BASE_PATH . 'core/Controller.php');

class TeacherController extends Controller{

    public function dashboard(){
        $this->redirectIfNotAuthenticated();

        $this->view('teacher/Dashboard');
    }
    
}