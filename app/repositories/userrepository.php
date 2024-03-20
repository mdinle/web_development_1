<?php
namespace App\Repositories;

use PDO;
use App\Models\User;

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

        $user = new User();
        $user->setUserID($userData['UserID']);
        $user->setUsername($userData['Username']);
        $user->setEmail($userData['Email']);
        $user->setPassword($userData['Password']);
        $user->setUserType($userData['UserType']);
        $user->setRegistrationDate($userData['RegistrationDate']);
        $user->setLastLoginDate($userData['LastLoginDate']);

        return $user;
    }

    public function changePassword($password, $user_id)
    {

        $stmt = $this->db->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :user_id;");

        $results = $stmt->execute([
            ':password_hash' => $password,
            ':user_id' => $user_id,]);

        return $results;

    }
}
