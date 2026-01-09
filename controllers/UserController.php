<?php

/**
 * Contrôleur de la partie admin.
 */
class UserController extends AbstractController
{

    /**
     * Affiche la page de compte utilisateur.
     * @return void
     */
    public function showMyAccount(): void
    {
        // Vérifie si l’utilisateur est connecté
        $this->checkIfUserIsConnected();

        // Récupère l’ID de l’utilisateur via la session
        $idUser = $_SESSION['idUser'];

        // Récupère les données de l’utilisateur
        $userManager = new UserManager();
        $user = $userManager->getUserById($idUser);

        // Récupère tous les livres de l’utilisateur
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooksByIdUser($idUser);

        // Affiche la page du profil utilisateur
        $view = new View("MyAccount");
        $view->render("showMyAccount", [
            'user'  => $user,
            'books' => $books,
            'owner' => true
        ]);
    }

    /**
     * Affiche le profil public d'un utilisateur.
     * @return void
     */
    public function showUserProfil(): void
    {
        // Récupère le slug de l'utilisateur demandé dans l'URL.
        $slug = Utils::request('slug');

        if (!$slug) {
            Utils::redirect("notFound");
            return;
        }

        // Récupère les données de l’utilisateur
        $userManager = new UserManager();
        $user = $userManager->getUserBySlug($slug);

        if (!$user) {
            Utils::redirect("notFound");
            return;
        }

        // Récupère tous les livres de l’utilisateur
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooksByIdUser($user->getId());

        // Affiche la page du profil utilisateur
        $view = new View("UserProfile");
        $view->render("showUserProfile", [
            'user'  => $user,
            'books' => $books,
            'owner' => false
        ]);
    }

    /**
     * Affiche le formulaire d'inscription.
     * @return void
     */
    public function showInscriptionForm(): void
    {
        $errorMessage = $this->getAndClearVariableSession('inscriptionFormError');

        // Affiche la page du profil utilisateur
        $view = new View("Inscription");
        $view->render("InscriptionForm", [
            'errorMessage'  => $errorMessage,
        ]);
    }

    /**
     * Affiche le formulaire de connexion.
     * @return void
     */
    public function showConnectionForm(): void
    {
        // On récupère un éventuel message d'erreur
        $errorMessage = $this->getAndClearVariableSession('connectionFormError');

        // Affiche la page du profil utilisateur
        $view = new View("Authentification");
        $view->render("connectionForm", [
            'errorMessage'  => $errorMessage,
        ]);
    }

    /**
     * Connecte un utilisateur en validant ses identifiants.
     * @return void
     */
    public function connectUser(): void
    {
        // On récupère les données du formulaire
        $username = Utils::request("username");
        $password = Utils::request("password");

        // On vérifie que les données sont valides
        if (empty($username) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires. 1");
        }

        // On vérifie que l'utilisateur existe
        $userManager = new UserManager();
        $user = $userManager->getUserByUserName($username);
        if (!$user) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        // On vérifie que le mot de passe est correct
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            throw new Exception("Le mot de passe est incorrect : $hash");
        }

        // On connecte l'utilisateur
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page du compte utilisateur
        Utils::redirect("myAccount");
    }


    /**
     * Enregistre un nouvel utilisateur après validation des données.
     * @return void
     */
    public function registerUser(): void
    {
        // On récupère les données du formulaire
        $username = Utils::request("username");
        $email = Utils::request("email");
        $password = Utils::request("password");

        // On vérifie si les champs obligatoires sont remplis
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['inscriptionFormError'] = "Tous les champs sont obligatoires.";
            Utils::redirect('inscriptionForm');
            return;
        }

        // On vérifie si l'email est valdie
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['inscriptionFormError'] = "L'adresse email n'est pas valide.";
            Utils::redirect('inscriptionForm');
            return;
        }

        $userManager = new UserManager();

        // On vérifie si l'utilisateur existe déjà
        if ($userManager->getUserByEmail($email)) {
            $_SESSION['inscriptionFormError'] = "Un compte existe déjà avec cet email.";
            Utils::redirect('inscriptionForm');
            return;
        }

        // On génère un slug basé sur le username
        $slug = Utils::slugify($username);

        try {
            // On enregistre l’utilisateur
            $idUser = $userManager->registerUser($email, $username, $password, $slug);
        } catch (Exception $ex) {
            $_SESSION['inscriptionFormError'] =
                "Une erreur est survenue lors de l'inscription. Veuillez réessayer ultérieurement ou contacter l'administrateur.";
            Utils::redirect('inscriptionForm');
            return;
        }

        // On stocke en session l'id de l'utilisateur, ce qui le connecte
        $_SESSION['idUser'] = $idUser;

        // On redirige vers la page du compte utilisateur
        Utils::redirect("myAccount");
    }

    /**
     * Déconnecte l'utilisateur connecté.
     * @return void
     */
    public function disconnectUser(): void
    {
        // On déconnecte l'utilisateur
        unset($_SESSION['idUser']);

        // On redirige vers la page d'accueil
        Utils::redirect("home");
    }
}
