<?php
namespace App\Entity;

class User {
    private int $id;
    private string $nom;
    private string $email;
    private string $password;
    private string $role;

    public function getId(): int {
        return $this->id;
     }

    public function setId(int $id): self { $this->id = $id;
       return $this;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): self { $this->nom = $nom;
        return $this;
    }

  
}
