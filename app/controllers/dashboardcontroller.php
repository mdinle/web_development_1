<?php

use App\Services\UserService;
use App\Services\BookingService;
use App\Models\User;

class DashboardController
{
    private $userService;
    private $bookingService;


    public function __construct()
    {
        $this->userService = new UserService();
        $this->bookingService = new BookingService();
    }

    public function index()
    {
        if(!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit();
        }

        if(!$_SESSION['userDetails']->getId()) {
            header('Location: /dashboard/profile');
            exit();
        }

        $userName = $_SESSION['user']->getUsername();
        $userType = $_SESSION['user']->getUserType();
        include '../views/dashboard/index.php';
    }

    public function booking()
    {
        if(!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit();
        }

        if(!$_SESSION['userDetails']->getId()) {
            header('Location: /dashboard/profile');
            exit();
        }


        $trainers = $this->bookingService->getAllTrainers();
        $userId = $_SESSION['user']->getUserID();
        $userName = $_SESSION['user']->getUsername();
        $userType = $_SESSION['user']->getUserType();
        include '../views/dashboard/booking.php';
    }

    public function admin()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            if($_POST['form_identifier']) {
                $formIdentifier = $_POST['form_identifier'];
                switch ($formIdentifier) {
                    case 'addUserForm':
                        $user = new User();
                        $user->setUsername($_POST['username']);
                        $user->setEmail($_POST['email']);
                        $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                        $user->setUserType($_POST['userType']);
                        $this->userService->createUser($user);

                        header('Location: /dashboard/admin');
                        break;
                    case 'editUserForm':
                        $user = new User();
                        
                        $user->setUserID($_POST['userId']);

                        if($_POST['username'] != '') {
                            $user->setUsername($_POST['username']);
                        }
                        if($_POST['email'] != '') {
                            $user->setEmail($_POST['email']);
                        }
                        if($_POST['password'] != '') {
                            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                        }
                        if($_POST['userType'] != 'User Type') {
                            $user->setUserType($_POST['userType']);
                        }

                        if($user->getUsername() == null && $user->getEmail() == null && $_POST['password'] == null && $user->getUserType() == null) {
                            header('Location: /dashboard/admin');
                            exit();
                        }

                        $this->userService->updateUser($user);

                        header('Location: /dashboard/admin');

                        break;
                    case 'deleteUserForm':
                        $this->userService->deleteUser($_POST['userId']);

                        header('Location: /dashboard/admin');
                        break;
                    default:
                        // Handle unrecognized form identifier
                        break;
                }
            }

        }

        if($_SERVER['REQUEST_METHOD'] == "GET") {

            if(!isset($_SESSION['user'])) {
                header('Location: /user/login');
                exit();
            }

            $users = $this->userService->getAllUsers();
            $userName = $_SESSION['user']->getUsername();
            $userType = $_SESSION['user']->getUserType();

            include '../views/dashboard/admin.php';
        }
    }

    public function profile()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST") {

        }

        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if(!isset($_SESSION['user'])) {
                header('Location: /user/login');
                exit();
            }

            if(!$_SESSION['userDetails']->getId()) {
                $fillOutProfile = true;
            } else {
                $fillOutProfile = false;
            }

            $userName = $_SESSION['user']->getUsername();
            $userType = $_SESSION['user']->getUserType();
            include '../views/dashboard/profile.php';
        }
    }
}
