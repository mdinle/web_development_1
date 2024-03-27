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

        if($results) {

            $newUserID = $this->db->lastInsertId();
    
            return $newUserID;
        } else {
            return false;
        }

    }

    public function insertUserDetails($userDetails, $userType)
    {
        if($userType === 'client') {
            $query = "INSERT INTO ClientDetails (UserID, FullName, Age, Gender, Address, PhoneNumber) 
            VALUES (:userID, :fullname, :age, :gender, :address, :phonenumber)";
        } elseif ($userType === 'trainer') {
            $query = "INSERT INTO TrainerDetails (UserID, FullName, Age, Gender, Address, PhoneNumber) 
            VALUES (:userID, :fullname, :age, :gender, :address, :phonenumber)";
        }

        $stmt = $this->db->prepare($query);

        $results = $stmt->execute([
            ':userID' => $userDetails->getId(),
            ':fullname' => $userDetails->getFullName(),
            ':age' => $userDetails->getAge(),
            ':gender' => $userDetails->getGender(),
            ':address' => $userDetails->getAddress(),
            ':phonenumber' => $userDetails->getPhonenumber()]);

        if($results) {
            $newID = $this->db->lastInsertId();

            return $newID;
        } else {
            return false;
        }
    }

    public function updateClientDetails($clientDetails)
    {
        $sql = "UPDATE ClientDetails SET ";
        $updates = [];

        if ($clientDetails->getFullName() !== null) {
            $updates[] = "FullName = '" . $clientDetails->getFullName() . "'";
        }
        if ($clientDetails->getAge() !== null) {
            $updates[] = "Age = '" . $clientDetails->getAge() . "'";
        }
        if ($clientDetails->getGender() !== null) {
            $updates[] = "Gender = '" . $clientDetails->getGender() . "'";
        }
        if ($clientDetails->getAddress() !== null) {
            $updates[] = "Address = '" . $clientDetails->getAdress() . "'";
        }
        if ($clientDetails->getPhonenumber() !== null) {
            $updates[] = "PhoneNumber = '" . $clientDetails->getPhonenumber() . "'";
        }

        $sql .= implode(", ", $updates);
        $sql .= " WHERE UserID = :userID";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userID', $userId);
        $userId = $clientDetails->getId();


        $results = $stmt->execute();

        return $results;
    }

    public function updateTrainerDetails($trainerDetails)
    {
        $sql = "UPDATE TrainerDetails SET ";
        $updates = [];

        if ($trainerDetails->getFullName() !== null) {
            $updates[] = "FullName = '" . $trainerDetails->getFullName() . "'";
        }
        if ($trainerDetails->getAge() !== null) {
            $updates[] = "Age = '" . $trainerDetails->getAge() . "'";
        }
        if ($trainerDetails->getGender() !== null) {
            $updates[] = "Gender = '" . $trainerDetails->getGender() . "'";
        }
        if ($trainerDetails->getAddress() !== null) {
            $updates[] = "Address = '" . $trainerDetails->getAdress() . "'";
        }
        if ($trainerDetails->getPhonenumber() !== null) {
            $updates[] = "PhoneNumber = '" . $trainerDetails->getPhonenumber() . "'";
        }

        $sql .= implode(", ", $updates);
        $sql .= " WHERE UserID = :userID";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userID', $userId);
        $userId = $trainerDetails->getId();


        $results = $stmt->execute();

        return $results;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE Email = :email LIMIT 1");
    
        $stmt->execute([':email' => $email]);
        
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $user = new User();
            $user->setUserID($userData['UserID']);
            $user->setUsername($userData['Username']);
            $user->setEmail($userData['Email']);
            $user->setPassword($userData['Password']);
            $user->setUserType($userData['UserType']);
            $user->setRegistrationDate($userData['RegistrationDate']);
            $user->setLastLoginDate($userData['LastLoginDate']);
            return $user;
        } else {
            return null;
        }
    }

    public function getUserDetails($user_id, $userType)
    {
        if($userType === 'client') {
            $sql = "SELECT * FROM ClientDetails WHERE UserID = :user_id";
        } elseif ($userType === 'trainer') {
            $sql = "SELECT * FROM TrainerDetails WHERE UserID = :user_id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $userDetailsData = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($userDetailsData) {
            if ($userType === 'client') {
                $userDetails = new Details();
                $userDetails->setId($userDetailsData['ClientID']);
                $userDetails->setFullName($userDetailsData['FullName']);
                $userDetails->setAge($userDetailsData['Age']);
                $userDetails->setGender($userDetailsData['Gender']);
                $userDetails->setAddress($userDetailsData['Address']);
                $userDetails->setPhonenumber($userDetailsData['PhoneNumber']);
            } elseif ($userType === 'trainer') {
                $userDetails = new Details();
                $userDetails->setId($userDetailsData['TrainerID']);
                $userDetails->setFullName($userDetailsData['FullName']);
                $userDetails->setAge($userDetailsData['Age']);
                $userDetails->setGender($userDetailsData['Gender']);
                $userDetails->setAddress($userDetailsData['Address']);
                $userDetails->setPhonenumber($userDetailsData['PhoneNumber']);
            }
            return $userDetails;
        } else {
            return null;
        }
    }

    public function changePassword($password, $user_id)
    {

        $stmt = $this->db->prepare("UPDATE Users SET Password = :password WHERE UserID = :userId;");

        $results = $stmt->execute([
            ':password' => $password,
            ':userId' => $user_id,]);

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
