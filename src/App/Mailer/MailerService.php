<?php
namespace App\Mailer;

/**
 * La classe MailerService, s'occupe des envoies de mail avec PHPMailer.
 * Pour configurer PHPMailer, tout est dans le ReadMe.
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



require_once __DIR__ . '/../../../vendor/autoload.php';

class MailerService {
    private PHPMailer $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = 'localhost';
        $this->mailer->Port = 1025;
    }


    public function sendEmail(string $to, string $subject, string $message) {
        try {
            $this->mailer->setFrom('noreply@example.com', 'Test MailCatcher');
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $message;
            $this->mailer->send();
            echo " Email envoyé à $to\n";
        } catch (Exception $e) {
            echo " Erreur lors de l'envoi du mail : " . $e->getMessage() . "\n";
        }
    }

    public function sendWelcomeEmail(string $recipient, string $username): void {
        $subject = "Bienvenue, $username !";
        $message = "Bonjour $username,\n\n Nous sommes ravis de vous accueillir !\n\nCordialement.";

        $this->sendEmail($recipient, $subject, $message);
    }

}
