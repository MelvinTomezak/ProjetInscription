<?php
/**
 * Classe de test pour la db/
 */
require_once __DIR__ . "/Config/ConfigBD.php";


try {
    $pdo = ConfigBD::getConnection();
    echo "Connexion réussie !\n";

    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        die("Erreur : La table 'users' n'existe pas !\n");
    } else {
        echo "Table 'users' trouvée.\n";
    }
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>