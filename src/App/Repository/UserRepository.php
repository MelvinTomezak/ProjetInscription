<?php
namespace App\Repository;

/**
 * La classe Repository gère l'accès aux données, qui sont dans notre base de donnée.
 */

use App\Entity\User;
use PDO;

class UserRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function add(User $user): bool {
        $stmt = $this->pdo->prepare("INSERT INTO users (nom, email, password) VALUES (:nom, :email, :password)");
        return $stmt->execute([
            'nom' => $user->nom,
            'email' => $user->email,
            'password' => $user->password
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function update(int $id, string $nom, string $email, string $password): bool {
        $stmt = $this->pdo->prepare("UPDATE users SET nom = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([$nom, $email, $password, $id]);
    }


    public function findById(int $id): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new User($data['id'], $data['nom'], $data['email'], $data['password']) : null;
    }
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT id, nom, email FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
