<?php

use App\Services\UserService;
use App\Services\BookingService;
use App\Models\User;
use App\Models\Details;

class DashboardController
{
    private $userService;
    private $bookingService;
    private $missingProfileInfo;


    public function __construct()
    {
        $this->userService = new UserService();
        $this->bookingService = new BookingService();
    }

    public function index()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if(!isset($_SESSION['user'])) {
                header('Location: /user/login');
                exit();
            }

            $this->checkIfUserInfoIsMissing();

            $appointments = $this->bookingService->getBookingsByClient($_SESSION['userDetails']->getId());
            $userName = $_SESSION['user']->getUsername();
            $userType = $_SESSION['user']->getUserType();
            include '../views/dashboard/index.php';
        }
    }

    public function booking()
    {

        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if(!isset($_SESSION['user'])) {
                header('Location: /user/login');
                exit();
            }

            $this->checkIfUserInfoIsMissing();

            $trainers = $this->bookingService->getAllTrainers();
            $clientId = $_SESSION['userDetails']->getId();
            $userName = $_SESSION['user']->getUsername();
            $userType = $_SESSION['user']->getUserType();
            include '../views/dashboard/booking.php';
        }
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

            $this->checkIfUserInfoIsMissing();
            
            $users = $this->userService->getAllUsers();
            $userName = $_SESSION['user']->getUsername();
            $userType = $_SESSION['user']->getUserType();

            include '../views/dashboard/admin.php';
        }
    }

    public function profile()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            if(isset($_POST['user'], $_POST['fullname'], $_POST['age'], $_POST['gender'], $_POST['address'], $_POST['phonenumber'])){
                try{
                    $useriD = filter_var($_POST['user'], FILTER_SANITIZE_NUMBER_INT);
                $fullName = htmlspecialchars($_POST['fullname']);
                $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
                $gender = htmlspecialchars($POST_['gender']);
                $address = htmlspecialchars($_POST['address']);
                $phoneNumber = filter_var($_POST['phonenumber'], FILTER_SANITIZE_NUMBER_INT);

                $userDetails = new Details();

            $userDetails->setId($_SESSION['user']->getUserID());
            $userDetails->setFullName($_POST['fullname']);
            $userDetails->setAge($_POST['age']);
            $userDetails->setGender($_POST['gender']);
            $userDetails->setAddress($_POST['address']);
            $userDetails->setPhonenumber($_POST['phonenumber']);

            if($_SESSION['user']->getUserType() !== null) {
                $result = $this->userService->createUserDetails($userDetails, $_SESSION['user']->getUserType());

                if($result) {
                    $userDetails->setId($result);

                    $_SESSION['userDetails'] = $userDetails;

                    header('Location: /dashboard');
                    exit();
                } else {
                    throw new Exception("Failed to create user details.");
                }

            } else{
                throw new Exception("Account type is not valid. Please contact a admin.");
            }

                }
                catch(Exception $e){
                    echo $e->getMessage();
                    echo "An error occurred. Please try again.";
                    exit;
                }

            }
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
            $userId = $_SESSION['user']->getUserID();
            include '../views/dashboard/profile.php';
        }
    }

    private function checkIfUserInfoIsMissing()
    {
        if(!$_SESSION['userDetails']->getId()) {
            header('Location: /dashboard/profile');
            exit();
        }
    }
}
