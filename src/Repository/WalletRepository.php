<?php
namespace App\Repository;
use App\Config\AbstractRepository;
use App\Entity\Wallet;

class WalletRepository extends AbstractRepository {
    private static ?WalletRepository $instance = null;

    private function __construct() { parent::__construct(); }

    public static function getInstance(): WalletRepository {
        if (self::$instance === null) {
            self::$instance = new WalletRepository();
        }
        return self::$instance;
    }

    public function insert(Wallet $wallet): int {
        $pdo = parent::getConnection();
        $cursor = $pdo->prepare(
            "INSERT INTO wallets (nom, prenom, telephone, code, solde) VALUES (:nom, :prenom, :telephone, :code, :solde)"
        );
        $cursor->execute([
            ':nom' => $wallet->getNom(),
            ':prenom' => $wallet->getPrenom(),
            ':telephone' => $wallet->getTelephone(),
            ':code' => $wallet->getCode(),
            ':solde' => $wallet->getSolde(),
        ]);
        $lastId = $pdo->lastInsertId();
        parent::closeConnection();
        return (int)$lastId;
    }

    public function selectAll(): array {
        $pdo    = parent::getConnection();
        $cursor = $pdo->query("SELECT * FROM wallets ORDER BY id DESC");
        $items  = $cursor->fetchAll(\PDO::FETCH_CLASS, Wallet::class);
        parent::closeConnection();
        return $items;
    }

    public function selectById(int $id): ?Wallet {
        $pdo    = parent::getConnection();
        $cursor = $pdo->prepare("SELECT * FROM wallets WHERE id = :id");
        $cursor->execute([':id' => $id]);
        $item = $cursor->fetchObject(Wallet::class);
        parent::closeConnection();
        return $item ?: null;
    }

    public function selectByTelephone(string $telephone): ?Wallet {
        $pdo    = parent::getConnection();
        $cursor = $pdo->prepare("SELECT * FROM wallets WHERE telephone = :telephone");
        $cursor->execute([':telephone' => $telephone]);
        $item = $cursor->fetchObject(Wallet::class);
        parent::closeConnection();
        return $item ?: null;
    }

    public function selectByCode(string $code): ?Wallet {
        $pdo    = parent::getConnection();
        $cursor = $pdo->prepare("SELECT * FROM wallets WHERE code = :code");
        $cursor->execute([':code' => $code]);
        $item = $cursor->fetchObject(Wallet::class);
        parent::closeConnection();
        return $item ?: null;
    }

    public function updateSolde(int $id, float $newSolde): bool {
        $pdo    = parent::getConnection();
        $cursor = $pdo->prepare("UPDATE wallets SET solde = :solde WHERE id = :id");
        $result = $cursor->execute([
            ':solde' => $newSolde,
            ':id' => $id,
        ]);
        parent::closeConnection();
        return $result;
    }
}
