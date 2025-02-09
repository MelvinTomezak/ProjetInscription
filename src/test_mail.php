<?php
/**
 * Classe de test pour l'envoie de mail avec MailCatcher
 */
$to = "test@example.com";
$subject = "Test MailCatcher";
$message = "Ceci est un email de test envoyé via PHP.";
$headers = "From: noreply@example.com\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "Email envoyé avec succès !\n";
} else {
    echo " Échec de l'envoi de l'email.\n";
}
