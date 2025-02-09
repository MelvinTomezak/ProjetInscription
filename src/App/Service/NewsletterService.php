<?php
namespace App\Service;
/**
 * CLasse qui vas s'occuper d'envoyer les mails
 */
use App\Repository\UserRepository;
use App\Mailer\MailerService;

class NewsletterService {
    private UserRepository $userRepository;
    private MailerService $mailerService;
    private LoggerService $logger;

    public function __construct(UserRepository $userRepository, MailerService $mailerService, LoggerService $logger) {
        $this->userRepository = $userRepository;
        $this->mailerService = $mailerService;
        $this->logger = $logger;
    }

    public function sendNewsletter(string $subject, string $message): void {
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            $this->mailerService->sendEmail($user['email'], $subject, $message);
            $this->logger->log("NEWSLETTER_SENT", "Newsletter envoyée à {$user['email']} avec comme objet: {$subject}");
        }

        $this->logger->log("NEWSLETTER_COMPLETED", "Envoi de newsletter terminé.");
    }
}
