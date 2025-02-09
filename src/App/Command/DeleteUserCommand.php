<?php
namespace App\Command;
/**
 * Classe qui gére la commande CLI et qui s'occupe de la suppression d'un utilisateur.
 * La suppression s'effectue grâce au fichier .json.
 */

use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteUserCommand extends Command {
    protected static $defaultName = 'user:delete';

    private UserService $userService;

    public function __construct(UserService $userService) {
        parent::__construct('user:delete'); // Nom de la commande dans le terminal
        $this->userService = $userService;
    }


    protected function configure() {
        $this
            ->setDescription("Suppression d'un utilisateur depuis le fichier JSON.")
            ->addArgument('json_file', InputArgument::REQUIRED, 'Fichier JSON contenant l\'ID de l\'utilisateur à supprimer.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $jsonFile = $input->getArgument('json_file');

        if (!file_exists($jsonFile)) {
            $output->writeln(" Fichier JSON non trouvé ou inexistant : $jsonFile");
            return Command::FAILURE;
        }

        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);

        if (!$data || !isset($data['data']['id'])) {
            $output->writeln(" Format JSON incorrect.");
            return Command::FAILURE;
        }

        $id = $data['data']['id'];

        if ($this->userService->deleteUser($id)) {
            $output->writeln(" Utilisateur supprimé avec succes");
            return Command::SUCCESS;
        }

        $output->writeln(" Erreur lors de la suppression de l'utilisateur.");
        return Command::FAILURE;
    }
}
