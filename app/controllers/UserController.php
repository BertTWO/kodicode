<?php
require_once(BASE_PATH . 'core/Controller.php');

class UserController extends Controller
{

    public function index()
    {
        $this->view('login', ['name' => 'robert']);
    }

    public function getAll()
    {
        $user = new user();
        $users = $user->getAll();

        return json_encode($users);
    }

    
    public function getById($id)
    {
        $user = new user();
        return json_encode($user->getById($id));
    }

    public function viewRegister()
    {
        $this->view('auth/register'); 
    }

    public function handleRegister()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $userModel = new User();

        if ($userModel->findByUsername($username)) {
            echo "Username already exists.";
            return;
        }

        if ($userModel->findByEmail($email)) {
            echo "Email already exists.";
            return;
        }


        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userModel->insert([
            'username' => $username,
            'password_hash' => $hashedPassword,
            'email' => $email,
            'role' => $role,
        ]);

        echo "Registration successful. Please login.";
        header('Location: /kodicode/log-in');
        exit();
    }
}
