# Gestion du Personnel Temporaire - Projet Laravel

Ce projet est une application web développée avec Laravel pour la gestion du personnel temporaire, incluant le suivi des informations personnelles, des compétences, des expériences et un système complet d'évaluation basé sur des critères dynamiques.



## Installation et Configuration

Pour mettre en place et exécuter ce projet Laravel sur votre machine locale, suivez les étapes ci-dessous. Ces instructions couvrent les prérequis, l'installation des dépendances, la configuration de la base de données et le lancement de l'application.

### Prérequis

Assurez-vous que les éléments suivants sont installés sur votre système :

*   **PHP** (version 8.1 ou supérieure recommandée) : Laravel est un framework PHP, donc une version compatible de PHP est essentielle. Vous pouvez vérifier votre version de PHP en exécutant `php -v` dans votre terminal.
*   **Composer** : C'est un gestionnaire de dépendances pour PHP. Il est utilisé pour installer toutes les bibliothèques et packages dont le projet a besoin. Si vous ne l'avez pas, vous pouvez le télécharger depuis le [site officiel de Composer](https://getcomposer.org/download/).
*   **MySQL** (ou un autre système de gestion de base de données compatible avec Laravel, comme PostgreSQL ou SQLite) : Ce projet utilise MySQL par défaut pour le stockage des données. Assurez-vous que MySQL est installé et que son service est en cours d'exécution. Vous pouvez vérifier l'état du service MySQL avec `sudo service mysql status` sur les systèmes basés sur Debian/Ubuntu.
*   **Extensions PHP** : Certaines fonctionnalités de Laravel et de ses dépendances nécessitent des extensions PHP spécifiques. Assurez-vous que les extensions suivantes sont activées dans votre configuration `php.ini` :
    *   `php-dom`
    *   `php-xml`
    *   `php-curl`
    *   `php-gd`
    *   `php-zip`
    *   `php-mysql` (pour la connexion à MySQL)

    Sur les systèmes Debian/Ubuntu, vous pouvez les installer avec une commande similaire à :
    ```bash
    sudo apt update
    sudo apt install -y php8.1-dom php8.1-xml php8.1-curl php8.1-gd php8.1-zip php8.1-mysql
    ```
    N'oubliez pas de redémarrer votre serveur web (Apache/Nginx) ou PHP-FPM après l'installation des extensions pour qu'elles soient prises en compte.

### Étapes d'Installation

1.  **Cloner le dépôt (ou décompresser le projet)** :
    Si vous avez reçu le projet sous forme d'archive (par exemple, `gestion-personnel.rar`), décompressez-le dans le répertoire de votre choix. Si c'est un dépôt Git, clonez-le :
    ```bash
    git clone <URL_DU_DEPOT>
    cd gestion-personnel
    ```

2.  **Installer les dépendances Composer** :
    Naviguez vers le répertoire racine du projet dans votre terminal et exécutez la commande suivante pour installer toutes les dépendances PHP :
    ```bash
    composer install
    ```
    Cette commande télécharge et configure tous les packages nécessaires définis dans le fichier `composer.json`.

3.  **Configurer le fichier d'environnement (`.env`)** :
    Laravel utilise un fichier `.env` pour la configuration spécifique à l'environnement (base de données, clés d'API, etc.). Copiez le fichier d'exemple fourni :
    ```bash
    cp .env.example .env
    ```
    Ensuite, ouvrez le fichier `.env` avec votre éditeur de texte et configurez les informations de votre base de données. Assurez-vous que les lignes suivantes correspondent à votre configuration MySQL :
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=gestion_personnel # Nom de votre base de données
    DB_USERNAME=laravel_user      # Votre utilisateur MySQL
    DB_PASSWORD=password          # Votre mot de passe MySQL
    ```
    *Note : L'utilisateur `laravel_user` avec le mot de passe `password` a été utilisé pour les tests dans l'environnement de développement. Il est recommandé d'utiliser des identifiants plus sécurisés pour un environnement de production.*

4.  **Générer la clé d'application** :
    Laravel nécessite une clé d'application unique pour des raisons de sécurité. Exécutez la commande suivante :
    ```bash
    php artisan key:generate
    ```
    Cela mettra à jour la variable `APP_KEY` dans votre fichier `.env`.

5.  **Créer la base de données et exécuter les migrations** :
    Avant d'exécuter les migrations, assurez-vous que la base de données spécifiée dans `DB_DATABASE` (`gestion_personnel` par défaut) existe dans votre serveur MySQL. Vous pouvez la créer manuellement via un client MySQL (comme PhpMyAdmin, MySQL Workbench) ou via la ligne de commande :
    ```bash
    mysql -u votre_utilisateur_mysql -p -e "CREATE DATABASE IF NOT EXISTS gestion_personnel;"
    ```
    Si vous avez créé un utilisateur spécifique pour Laravel (comme `laravel_user`), assurez-vous qu'il a les privilèges nécessaires sur cette base de données :
    ```bash
    sudo mysql -e "CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'password';"
    sudo mysql -e "GRANT ALL PRIVILEGES ON gestion_personnel.* TO 'laravel_user'@'localhost';"
    sudo mysql -e "FLUSH PRIVILEGES;"
    ```
    Une fois la base de données créée, exécutez les migrations pour créer les tables nécessaires et les seeders pour populer la base de données avec des données initiales (types de personnel, critères d'évaluation, etc.) :
    ```bash
    php artisan migrate:fresh --seed
    ```
    *Note : `migrate:fresh` supprimera toutes les tables existantes avant de les recréer. Utilisez-le avec prudence en production.*

6.  **Lancer le serveur de développement** :
    Pour lancer l'application, utilisez le serveur de développement intégré de Laravel :
    ```bash
    php artisan serve
    ```
    Cela démarrera le serveur sur `http://127.0.0.1:8000` (ou un autre port si 8000 est déjà utilisé). Vous pouvez spécifier un hôte et un port différents si nécessaire :
    ```bash
    php artisan serve --host 0.0.0.0 --port 8000
    ```

7.  **Accéder à l'application** :
    Ouvrez votre navigateur web et naviguez vers l'URL affichée dans votre terminal (par exemple, `http://127.0.0.1:8000`).

### Informations de Connexion par Défaut

Après avoir exécuté `php artisan migrate:fresh --seed`, un utilisateur administrateur par défaut est créé. Vous pouvez vous connecter avec les identifiants suivants :

*   **Email** : `admin@cerd.org`
*   **Mot de passe** : `password` (si vous utilisez le seeder par défaut de Laravel Breeze, sinon vérifiez votre `DatabaseSeeder` pour le mot de passe configuré).




## Fonctionnalités

Ce projet offre une gestion robuste du personnel temporaire, avec un accent particulier sur l'évaluation des performances et la gestion des critères d'évaluation. Les principales fonctionnalités incluent :

### 1. Gestion du Personnel Temporaire

Cette section couvre les fonctionnalités de base de la gestion du personnel, permettant d'enregistrer et de suivre les informations détaillées de chaque membre du personnel temporaire. Cela inclut les données personnelles, les coordonnées, les informations professionnelles, les compétences, et les expériences.

*   **Enregistrement des informations détaillées** : Nom, prénom, email, téléphone, date et lieu de naissance, sexe, situation matrimoniale, nombre d'enfants, adresse complète.
*   **Informations professionnelles** : Niveau d'étude, spécialité, années d'expérience, compétences clés, disponibilité, tarif journalier, devise, et statut.
*   **Types de personnel** : Le système permet de catégoriser le personnel en différents types (Consultant, Formateur, Agent de Collecte, Volontaire, Stagiaire), ce qui est crucial pour l'application de critères d'évaluation spécifiques.
*   **Historique des évaluations** : Chaque fiche de personnel peut afficher un historique complet de toutes les évaluations passées, offrant une vue d'ensemble de la performance au fil du temps.

### 2. Gestion des Évaluations du Personnel

Le cœur de cette application réside dans son système d'évaluation flexible, permettant d'évaluer le personnel en fonction de critères pertinents. Ce module est conçu pour être intuitif et complet.

*   **Création d'évaluations** : Permet d'enregistrer de nouvelles évaluations pour un personnel temporaire donné, en spécifiant l'évaluateur, le contexte de la mission et la date de l'évaluation.
*   **Critères dynamiques** : Lors de la création ou de la modification d'une évaluation, les critères d'évaluation pertinents sont chargés dynamiquement en fonction du type de personnel sélectionné. Cela garantit que seules les compétences et les qualités appropriées sont évaluées.
    *   Les critères peuvent être **généraux** (applicables à tous les types de personnel) ou **spécifiques** à un certain type de personnel (par exemple, des critères différents pour un 


Consultant vs. un Agent de Collecte).
*   **Notation pondérée** : Chaque critère d'évaluation possède un poids, permettant de refléter son importance relative dans le calcul du score total de l'évaluation. Les notes sont généralement sur une échelle de 0 à 5.
*   **Calcul automatique du score** : Le système calcule automatiquement un score total pour chaque évaluation, basé sur les notes attribuées à chaque critère et leurs poids respectifs.
*   **Historique et suivi** : Toutes les évaluations sont stockées et peuvent être consultées à tout moment, offrant un historique de performance pour chaque membre du personnel.

### 3. Gestion des Critères d'Évaluation

Ce module permet une administration flexible des critères utilisés pour les évaluations, assurant que le système d'évaluation reste pertinent et adaptable aux besoins changeants.

*   **Création et modification des critères** : Les administrateurs peuvent définir de nouveaux critères d'évaluation, spécifier leur nom, leur description, leur poids et s'ils sont actifs ou non.
*   **Association aux types de personnel** : Chaque critère peut être associé à un type de personnel spécifique ou être défini comme un critère général (applicable à tous les types de personnel). Cette flexibilité est essentielle pour des évaluations précises.
*   **Activation/Désactivation des critères** : Les critères peuvent être activés ou désactivés, permettant de les inclure ou de les exclure des évaluations sans les supprimer définitivement.
*   **Prévention de la suppression** : Le système empêche la suppression d'un critère s'il est déjà utilisé dans des évaluations existantes, garantissant l'intégrité des données historiques.




## Structure du Projet

Le projet suit l'architecture MVC (Model-View-Controller) de Laravel, organisée de manière standard pour faciliter la compréhension et la maintenance. Voici une vue d'ensemble des répertoires et fichiers clés :

*   **`app/`** : Contient le code source de l'application.
    *   **`app/Models/`** : Définit les modèles Eloquent qui interagissent avec la base de données. Vous y trouverez des modèles comme `PersonnelTemporaire`, `Evaluation`, `CritereEvaluation`, `NoteCritere`, `TypePersonnel`, etc.
    *   **`app/Http/Controllers/`** : Gère la logique métier et les requêtes HTTP. Inclut `PersonnelTemporaireController`, `EvaluationController`, `CritereEvaluationController`, etc.
*   **`routes/`** : Définit les routes de l'application.
    *   **`routes/web.php`** : Contient les routes web pour l'interface utilisateur.
    *   **`routes/api.php`** : Contient les routes pour les API, notamment celle utilisée pour le chargement dynamique des critères.
*   **`resources/views/`** : Contient les fichiers de vue Blade (`.blade.php`) qui définissent l'interface utilisateur.
    *   **`resources/views/evaluations/`** : Vues spécifiques aux évaluations (liste, création, modification).
    *   **`resources/views/criteres/`** : Vues spécifiques aux critères d'évaluation (liste, création, modification).
*   **`database/`** : Contient les fichiers liés à la base de données.
    *   **`database/migrations/`** : Définit la structure de la base de données (tables, colonnes, relations).
    *   **`database/seeders/`** : Contient les classes pour populer la base de données avec des données initiales ou de test (`TypePersonnelSeeder`, `CritereEvaluationSeeder`, `DatabaseSeeder`).
*   **`.env`** : Fichier de configuration de l'environnement (non versionné).
*   **`composer.json`** : Définit les dépendances PHP du projet.




## Utilisation des Fonctionnalités

Cette section vous guide sur la manière d'interagir avec les nouvelles fonctionnalités de gestion des évaluations et des critères d'évaluation.

### Accès à l'Application

Après avoir suivi les étapes d'installation et de configuration et lancé le serveur de développement (`php artisan serve`), ouvrez votre navigateur et accédez à l'URL de votre application (généralement `http://127.0.0.1:8000`). Connectez-vous avec les identifiants par défaut (`admin@cerd.org` / `password`).

### Gestion des Critères d'Évaluation

Pour gérer les critères d'évaluation :

1.  **Naviguer vers la page des critères** : Accédez à l'URL `/criteres` dans votre navigateur, ou utilisez le lien correspondant dans le menu de navigation de l'application si un tel lien a été implémenté dans l'interface utilisateur.
2.  **Voir les critères existants** : La page affichera une liste de tous les critères d'évaluation pré-remplis par le seeder, ainsi que ceux que vous avez ajoutés manuellement. Pour chaque critère, vous verrez son nom, sa description, le type de personnel auquel il est associé (ou 


« Tous » s'il est général), son poids et son statut (Actif/Inactif).
3.  **Ajouter un nouveau critère** : Cliquez sur le bouton "Ajouter un Critère". Remplissez le formulaire avec les informations suivantes :
    *   **Nom du critère** : Un nom court et descriptif (ex: "Capacité d'analyse").
    *   **Description** : Une explication plus détaillée du critère.
    *   **Type de personnel (optionnel)** : Sélectionnez le type de personnel auquel ce critère s'applique. Laissez vide pour un critère général.
    *   **Poids** : Un nombre décimal (ex: 1.0, 1.5) qui indique l'importance de ce critère dans le calcul du score total. Un poids plus élevé signifie une plus grande influence.
    *   **Critère actif** : Cochez cette case pour que le critère soit disponible pour les évaluations. Décochez-la pour le désactiver temporairement.
    Cliquez sur "Enregistrer le critère" pour soumettre.
4.  **Modifier un critère** : Sur la liste des critères, cliquez sur le bouton "Modifier" à côté du critère que vous souhaitez ajuster. Modifiez les informations nécessaires et enregistrez les changements.
5.  **Activer/Désactiver un critère** : Sur la liste des critères, utilisez le bouton "Activer" ou "Désactiver" pour changer rapidement le statut d'un critère. Un critère inactif n'apparaîtra pas dans les formulaires d'évaluation.
6.  **Supprimer un critère** : Cliquez sur le bouton "Supprimer" à côté du critère. Une confirmation vous sera demandée. Notez qu'un critère ne peut pas être supprimé s'il est déjà utilisé dans des évaluations existantes pour préserver l'intégrité des données.

### Gestion des Évaluations du Personnel

Pour créer et gérer les évaluations :

1.  **Naviguer vers la page des évaluations** : Accédez à l'URL `/evaluations` dans votre navigateur, ou utilisez le lien correspondant dans le menu de navigation.
2.  **Voir les évaluations existantes** : La page affichera une liste de toutes les évaluations enregistrées, avec le personnel évalué, l'évaluateur, la date et le score total.
3.  **Ajouter une nouvelle évaluation** : Cliquez sur le bouton "Ajouter une Évaluation".
    *   **Personnel à évaluer** : Sélectionnez le personnel temporaire dans la liste déroulante. **Important :** Une fois le personnel sélectionné, les critères d'évaluation pertinents (généraux et spécifiques à son type de personnel) se chargeront dynamiquement en dessous.
    *   **Nom de l'évaluateur** : Entrez le nom de la personne qui réalise l'évaluation.
    *   **Date d'évaluation** : Sélectionnez la date de l'évaluation.
    *   **Contexte de la mission (optionnel)** : Fournissez des détails sur la mission ou le contexte de l'évaluation.
    *   **Notes des critères** : Pour chaque critère affiché, entrez une note (généralement de 0 à 5). Le score total sera calculé automatiquement à la soumission.
    Cliquez sur "Enregistrer l'évaluation" pour soumettre.
4.  **Voir les détails d'une évaluation** : Cliquez sur le bouton "Voir" à côté d'une évaluation pour afficher tous les détails, y compris les notes individuelles pour chaque critère.
5.  **Modifier une évaluation** : Cliquez sur le bouton "Modifier" à côté d'une évaluation. Vous pourrez ajuster les informations générales et les notes des critères. Les critères se chargeront dynamiquement comme lors de la création, et les notes existantes seront pré-remplies.
6.  **Supprimer une évaluation** : Cliquez sur le bouton "Supprimer" à côté d'une évaluation. Une confirmation vous sera demandée. La suppression d'une évaluation entraînera également la suppression de toutes les notes de critères associées.

### Historique des Évaluations d'un Personnel

Pour consulter l'historique des évaluations d'un personnel spécifique :

1.  **Accéder à la fiche du personnel** : Naviguez vers la page de détail d'un personnel (par exemple, `/personnel/{id}`).
2.  **Voir l'historique** : Un lien ou une section dédiée sur cette page vous permettra de consulter toutes les évaluations passées de ce personnel, offrant une vue chronologique de ses performances.




## Technologies Utilisées

Ce projet est construit sur la base des technologies suivantes :

*   **Laravel** (PHP Framework) : Version 10.x
*   **PHP** : Version 8.1 ou supérieure
*   **MySQL** : Base de données relationnelle
*   **Composer** : Gestionnaire de dépendances PHP
*   **HTML5 / CSS3** : Pour la structure et le style des pages web
*   **JavaScript (ES6+)** : Pour les interactions dynamiques côté client, notamment le chargement AJAX des critères d'évaluation.
*   **Tailwind CSS** : Framework CSS utilitaire pour un développement rapide de l'interface utilisateur (si utilisé dans le projet).
*   **Laravel Breeze / Livewire** : Pour l'authentification et les composants dynamiques (si utilisés dans le projet).





## Commandes Essentielles Avant le Lancement

Avant de lancer l'application Laravel, assurez-vous d'exécuter les commandes suivantes dans l'ordre spécifié pour garantir que toutes les dépendances sont installées, la base de données est configurée et l'application est prête à fonctionner.

1.  **Installation des dépendances Composer** :
    Cette commande installe toutes les bibliothèques PHP nécessaires définies dans `composer.json`.
    ```bash
    composer install
    ```

2.  **Copie du fichier d'environnement** :
    Crée une copie du fichier d'exemple `.env.example` pour votre configuration locale. Vous devrez ensuite éditer ce fichier pour configurer votre base de donnée.
    ```bash
    cp .env.example .env
    ```

3.  **Génération de la clé d'application** :
    Génère une clé d'application unique requise par Laravel pour la sécurité.
    ```bash
    php artisan key:generate
    ```

4.  **Création de la base de données (si elle n'existe pas)** :
    Assurez-vous que votre base de données MySQL est en cours d'exécution. Vous pouvez créer la base de données `gestion_personnel` (ou le nom que vous avez choisi dans `.env`) manuellement ou via la ligne de commande (remplacez `votre_utilisateur_mysql` par votre utilisateur MySQL et entrez votre mot de passe lorsque demandé) :
    ```bash
    mysql -u votre_utilisateur_mysql -p -e "CREATE DATABASE IF NOT EXISTS gestion_personnel;"
    ```
    Si vous utilisez un utilisateur spécifique pour Laravel (comme `laravel_user` avec `password`), assurez-vous qu'il a les privilèges nécessaires :
    ```bash
    sudo mysql -e "CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'password';"
    sudo mysql -e "GRANT ALL PRIVILEGES ON gestion_personnel.* TO 'laravel_user'@'localhost';"
    sudo mysql -e "FLUSH PRIVILEGES;"
    ```

5.  **Exécution des migrations et des seeders** :
    Cette commande supprime toutes les tables existantes, exécute toutes les migrations pour recréer la structure de la base de données, puis exécute les seeders pour populer la base de données avec des données initiales (types de personnel, critères d'évaluation, etc.).
    ```bash
    php artisan migrate:fresh --seed
    ```

Une fois ces commandes exécutées avec succès, vous pouvez lancer le serveur de développement Laravel avec `php artisan serve`.
