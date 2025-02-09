# 📌 **Projet d'Inscription - CLI (Mise à jour avec fichiers JSON)**

### 👥 Équipe du Projet
- TOMEZAK Melvin
- SAADAOUI Fayrouz
- DICKO Fatim

# 🤖 Readme rédiger avec ChatGpt 
(je lui ai donner les infos il a fait la mise en forme pour que ce soit lisible)

## 🚀 **Installation et Configuration**

### 1️⃣ **Cloner le projet**
```sh
git clone https://github.com/MelvinTomezak/ProjetInscription.git
# une fois cloner aller dans le répértoire du clone
cd clone
```

### 2️⃣ **Installer PHP et Composer**
Vérifier si PHP est installé :
```sh
php -v
```
Installer Composer si nécessaire :
```sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
Installer les dépendances du projet :
```sh
composer install
```

---

## 🛠 **Configuration de la Base de Données**

### 1️⃣ **Lancer MySQL**
```sh
mysql -u root -p
```

### 2️⃣ **Créer la base de données et la table users**
```sql
CREATE DATABASE projet_inscription;
USE projet_inscription;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3️⃣ **Configurer la connexion MySQL**
Ouvrir **`src/App/Config/ConfigBD.php`** et vérifier les informations de connexion :
```php
<?php
namespace App\Config;

use PDO;
use PDOException;

class ConfigBD {
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO("mysql:host=localhost;dbname=projet_inscription;charset=utf8", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("❌ Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
```
📌 **Modifier les identifiants (`root`, `password`) si nécessaire.**

---

## 📩 **Gestion des Emails avec MailCatcher**

Nous avons utilisé **MailCatcher** (comme indiqué dans le sujet) pour tester l'envoi d'e-mails.

### 1️⃣ **Installation de MailCatcher avec Docker**
```sh
docker run -d -p 1025:1025 -p 1080:1080 sj26/mailcatcher
```

### 2️⃣ **Accéder à l'interface MailCatcher**
📌 Ouvrir : **[http://127.0.0.1:1080/](http://127.0.0.1:1080/)**

---

## ⚙️ **Commandes disponibles**

### 📌 **Lister les commandes disponibles**
```sh
php console.php list
```
📌 **Vous devriez voir :**
```
Available commands:
  user:add        Ajoute un utilisateur via un fichier JSON
  user:update     Met à jour un utilisateur via un fichier JSON
  user:delete     Supprime un utilisateur via un fichier JSON
  newsletter:send Envoie une newsletter via un fichier JSON
```

---

## 📝 **Utilisation avec Fichiers JSON**

### ➤ **Ajouter un utilisateur**
Créer un fichier `user_add.json` :
```json
{
  "action": "add",
  "data": {
    "nom": "John Doe",
    "email": "john@example.com",
    "password": "password123"
  }
}
```
Exécuter la commande :
```sh
php console.php user:add user_add.json
```
📌 **Sortie attendue :**
```
✅ Utilisateur ajouté avec succès !
```

---

### ➤ **Mettre à jour un utilisateur**
Créer un fichier `user_update.json` :
```json
{
  "action": "update",
  "data": {
    "id": 1,
    "nom": "John Doe Updated",
    "email": "john_updated@example.com",
    "password": "newpass456"
  }
}
```
Exécuter la commande :
```sh
php console.php user:update user_update.json
```
📌 **Sortie attendue :**
```
✅ Utilisateur mis à jour avec succès !
```

---

### ➤ **Supprimer un utilisateur**
Créer un fichier `user_delete.json` :
```json
{
  "action": "delete",
  "data": {
    "id": 1
  }
}
```
Exécuter la commande :
```sh
php console.php user:delete user_delete.json
```
📌 **Sortie attendue :**
```
✅ Utilisateur supprimé avec succès !
```

---

### ➤ **Envoyer une newsletter**
Créer un fichier `newsletter.json` :
```json
{
  "action": "send",
  "data": {
    "subject": "Promo Spéciale",
    "message": "Profitez de nos offres aujourd'hui !"
  }
}
```
Exécuter la commande :
```sh
php console.php newsletter:send newsletter.json
```
📌 **Sortie attendue :**
```
✅ Newsletter envoyée avec succès !
```

---

## 📜 **Logs des Actions**
Toutes les actions sont enregistrées dans **`log.txt`**.

### ➤ **Vérifier les logs**
```sh
cat log.txt
```
📌 **Exemple de sortie :**
```
[2025-02-08 15:00:00] [USER_ADD] Utilisateur ajouté: John Doe (john@example.com)
[2025-02-08 15:05:00] [USER_UPDATE] Utilisateur mis à jour: ID 1, Nom: John Doe Updated
[2025-02-08 15:10:00] [NEWSLETTER_SENT] Newsletter envoyée à tous les utilisateurs avec le sujet: Promo Spéciale
```

---

## 🎉 **Félicitations ! Le projet est maintenant opérationnel.** 🚀🔥
Si vous avez des questions, n'hésitez pas à me contacter ! 😃

