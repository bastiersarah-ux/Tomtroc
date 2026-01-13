<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $bookcontroller = new BookController();
            $bookcontroller->showHome();
            break;

        case 'showBooks':
            $bookcontroller = new BookController();
            $bookcontroller->showBooks();
            break;

        case 'showBookDetail':
            $bookcontroller = new BookController();
            $bookcontroller->showBookDetail();
            break;

        case 'showUserProfile':
            $userController = new UserController();
            $userController->showUserProfile();
            break;

        case 'showInscriptionForm':
            $userController = new UserController();
            $userController->showInscriptionForm();
            break;

        case 'showConnectionForm':
            $userController = new UserController();
            $userController->showconnectionForm();
            break;


        // Section utilisateur connecté 

        case 'connectUser':
            $userController = new UserController();
            $userController->connectUser();
            break;

        case 'registerUser':
            $userController = new UserController();
            $userController->registerUser();
            break;

        case 'myAccount':
            $userController = new UserController();
            $userController->showMyAccount();
            break;

        case 'editMyProfile':
            $userController = new UserController();
            $userController->editUser();
            break;

        case 'disconnectUser':
            $userController = new UserController();
            $userController->disconnectUser();
            break;

        case 'editBookForm':
            $bookController = new BookController();
            $bookController->showBookForm();
            break;

        case 'editBook':
            $bookController = new BookController();
            $bookController->addOrUpdateBookForm();
            break;

        case 'deleteBook':
            $bookController = new BookController();
            $bookController->deleteBook();
            break;

        // Section messagerie

        case 'showThreads':
            $threadController = new ThreadController();
            $threadController->showThreads();
            break;

        case 'createThread':
            $threadController = new ThreadController();
            $threadController->createThread();
            break;


        case 'sendMessage':
            $threadController = new ThreadController();
            $threadController->sendMessage();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
