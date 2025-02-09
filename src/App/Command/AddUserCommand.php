<?php
namespace App\Command;
/**
 * Classe qui gére la commande CLI pour ajouter un utilisateur.
 * Elle prend en paramètre un fichier .json
 */

use App\Service\UserService;
use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddUserCommand extends Command {

    private UserService $userService;

    public function __construct(UserService $userService) {
        parent::__construct('user:add'); // Nom de la commande dans le terminal
        $this->userService = $userService;
    }

    protected function configure() {
        $this
            ->setDescription("Ajout d'un utilisateur depuis le fichier JSON.")
            ->addArgument('json_file', InputArgument::REQUIRED, 'Fichier JSON contenant les données de l\'utilisateur.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $jsonFile = $input->getArgument('json_file');

        if (!file_exists($jsonFile)) {
            $output->writeln("Fichier JSON non trouvé ou inexistant $jsonFile");
            return Command::FAILURE;
        }

        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);

        if (!$data || !isset($data['data']['nom'], $data['data']['email'], $data['data']['password'])) {
            $output->writeln(" Format JSON incorrect, vérifiez le fichier.");
            return Command::FAILURE;
        }

        $nom = $data['data']['nom'];
        $email = $data['data']['email'];
        $password = password_hash($data['data']['password'], PASSWORD_BCRYPT);

        $user = new User(null, $nom, $email, $password);

        if ($this->userService->registerUser($user)) {
            $output->writeln(" Utilisateur ajouté avec succes");
            return Command::SUCCESS;
        }

        $output->writeln(" Erreur lors de l'ajout de l'utilisateur.");
        return Command::FAILURE;
    }
}

