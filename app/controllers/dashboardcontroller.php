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
    private $loggedInUserName;
    private $loggedInUserType;


    public function __construct()
    {
        $this->userService = new UserService();
        $this->bookingService = new BookingService();
        $userName = $_SESSION['user']->getUsername();
        $userType = $_SESSION['user']->getUserType();
        $this->loggedInUserName = $userName;
        $this->loggedInUserType = $userType;
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
            $loggedInUserName = $this->loggedInUserName;
            $loggedInUserType = $this->loggedInUserType;

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
            $loggedInUserName = $this->loggedInUserName;
            $loggedInUserType = $this->loggedInUserType;

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
                        $userName = $_POST['username'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $userType = $_POST['userType'];

                        $this->userService->createUser(sanitizeUser(null, $userName, $email, $password, $userType));

                        header('Location: /dashboard/admin');
                        break;
                    case 'editUserForm':
                        $userId = $_POST['userId'];
                        $userName = $_POST['username'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $userType = $_POST['userType'];

                        $this->userService->updateUser(sanitizeUser($userId, $userName, $email, $password, $userType));

                        header('Location: /dashboard/admin');
                        break;
                    case 'deleteUserForm':
                        if(isset($_POST['userId'])) {
                            $userId = filter_var($_POST['userId'], FILTER_SANITIZE_NUMBER_INT);
                            $this->userService->deleteUser($userId);
                            
                        } else {
                            throw new Exception("User ID is missing.");
                            exit;
                        }
                        

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
            $loggedInUserName = $this->loggedInUserName;
            $loggedInUserType = $this->loggedInUserType;
            include '../views/dashboard/admin.php';
        }
    }

    public function profile()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            if(isset($_POST['user'], $_POST['fullname'], $_POST['age'], $_POST['gender'], $_POST['address'], $_POST['phonenumber'])) {
                try {
                    $useriD = filter_var($_POST['user'], FILTER_SANITIZE_NUMBER_INT);
                    $fullName = htmlspecialchars($_POST['fullname']);
                    $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
                    $gender = htmlspecialchars($POST_['gender']);
                    $address = htmlspecialchars($_POST['address']);
                    $phoneNumber = filter_var($_POST['phonenumber'], FILTER_SANITIZE_NUMBER_INT);

                    $userDetails = new Details();

                    $userDetails->setUserId($useriD);
                    $userDetails->setFullName($fullName);
                    $userDetails->setAge($age);
                    $userDetails->setGender($gender);
                    $userDetails->setAddress($address);
                    $userDetails->setPhoneNumber($phoneNumber);

                    if($useriD !== null) {
                        $result = $this->userService->createUserDetails($userDetails, $_SESSION['user']->getUserType());

                        if($result) {
                            $userDetails->setId($result);

                            $_SESSION['userDetails'] = $userDetails;

                            header('Location: /dashboard');
                            exit;
                        } else {
                            throw new Exception("Failed to create user details.");
                        }

                    } else {
                        throw new Exception("Account type is not valid. Please contact a admin.");
                    }

                } catch(Exception $e) {
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


            $userId = $_SESSION['user']->getUserID();
            $loggedInUserName = $this->loggedInUserName;
            $loggedInUserType = $this->loggedInUserType;
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

    public function sanitizeUser($userId, $userName, $email, $password, $userType)
    {
        $user = new User();
                        
        if(isset($userId)) {
            $sanitizedUserId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
            
            if(isset($userName)) {
                $sanitizedUserName = htmlspecialchars($userName);
                $user->setUsername($sanitizedUserName);
            }

            if(isset($email)) {
                $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
                $user->setEmail($sanitizedEmail);
            }

            if(isset($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);
            }

            if(isset($userType)) {
                $sanitizedUserType = htmlspecialchars($userType);
                $user->setUserType($sanitizedUserType);
            }

            return $user;
        }
    }
}
