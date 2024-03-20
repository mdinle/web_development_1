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

    public function authenticateUser($user)
    {
        $userData = $this->userRepo->getUserByEmail($user->getEmail());

        if ($userData) {
            if (!password_verify($user->getPassword(), $userData->getPassword())) {
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
}
