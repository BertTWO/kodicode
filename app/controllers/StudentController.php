<?php
require_once(BASE_PATH . 'core/Controller.php');

class StudentController extends Controller{

    public function dashboard(){
        $this->redirectIfNotAuthenticated();
        
        $this->view('student/Dashboard');
    }
    
}