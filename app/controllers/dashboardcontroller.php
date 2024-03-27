<?php

use App\Services\UserService;
use App\Services\BookingService;
use App\Models\User;
use App\Models\Details;

class DashboardController
{
    private $userService;
    private $bookingService;
    private $loggedInUserName;
    private $loggedInUserType;


    public function __construct()
    {
        $this->userService = new UserService();
        $this->bookingService = new BookingService();
        if(isset($_SESSION['user'])) {
            $userName = $_SESSION['user']->getUsername();
            $userType = $_SESSION['user']->getUserType();

            $this->loggedInUserName = $userName;
            $this->loggedInUserType = $userType;
        }
    }

    public function index()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if(!isset($_SESSION['user'])) {
                header('Location: /user/login');
                exit();
            }

            if($_SESSION['user']->getUserType() == 'trainer') {
                $trainerAppointments = $this->bookingService->getBookingsByTrainer($_SESSION['userDetails']->getId());
            }

            if($_SESSION['user']->getUserType() == 'client') {
                $appointments = $this->bookingService->getBookingsByClient($_SESSION['userDetails']->getId());
            }
            
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

                        $this->userService->createUser($this->sanitizeUser(null, $userName, $email, $password, $userType));

                        header('Location: /dashboard/admin');
                        break;
                    case 'editUserForm':

                        $this->userService->updateUser($this->sanitizeUser($_POST['userId'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['userType']));

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
            
            $users = $this->userService->getAllUsers();
            $loggedInUserName = $this->loggedInUserName;
            $loggedInUserType = $this->loggedInUserType;
            include '../views/dashboard/admin.php';
        }
    }
 
    public function profile()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if(!isset($_SESSION['user'])) {
                header('Location: /user/login');
                exit();
            }
            
            $userId = $_SESSION['user']->getUserID();
            $loggedInUserName = $this->loggedInUserName;
            $loggedInUserType = $this->loggedInUserType;
            include '../views/dashboard/profile.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            if(isset($_SESSION['user'])) {
                try {
                    $userID = $_SESSION['user']->getUserID();
                    $userType = $_SESSION['user']->getUserType();

                    if($userID !== null && $userType !== null) {

                        $result = $this->userService->updateUserDetails($this->sanitizeUserDetails($userID, $_POST['fullname'], $_POST['age'], $_POST['gender'], $_POST['address'], $_POST['phonenumber']), $userType);

                        if($result) {
                            $userDetails = $this->userService->getUserDetails($userID, $userType);

                            $_SESSION['userDetails'] = $userDetails;

                            $successMessage = "Profile updated successfully.";
                            $_SESSION['successMessage'] = $successMessage;

                            header('Location: /dashboard/profile');
                            exit;
                        } else {
                            throw new Exception("An error occurred while updating user details.");
                        }

                    } else {
                        throw new Exception("User ID or User Type is missing.");
                    }

                } catch(Exception $e) {
                    echo $e->getMessage();
                    echo "An error occurred. Please try again.";
                    exit;
                }
            }
        }
    }

    public function settings()
    {
        if(!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit();
        }

        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $userId = $_SESSION['user']->getUserID();
            $loggedInUserName = $this->loggedInUserName;
            $loggedInUserType = $this->loggedInUserType;
            include '../views/dashboard/settings.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if(isset($_SESSION['user'])) {
                try {
                    $userID = $_SESSION['user']->getUserID();

                    if($userID !== null) {

                        $result = $this->userService->changePassword($_POST['password'], $userID);

                        if($result) {
                            $successMessage = "Password updated successfully.";
                            $_SESSION['successMessage'] = $successMessage;

                            header('Location: /dashboard/settings');
                            exit;
                        } else {
                            throw new Exception("An error occurred while updating password.");
                        }

                    } else {
                        throw new Exception("User ID is missing.");
                    }

                } catch(Exception $e) {
                    echo $e->getMessage();
                    echo "An error occurred. Please try again.";
                    exit;
                }
            }
        }
    }

    public function sanitizeUser($userId, $userName, $email, $password, $userType)
    {
        $user = new User();
    
        
        $user->setUserID($sanitizedUserId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT));
        
        $sanitizedUserName = isset($userName) ? htmlspecialchars(trim($userName)) : null;
        $sanitizedEmail = isset($email) ? filter_var(trim($email), FILTER_SANITIZE_EMAIL) : null;
        $hashedPassword = trim($password) !== '' ? password_hash(trim($password), PASSWORD_DEFAULT) : null;
        $sanitizedUserType = isset($userType) && $userType !== 'User Type' ? htmlspecialchars(trim($userType)) : null;

        $user->setUsername($sanitizedUserName !== '' ? $sanitizedUserName : null);
        $user->setEmail($sanitizedEmail !== '' ? $sanitizedEmail : null);
        $user->setPassword($hashedPassword);
        $user->setUserType($sanitizedUserType);

        return $user;
        
    }

    public function sanitizeUserDetails($userId, $fullName, $age, $gender, $address, $phoneNumber)
    {
        $userDetails = new Details();
    
        
        $userDetails->setId($sanitizedUserId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT));
        
        $sanitizedFullName = isset($fullName) ? htmlspecialchars(trim($fullName)) : null;
        $sanitizedAge = isset($age) ? filter_var(trim($age), FILTER_SANITIZE_NUMBER_INT) : null;
        $sanitizedGender = isset($gender) && $gender !== 'Gender' ? htmlspecialchars(trim($gender)) : null;
        $sanitizedAddress = isset($address) ? htmlspecialchars(trim($address)) : null;
        $sanitizedPhoneNumber = isset($phoneNumber) ? filter_var(trim($phoneNumber), FILTER_SANITIZE_NUMBER_INT) : null;

        $userDetails->setFullName($sanitizedFullName !== '' ? $sanitizedFullName : null);
        $userDetails->setAge($sanitizedAge !== '' ? $sanitizedAge : null);
        $userDetails->setGender($sanitizedGender);
        $userDetails->setAddress($sanitizedAddress !== '' ? $sanitizedAddress : null);
        $userDetails->setPhonenumber($sanitizedPhoneNumber !== '' ? $sanitizedPhoneNumber : null);

        return $userDetails;
    }
}
