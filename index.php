<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch (strtolower($action)) {
        // Pages accessibles à tous.
        case 'home':
            $coreController = new CoreController();
            $coreController->showHome();
            break;

        case 'showbooks':
            $bookcontroller = new BookController();
            $bookcontroller->showBooks();
            break;

        case 'showbookdetail':
            $bookcontroller = new BookController();
            $bookcontroller->showBookDetail();
            break;

        case 'showuserprofile':
            $userController = new UserController();
            $userController->showUserProfile();
            break;

        case 'showinscriptionform':
            $userController = new UserController();
            $userController->showInscriptionForm();
            break;

        case 'showconnectionform':
            $userController = new UserController();
            $userController->showconnectionForm();
            break;


        // Section utilisateur connecté 

        case 'connectuser':
            $userController = new UserController();
            $userController->connectUser();
            break;

        case 'registeruser':
            $userController = new UserController();
            $userController->registerUser();
            break;

        case 'showmyaccount':
            $userController = new UserController();
            $userController->showMyAccount();
            break;

        case 'editmyprofile':
            $userController = new UserController();
            $userController->editUser();
            break;

        case 'disconnectuser':
            $userController = new UserController();
            $userController->disconnectUser();
            break;

        case 'editbookform':
            $bookController = new BookController();
            $bookController->showBookForm();
            break;

        case 'editbook':
            $bookController = new BookController();
            $bookController->addOrUpdateBookForm();
            break;

        case 'deletebook':
            $bookController = new BookController();
            $bookController->deleteBook();
            break;

        // Section messagerie

        case 'showthreads':
            $threadController = new ThreadController();
            $threadController->showThreads();
            break;

        case 'createthread':
            $threadController = new ThreadController();
            $threadController->createThread();
            break;


        case 'sendmessage':
            $threadController = new ThreadController();
            $threadController->sendMessage();
            break;

        case 'unread':
            $threadController = new ThreadController();
            $threadController->countNonReadMessage();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
