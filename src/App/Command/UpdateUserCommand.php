<?php
namespace App\Command;

/**
 * Classe qui gére la commande CLI qui s'occupe de la mise à jour d'un utilisateur.
 * Elle prend en argument l'id, le nouveau/ancien nom, le nouveau/ancien mail et le nouveau/ancien mdp.
 */

use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateUserCommand extends Command {

    private UserService $userService;

    public function __construct(UserService $userService) {
        parent::__construct('user:update'); // Nom de la commande dans le terminal
        $this->userService = $userService;
    }

    protected function configure() {
        $this
            ->setDescription("Mise à jour d'un utilisateur depuis un fichier JSON.")
            ->addArgument('json_file', InputArgument::REQUIRED, 'Fichier JSON contenant les nouvelles données de l\'utilisateur.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $jsonFile = $input->getArgument('json_file');

        if (!file_exists($jsonFile)) {
            $output->writeln(" Fichier JSON non trouvé ou inexistant : $jsonFile");
            return Command::FAILURE;
        }

        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);

        if (!$data || !isset($data['data']['id'], $data['data']['nom'], $data['data']['email'], $data['data']['password'])) {
            $output->writeln(" Format JSON incorrect");
            return Command::FAILURE;
        }

        $id = $data['data']['id'];
        $nom = $data['data']['nom'];
        $email = $data['data']['email'];
        $password = password_hash($data['data']['password'], PASSWORD_BCRYPT);

        if ($this->userService->updateUser($id, $nom, $email, $password)) {
            $output->writeln(" Utilisateur mis à jour avec succes");
            return Command::SUCCESS;
        }

        $output->writeln(" Erreur lors de la mise à jour.");
        return Command::FAILURE;
    }
}

