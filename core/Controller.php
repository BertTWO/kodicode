<?php

class Controller
{
    protected $languageMap = [
        'py'   => 'Python',
        'cpp'  => 'C++',
        'java' => 'Java',
        'cs'   => 'C#',
    ];

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

        include BASE_PATH . "app/views/{$filename}.php";
    }
    public function viewAsTeacher($filename = '', $data = [])
    {

        if (!$this->checkRole('teacher')) {
            header('Location: /kodicode/log-in');
            exit();
        }

        $this->redirectIfNotAuthenticated();

        include BASE_PATH . 'app/views/components/header.php';
        include BASE_PATH . 'app/views/components/body.php';
        include BASE_PATH . 'app/views/components/navbar.php';
        require_once BASE_PATH . 'app/views/teacher/sidebar.php';
        extract($data);
        include BASE_PATH . "app/views/{$filename}.php";

        include BASE_PATH . 'app/views/components/footer.php';
    }
    public function viewAsStudent($filename = '', $data = [])
    {

        if (!$this->checkRole('student')) {
            header('Location: /kodicode/log-in');
            exit();
        }
        $this->redirectIfNotAuthenticated();

        include BASE_PATH . 'app/views/components/header.php';
        include BASE_PATH . 'app/views/components/body.php';
        include BASE_PATH . 'app/views/components/navbar.php';
        require_once BASE_PATH . 'app/views/student/sidebar.php';
        extract($data);

        include BASE_PATH . "app/views/{$filename}.php";

        include BASE_PATH . 'app/views/components/footer.php';
    }
}
