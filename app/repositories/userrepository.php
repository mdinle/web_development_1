<?php
namespace App\Repositories;

use PDO;
use App\Models\User;
use App\Models\Details;

class UserRepository extends Repository
{
    public function insert($user)
    {
        $stmt = $this->db->prepare("INSERT INTO Users (Username, `Password` ,Email, UserType) VALUES (:username, :password_hash, :email, :user_type)");

        $results = $stmt->execute([
            ':username' => $user->getUsername(),
            ':email' => $user->getEmail(),
            ':password_hash' => $user->getPassword(),
            ':user_type' => $user->getUserType()]);

        return $results;

    }


    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE Email = :email LIMIT 1");
    
        $stmt->execute([':email' => $email]);
        
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if($userData) {
            $userId = $userData['UserID'];
            $role = $userData['UserType'];

            $additionalDetailsQuery = '';
            if ($role === 'client') {
                $additionalDetailsQuery = "SELECT * FROM ClientDetails WHERE UserID = :userId";
            } elseif ($role === 'trainer') {
                $additionalDetailsQuery = "SELECT * FROM TrainerDetails WHERE UserID = :userId";
            }

            if ($additionalDetailsQuery) {
                $stmt = $this->db->prepare($additionalDetailsQuery);
                $stmt->execute(['userId' => $userId]);
                $additionalDetails = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!$additionalDetails) {
                    $user = new User();
                    $user->setUserID($userData['UserID']);
                    $user->setUsername($userData['Username']);
                    $user->setEmail($userData['Email']);
                    $user->setPassword($userData['Password']);
                    $user->setUserType($userData['UserType']);
                    $user->setRegistrationDate($userData['RegistrationDate']);
                    $user->setLastLoginDate($userData['LastLoginDate']);

                    $emptyDetails = new Details();

                    $completeProfile = [
                        'user' => $user,
                        'details' => $emptyDetails
                    ];

                    return $completeProfile;
                }
        
                $userProfile = array_merge($userData, $additionalDetails);

                $user = new User();
                $user->setUserID($userProfile['UserID']);
                $user->setUsername($userProfile['Username']);
                $user->setEmail($userProfile['Email']);
                $user->setPassword($userProfile['Password']);
                $user->setUserType($userProfile['UserType']);
                $user->setRegistrationDate($userProfile['RegistrationDate']);
                $user->setLastLoginDate($userProfile['LastLoginDate']);
                
                $userDetails = new Details();
                if($role === 'client') {
                    $userDetails->setId($userProfile['ClientID']);
                    $userDetails->setFullName($userProfile['FullName']);
                    $userDetails->setAge($userProfile['Age']);
                    $userDetails->setGender($userProfile['Gender']);
                    $userDetails->setAddress($userProfile['Address']);
                    $userDetails->setPhonenumber($userProfile['PhoneNumber']);
                }

                if($role === 'trainer') {
                    $userDetails->setId($userProfile['TrainerID']);
                    $userDetails->setFirstName($userProfile['FullName']);
                    $userDetails->setAge($userProfile['Age']);
                    $userDetails->setGender($userProfile['Gender']);
                    $userDetails->setAddress($userProfile['Address']);
                    $userDetails->setPhonenumber($userProfile['PhoneNumber']);
                }

                $completeProfile = [
                    'user' => $user,
                    'details' => $userDetails
                ];

                return $completeProfile;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function changePassword($password, $user_id)
    {

        $stmt = $this->db->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :user_id;");

        $results = $stmt->execute([
            ':password_hash' => $password,
            ':user_id' => $user_id,]);

        return $results;

    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM Users");
        $stmt->execute();
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($usersData as $userData) {
            $user = new User();
            $user->setUserID($userData['UserID']);
            $user->setUsername($userData['Username']);
            $user->setEmail($userData['Email']);
            $user->setPassword($userData['Password']);
            $user->setUserType($userData['UserType']);
            $user->setRegistrationDate($userData['RegistrationDate']);
            $user->setLastLoginDate($userData['LastLoginDate']);
            $users[] = $user;
        }

        return $users;
    }

    public function updateUser($user)
    {
        $sql = "UPDATE Users SET ";
        $updates = [];

        if ($user->getUserName() !== null) {
            $updates[] = "Username = '" . $user->getUserName() . "'";
        }
        if ($user->getEmail() !== null) {
            $updates[] = "Email = '" . $user->getEmail() . "'";
        }
        if ($user->getPassword() !== null) {
            $updates[] = "Password = '" . $user->getPassword() . "'";
        }
        if ($user->getUserType() !== null) {
            $updates[] = "UserType = '" . $user->getUserType() . "'";
        }

        $sql .= implode(", ", $updates);
        $sql .= " WHERE UserID = :userID";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $userID = $user->getUserID();


        $results = $stmt->execute();

        return $results;
    }

    public function deleteUser($user_id)
    {
        $stmt = $this->db->prepare("DELETE FROM Users WHERE UserID = :user_id");

        $results = $stmt->execute([':user_id' => $user_id]);

        return $results;
    }
}
