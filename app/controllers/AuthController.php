<?php
require_once(BASE_PATH . 'core/Controller.php');

class AuthController extends Controller
{
    public function viewLogin()
    {
        if($this->isAuthenticated())
        {
            header('Location: /kodicode/' . $_SESSION['user']['role'] . '/dashboard');
        }
        $this->view('auth/login');
    }

    public function handleLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userModel = new User();

        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password_hash'])) {

            $_SESSION['user'] = $user;
            header('Location: /kodicode/' . $user['role'] . '/dashboard');
        } else {

            echo "Invalid credentials.";
        }
    }

    public function handleLogout()
    {
        session_destroy();
        header('Location: /kodicode/log-in');
        exit();
    }
}
