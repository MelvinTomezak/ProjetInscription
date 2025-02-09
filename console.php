<?php
/**
 * Point d'entrée (pour lancer le programme php console.php fichier.json)
 */
require_once __DIR__ . '/vendor/autoload.php';

use App\Config\ConfigBD;
use App\Service\UserService;
use App\Service\NewsletterService;
use App\Service\LoggerService;
use App\Mailer\MailerService;
use App\Repository\UserRepository;
use App\Command\AddUserCommand;
use App\Command\UpdateUserCommand;
use App\Command\DeleteUserCommand;
use App\Command\SendNewsletterCommand;
use Symfony\Component\Console\Application;

$pdo = ConfigBD::getConnection();
$userRepo = new UserRepository($pdo);
$mailerService = new MailerService();
$logger = new LoggerService();
$userService = new UserService($userRepo, $mailerService, $logger);
$newsletterService = new NewsletterService($userRepo, $mailerService, $logger);

$application = new Application();

$application->add(new AddUserCommand($userService));
$application->add(new UpdateUserCommand($userService));
$application->add(new DeleteUserCommand($userService));
$application->add(new SendNewsletterCommand($newsletterService, $mailerService));

$application->run();
