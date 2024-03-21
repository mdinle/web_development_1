<?php
use \App\Models\User;
use \App\Services\UserService;

class UserController
{
    private $UserService;

    public function __construct()
    {
        $this->UserService = new UserService();
    }
    
    public function signup()
    {
        
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            include '../views/user/signup.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $user = new User();

            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $user->setUsername($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword($hashedPassword);
            $user->setUserType('client');

            $this->UserService->createUser($user);
                
            header('Location: /user/login');
        }
    }

    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            include '../views/user/login.php';
        }
        
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $user = new User();

            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);

            $authenticateUser = $this->UserService->authenticateUser($user);

            if($authenticateUser) {
                $_SESSION['user'] = $authenticateUser['user'];
                $_SESSION['userDetails'] = $authenticateUser['details'];
                    
                if($_SESSION['userDetails']->getId()) {
                    header('Location: /dashboard');
                } else {
                    header('Location: /dashboard/profile');
                }
            } else {
                $errorMessage = "Invalid email or password";
                include '../views/user/login.php';
                exit();
            }
        }
    }

    public function logout()
    {
        if(isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        header('Location: /user/login');
    }
}
