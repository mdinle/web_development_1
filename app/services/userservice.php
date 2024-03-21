<?php
namespace App\Services;

use \App\Repositories\UserRepository;

class UserService
{
    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function createUser($user)
    {
        return $this->userRepo->insert($user);
    }

    public function createUserDetails($userDetails, $userType)
    {
        return $this->userRepo->insertUserDetails($userDetails, $userType);
    }

    public function authenticateUser($user)
    {
        $userData = $this->userRepo->getUserByEmail($user->getEmail());

        if ($userData) {
            if (!password_verify($user->getPassword(), $userData['user']->getPassword())) {
                return false;
            }
            return $userData;
        } else {
            return false;
        }
    }

    public function changePassword($password, $user_id)
    {
        return $this->userRepo->changePassword($password, $user_id);
    }

    public function getAllUsers()
    {
        return $this->userRepo->getAllUsers();
    }

    public function updateUser($user)
    {
        return $this->userRepo->updateUser($user);
    }

    public function deleteUser($user_id)
    {
        return $this->userRepo->deleteUser($user_id);
    }
}
