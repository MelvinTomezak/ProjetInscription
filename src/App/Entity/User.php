<?php
namespace App\Entity;

/**
 * La classe User, représente les éléments que l'on retrouve dans la DB (id, nom, email et mdp).
 */

class User {
    public ?int $id;
    public string $nom;
    public string $email;
    public string $password;

    public function __construct(?int $id, string $nom, string $email, string $password) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}
