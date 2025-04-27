<?php

class Controller
{
   
    protected function isAuthenticated()
    {
        return isset($_SESSION['user']);
    }

    protected function checkRole($role)
    {
        return $this->isAuthenticated() && $_SESSION['user']['role'] === $role;
    }


    protected function redirectIfNotAuthenticated()
    {
        if (!$this->isAuthenticated()) {
            header('Location: /kodicode/log-in');
            exit();
        }
    }


    protected function view($filename = '', $data = [])
    {
        require_once BASE_PATH . 'app/views/' . $filename . '.php';
    }
}
