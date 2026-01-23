# TomTroc - Plateforme d'échange de livres

Projet utilisé dans le cadre d'une formation OpenClassrooms.

## Prérequis

- PHP 8.0 ou supérieur
- MySQL 5.7+ ou MariaDB 10.6+
- Serveur web (Apache recommandé)
- XAMPP (ou environnement équivalent LAMP/WAMP)

## Installation

### 1. Cloner ou télécharger le projet

Placez le projet dans le répertoire `htdocs` de votre installation XAMPP :

```
c:\xampp\htdocs\Tomtroc\
```

### 2. Configuration de la base de données

#### Créer la base de données

1. Démarrez XAMPP et lancez Apache et MySQL
2. Accédez à phpMyAdmin : [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
3. Créez une nouvelle base de données nommée `tomtroc`

#### Importer les données

1. Sélectionnez la base de données `tomtroc`
2. Cliquez sur l'onglet "Importer"
3. Choisissez le fichier `tomtroc.sql` situé à la racine du projet
4. Cliquez sur "Exécuter"

La base de données sera créée avec les tables suivantes :

- `user` : Gestion des utilisateurs
- `book` : Catalogue des livres
- `thread` : Conversations entre utilisateurs
- `thread_message` : Messages des conversations

### 3. Configuration du projet

1. Créez un fichier `config/config.php` à partir du fichier `config/_config.php`
2. Éditez le fichier `config/config.php` et modifiez les paramètres de connexion à la base de données si nécessaire :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'tomtroc');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Installation des dépendances (optionnel)

Si vous souhaitez utiliser Tailwind CSS pour le développement :

```bash
npm install
```

## Lancer le projet

1. Assurez-vous que Apache et MySQL sont démarrés dans XAMPP
2. Accédez au projet dans votre navigateur : [http://localhost/Tomtroc](http://localhost/Tomtroc)

## Connexion

### Comptes de test

Le mot de passe par défaut pour tous les comptes est : **tomtroc**

Exemples de comptes disponibles :

- `camille.c@tomtroc.fr`
- `alexl@tomtroc.fr`
- `j.doe@tomtroc.fr`

## Structure du projet

```
Tomtroc/
├── config/           # Configuration de l'application
├── controllers/      # Contrôleurs MVC
├── models/          # Modèles et gestion des données
├── views/           # Vues et templates
├── public/          # Ressources publiques (CSS, JS, images)
├── services/        # Services utilitaires
├── index.php        # Point d'entrée de l'application
└── tomtroc.sql      # Script de création de la base de données
```

## Fonctionnalités

- Inscription et connexion des utilisateurs
- Ajout et gestion de livres
- Système de messagerie entre utilisateurs
- Consultation des profils
- Échange de livres

## Dépannage

### Erreur de connexion à la base de données

Vérifiez que :

- MySQL est bien démarré dans XAMPP
- Les identifiants dans `config/config.php` sont corrects
- La base de données `tomtroc` existe et contient les tables

### Page blanche

Activez l'affichage des erreurs PHP dans votre configuration ou consultez les logs d'erreur Apache.

## Copyright

Projet utilisé dans le cadre d'une formation OpenClassrooms.
