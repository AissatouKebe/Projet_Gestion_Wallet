<?php
namespace App\Repository;
use App\Config\AbstractRepository;
use App\Entity\User;

class UserRepository extends AbstractRepository {
    private static ?UserRepository $instance = null;

    private function __construct() { parent::__construct(); }

    public static function getInstance(): UserRepository {
        if (self::$instance === null) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    public function selectByEmail(string $email): ?User {
        $pdo    = parent::getConnection();
        $cursor = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $cursor->execute([':email' => $email]);
        $user = $cursor->fetchObject(User::class);
        parent::closeConnection();
        return $user ?: null;
    }

    public function selectById(int $id): ?User {
        $pdo    = parent::getConnection();
        $cursor = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $cursor->execute([':id' => $id]);
        $user = $cursor->fetchObject(User::class);
        parent::closeConnection();
        return $user ?: null;
    }
}
