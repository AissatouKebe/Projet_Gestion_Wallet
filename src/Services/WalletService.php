<?php
namespace App\Services;
use App\Entity\Wallet;
use App\Entity\Transaction;
use App\Repository\WalletRepository;
use App\Repository\TransactionRepository;

class WalletService {
    private function __construct() {}

    public static function createWallet(Wallet $wallet): bool {
        if (WalletRepository::getInstance()->selectByTelephone($wallet->getTelephone())) {
            return false;
        }
        if (WalletRepository::getInstance()->selectByCode($wallet->getCode())) {
            return false;
        }
        $id = WalletRepository::getInstance()->insert($wallet);
        return $id > 0;
    }

    public static function getAllWallets(): array {
        return WalletRepository::getInstance()->selectAll();
    }

    public static function getWalletByTelephone(string $telephone): ?Wallet {
        return WalletRepository::getInstance()->selectByTelephone($telephone);
    }

    public static function deposit(string $telephone, float $montant): bool {
        $wallet = self::getWalletByTelephone($telephone);
        if (!$wallet || $montant <= 0) {
            return false;
        }

        $newSolde = $wallet->getSolde() + $montant;
        $success = WalletRepository::getInstance()->updateSolde($wallet->getId(), $newSolde);

        if ($success) {
            $transaction = new Transaction();
            $transaction->setWalletId($wallet->getId());
            $transaction->setCode('DEP_' . uniqid());
            $transaction->setMontant($montant);
            $transaction->setDateHeure(date('Y-m-d H:i:s'));
            $transaction->setType('DEPOT');
            TransactionRepository::getInstance()->insert($transaction);
        }

        return $success;
    }

    public static function withdraw(string $telephone, float $montant): bool {
        $wallet = self::getWalletByTelephone($telephone);
        if (!$wallet || $montant <= 0) {
            return false;
        }

        $frais = min($montant * 0.01, 5000);
        $totalDebit = $montant + $frais;

        if ($wallet->getSolde() < $totalDebit) {
            return false;
        }

        $newSolde = $wallet->getSolde() - $totalDebit;
        $success = WalletRepository::getInstance()->updateSolde($wallet->getId(), $newSolde);

        if ($success) {
            $transaction = new Transaction();
            $transaction->setWalletId($wallet->getId());
            $transaction->setCode('RET_' . uniqid());
            $transaction->setMontant($montant);
            $transaction->setDateHeure(date('Y-m-d H:i:s'));
            $transaction->setType('RETRAIT');
            TransactionRepository::getInstance()->insert($transaction);
        }

        return $success;
    }

    public static function getAllTransactions(): array {
        return TransactionRepository::getInstance()->selectAll();
    }

    public static function getTransactionsByWallet(int $walletId): array {
        return TransactionRepository::getInstance()->selectByWalletId($walletId);
    }
}
