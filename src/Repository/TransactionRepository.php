<?php
namespace App\Repository;
use App\Config\AbstractRepository;
use App\Entity\Transaction;

class TransactionRepository extends AbstractRepository {
    private static ?TransactionRepository $instance = null;

    private function __construct() { parent::__construct(); }

    public static function getInstance(): TransactionRepository {
        if (self::$instance === null) {
            self::$instance = new TransactionRepository();
        }
        return self::$instance;
    }

    public function insert(Transaction $transaction): int {
        $pdo = parent::getConnection();
        $cursor = $pdo->prepare(
            "INSERT INTO transactions (wallet_id, code, montant, date_heure, type) 
             VALUES (:wallet_id, :code, :montant, :date_heure, :type)"
        );
        $cursor->execute([
            ':wallet_id' => $transaction->getWalletId(),
            ':code' => $transaction->getCode(),
            ':montant' => $transaction->getMontant(),
            ':date_heure' => $transaction->getDateHeure(),
            ':type' => $transaction->getType(),
        ]);
        $lastId = $pdo->lastInsertId();
        parent::closeConnection();
        return (int)$lastId;
    }

    public function selectAll(): array {
        $pdo    = parent::getConnection();
        $cursor = $pdo->query("SELECT * FROM transactions ORDER BY date_heure DESC");
        $items  = $cursor->fetchAll(\PDO::FETCH_CLASS, Transaction::class);
        parent::closeConnection();
        return $items;
    }

    public function selectByWalletId(int $walletId): array {
        $pdo    = parent::getConnection();
        $cursor = $pdo->prepare("SELECT * FROM transactions WHERE wallet_id = :wallet_id ORDER BY date_heure DESC");
        $cursor->execute([':wallet_id' => $walletId]);
        $items  = $cursor->fetchAll(\PDO::FETCH_CLASS, Transaction::class);
        parent::closeConnection();
        return $items;
    }
}
