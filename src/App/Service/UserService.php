<?php
namespace App\Service;
/**
 * Classe qui vas gérer les utilisateurs
 * Validation ou non de l'inscription, de la modification ou suppression par exemple.
 */
use App\Entity\User;
use App\Repository\UserRepository;
use App\Mailer\MailerService;

class UserService {
    private UserRepository $userRepository;
    private MailerService $mailerService;
    private LoggerService $logger;

    public function __construct(UserRepository $userRepository, MailerService $mailerService, LoggerService $logger) {
        $this->userRepository = $userRepository;
        $this->mailerService = $mailerService;
        $this->logger = $logger;
    }

    public function registerUser(User $user): bool {
        $success = $this->userRepository->add($user);

        if ($success) {
            $this->mailerService->sendWelcomeEmail($user->email, $user->nom);
            $this->logger->log("USER_ADD", "Utilisateur ajouté: {$user->nom} ({$user->email})");
        } else {
            $this->logger->log("USER_ADD_FAILED", "Échec d'ajout de l'utilisateur: {$user->nom} ({$user->email})");
        }

        return $success;
    }

    public function updateUser(int $id, string $nom, string $email, string $password): bool {
        $success = $this->userRepository->update($id, $nom, $email, $password);
        if ($success) {
            $this->logger->log("USER_UPDATE", "Utilisateur mis à jour: ID $id, Nom: $nom, Email: $email");
        }
        return $success;
    }

    public function deleteUser(int $id): bool {
        $success = $this->userRepository->delete($id);

        if ($success) {
            $this->logger->log("USER_DELETE", "Utilisateur ID {$id} supprimé.");
        } else {
            $this->logger->log("USER_DELETE_FAILED", "Échec de suppression de l'utilisateur ID {$id}.");
        }

        return $success;
    }
}
