<?php
namespace App\Controller;
use App\Config\AbstractController;
use App\Config\Validator;
use App\Entity\Wallet;
use App\Services\WalletService;
use Override;

class WalletController extends AbstractController {
    #[Override]
    public function __construct() { 
        parent::__construct(); 
    }

    public function list(): void {
        $wallets = WalletService::getAllWallets();
        $transactions = WalletService::getAllTransactions();
        
        $this->render("index", [
            "wallets" => $wallets,
            "transactions" => $transactions
        ]);
    }

    public function create(): void {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom       = trim($_POST['nom'] ?? '');
            $prenom    = trim($_POST['prenom'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $code      = trim($_POST['code'] ?? '');
            $solde     = (float)($_POST['solde'] ?? 0);

            Validator::reset();
            Validator::isEmpty($nom, "nom", "Le nom est obligatoire");
            Validator::isEmpty($prenom, "prenom", "Le prénom est obligatoire");
            Validator::isEmpty($telephone, "telephone", "Le téléphone est obligatoire");
            Validator::isTelephone($telephone, "telephone", "Le téléphone doit contenir uniquement des chiffres (7 à 15 caractères)");
            Validator::isEmpty($code, "code", "Le code est obligatoire");
            Validator::isPositive((string)$solde, "solde", "Le solde doit être positif ou nul");

            if (!Validator::validate()) {
                $this->render("index", [
                    "errors" => Validator::getErrors(),
                    "old" => $_POST
                ]);
                exit;
            }

            $wallet = new Wallet();
            $wallet->setNom($nom);
            $wallet->setPrenom($prenom);
            $wallet->setTelephone($telephone);
            $wallet->setCode($code);
            $wallet->setSolde($solde);

            if (WalletService::createWallet($wallet)) {
                header("location:/wallet/list");
                exit;
            } else {
                $this->render("index", [
                    "errors" => ["general" => "Erreur lors de la création du wallet (téléphone ou code déjà utilisé ?)"],
                    "old" => $_POST
                ]);
            }
        }
        header("location:/wallet/list");
    }

    public function deposit(): void {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $telephone = trim($_POST['telephone_depot'] ?? '');
            $montant    = (float)($_POST['montant_depot'] ?? 0);

            Validator::reset();
            Validator::isEmpty($telephone, "telephone_depot", "Le téléphone est obligatoire");
            Validator::isTelephone($telephone, "telephone_depot", "Téléphone invalide");
            Validator::isPositive((string)$montant, "montant_depot", "Le montant doit être positif");

            if (Validator::validate()) {
                $success = WalletService::deposit($telephone, $montant);
                if (!$success) {
                    // On peut ajouter un message d'erreur plus tard
                }
            }

            header("location:/wallet/list");
            exit;
        }
    }

    public function withdraw(): void {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $telephone = trim($_POST['telephone_retrait'] ?? '');
            $montant    = (float)($_POST['montant_retrait'] ?? 0);

            Validator::reset();
            Validator::isEmpty($telephone, "telephone_retrait", "Le téléphone est obligatoire");
            Validator::isTelephone($telephone, "telephone_retrait", "Téléphone invalide");
            Validator::isPositive((string)$montant, "montant_retrait", "Le montant doit être positif");

            if (Validator::validate()) {
                $success = WalletService::withdraw($telephone, $montant);
                if (!$success) {
                    // Peut être solde insuffisant
                }
            }

            header("location:/wallet/list");
            exit;
        }
    }
}