<?php
use \App\Models\User;
use \App\Models\Details;
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
            $userDetails = new Details();

            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

            
            $userDetails->setFullName($_POST['fullname']);
            $userDetails->setAge($_POST['age']);
            $userDetails->setGender($_POST['gender']);
            $userDetails->setAddress($_POST['address']);
            $userDetails->setPhonenumber($_POST['phonenumber']);
            $user->setUsername($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword($hashedPassword);
            $user->setUserType('client');

            $newUserID = $this->UserService->createUser($user);
            if($newUserID) {
                $userDetails->setId($newUserID);
                $newUserID = $this->UserService->createUserDetails($userDetails, $user->getUserType());
                if($newUserID) {
                    header('Location: /user/login');
                }
            }
                
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
                $_SESSION['user'] = $authenticateUser;
                $_SESSION['userDetails'] = $this->UserService->getUserDetails($authenticateUser->getUserID(), $authenticateUser->getUserType());
                    
                header('Location: /dashboard');
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
