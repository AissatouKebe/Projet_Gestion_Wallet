<?php
namespace App\Entity;

class Wallet {
    private int $id;
    private string $nom;
    private string $prenom;
    private string $telephone;
    private string $code;
    private float $solde = 0.0;

    public function getId(): int { return $this->id; }
    public function setId(int $id): self { $this->id = $id; return $this; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $prenom): self { $this->prenom = $prenom; return $this; }

    public function getTelephone(): string { return $this->telephone; }
    public function setTelephone(string $telephone): self { $this->telephone = $telephone; return $this; }

    public function getCode(): string { return $this->code; }
    public function setCode(string $code): self { $this->code = $code; return $this; }

    public function getSolde(): float { return $this->solde; }
    public function setSolde(float $solde): self { $this->solde = $solde; return $this; }
}
