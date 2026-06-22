<?php
namespace App\Entity;

class Transaction {
    private int $id;
    private int $wallet_id;
    private string $code;
    private float $montant;
    private string $date_heure;
    private string $type;

    public function getId(): int {
         return $this->id;
          }

    public function setId(int $id): self {
         $this->id = $id;
          return $this;
           }

    public function getWalletId(): int {
         return $this->wallet_id;
          }

    public function setWalletId(int $wallet_id): self {
         $this->wallet_id = $wallet_id;
          return $this;
           }

    public function getCode(): string {
         return $this->code;
          }

    public function setCode(string $code): self {
         $this->code = $code;
          return $this;
          }

    public function getMontant(): float {
         return $this->montant;
          }

    public function setMontant(float $montant): self {
         $this->montant = $montant;
          return $this;
           }

    public function getDateHeure(): string {
         return $this->date_heure;
          }

          
    public function setDateHeure(string $date_heure): self {
         $this->date_heure = $date_heure; 
         return $this;
          }

    public function getType(): string {
         return $this->type;
          }

    public function setType(string $type): self {
         $this->type = $type;
          return $this;
           }
}
