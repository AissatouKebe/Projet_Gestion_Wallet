<?php
namespace App\Services;
use App\Entity\User;
use App\Repository\UserRepository;

class UserService {
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getUserByEmail(string $email): ?User {
        return $this->userRepository->selectByEmail($email);
    }

    public function getUserById(int $id): ?User {
        return $this->userRepository->selectById($id);
    }
}
