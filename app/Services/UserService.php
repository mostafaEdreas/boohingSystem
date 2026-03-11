<?php

namespace App\Services;

use App\Repostories\UserRepository;

class UserService
{

    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data)
    {
        return $this->userRepository->createUser($data);
        
    }
}