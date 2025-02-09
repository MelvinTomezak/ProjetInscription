<?php
namespace App\Command;

/**
 * Classe qui s'occupe de la commande CLI pour l'envoi de mail/
 * Elle prend en argument un fichier .json.
 */

use App\Service\NewsletterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendNewsletterCommand extends Command {
    protected static $defaultName = 'newsletter:send';

    private NewsletterService $newsletterService;

    public function __construct(NewsletterService $newsletterService) {
        parent::__construct('newsletter:send'); // Nom de la commande dans le terminale
        $this->newsletterService = $newsletterService;
    }


    protected function configure() {
        $this
            ->setDescription("Envoie d'une newsletter depuis un fichier JSON.")
            ->addArgument('json_file', InputArgument::REQUIRED, 'Fichier JSON contenant les informations de la newsletter.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $jsonFile = $input->getArgument('json_file');

        if (!file_exists($jsonFile)) {
            $output->writeln(" Fichier JSON non trouvé ou inexistant. : $jsonFile");
            return Command::FAILURE;
        }

        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);

        if (!$data || !isset($data['data']['subject'], $data['data']['message'])) {
            $output->writeln(" Format JSON incorrect ou données incomplètes.");
            return Command::FAILURE;
        }

        $subject = $data['data']['subject'];
        $message = $data['data']['message'];

        if ($this->newsletterService->sendNewsletter($subject, $message)) {
            $output->writeln(" Newsletter envoyée avec succes");
            return Command::SUCCESS;
        }

        $output->writeln(" Erreur lors de l'envoi de la newsletter.");
        return Command::FAILURE;
    }
}

