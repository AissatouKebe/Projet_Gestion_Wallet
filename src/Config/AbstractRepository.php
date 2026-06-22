<?php
namespace App\Config;

abstract class AbstractRepository {
    private ?\PDO $pdo = null;

    protected function __construct() {}

    public function getConnection(): \PDO {
        try {
            $this->pdo = new \PDO(
                "pgsql:host=localhost;
                 port=5432;
                 dbname=wallet_db",
                "postgres", "ROOT"
            );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
        return $this->pdo;
    }

    public function closeConnection(): void {
        $this->pdo = null;
    }
}
