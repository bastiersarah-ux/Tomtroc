<?php

/**
 * Contrôleur de gestion des utilisateurs.
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
        $view = new View("Mon compte");
        $view->render("showUserProfile", [
            'user' => $user,
            'books' => $books,
            'owner' => true
        ]);
    }

    /**
     * Affiche le profil public d'un utilisateur.
     * @return void
     */
    public function showUserProfile(): void
    {
        // Récupère le slug de l'utilisateur demandé dans l'URL.
        $slug = Utils::request('user');

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
        $view = new View("Profil " . $user->getUserName());
        $view->render("showUserProfile", [
            'user' => $user,
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
        $this->redirectIfConnected();

        // Affiche la page du profil utilisateur
        $view = new View("Inscription");
        $view->render("showInscriptionForm");
    }

    /**
     * Affiche le formulaire de connexion.
     * @return void
     */
    public function showConnectionForm(): void
    {
        $this->redirectIfConnected();

        // Affiche la page du profil utilisateur
        $view = new View("Authentification");
        $view->render("showConnectionForm");
    }

    /**
     * Connecte un utilisateur en validant ses identifiants.
     * @return void
     */
    public function connectUser(): void
    {
        // On récupère les données du formulaire
        $email = Utils::request("email");
        $password = Utils::request("password");

        // On vérifie que les données sont valides
        if (empty($email) || empty($password)) {
            View::sendErrorAlert("Tous les champs sont obligatoires.");
            Utils::redirect('showconnectionform');
            return;
        }

        // On vérifie que l'utilisateur existe
        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);
        if (!$user) {
            View::sendErrorAlert("Vos identifiants sont incorrects.");
            Utils::redirect('showconnectionform');
            return;
        }

        // On vérifie que le mot de passe est correct
        if (!password_verify($password, $user->getPassword())) {
            View::sendErrorAlert("Vos identifiants sont incorrects.");
            Utils::redirect('showconnectionform');
            return;
        }

        // On connecte l'utilisateur
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page du compte utilisateur
        Utils::redirect("showMyAccount");
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
            View::sendErrorAlert("Tous les champs sont obligatoires.");
            Utils::redirect('showInscriptionForm');
            return;
        }

        // On vérifie si l'email est valdie
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            View::sendErrorAlert("L'adresse email n'est pas valide.");
            Utils::redirect('showInscriptionForm');
            return;
        }

        try {
            $username = strtolower($username);

            $userManager = new UserManager();

            // On vérifie si l'utilisateur existe déjà
            if ($userManager->checkIfEmailUsed($email)) {
                View::sendErrorAlert("Un compte existe déjà avec cet email.");
                Utils::redirect('showInscriptionForm');
                return;
            }

            // On vérifie si le username est déjà pris
            if ($userManager->checkIfUsernameUsed($username)) {
                View::sendErrorAlert("Un compte existe déjà avec ce pseudo.");
                Utils::redirect('showmyaccount');
                return;
            }

            // On génère un slug basé sur le username
            $slug = Utils::slugify($username);

            // On enregistre l’utilisateur
            $idUser = $userManager->registerUser($email, $username, $password, $slug);
        } catch (Exception $ex) {
            View::sendErrorAlert(
                "Une erreur est survenue lors de l'inscription. Veuillez réessayer ultérieurement ou contacter l'administrateur."
            );
            Utils::redirect('showInscriptionForm');
            return;
        }

        // On stocke en session l'id de l'utilisateur, ce qui le connecte
        $_SESSION['idUser'] = $idUser;

        // On redirige vers la page du compte utilisateur
        Utils::redirect("showMyAccount");
    }

    /**
     * Modifie l'utilisateur connecté.
     * @return void
     */
    public function editUser(): void
    {
        // Vérifie que l’utilisateur est connecté
        $this->checkIfUserIsConnected();

        // On récupère les données du formulaire
        $username = Utils::request("username");
        $email = Utils::request("email");
        $password = Utils::request("password");
        $picture = $_FILES['picture'];

        // On vérifie si les champs obligatoires sont remplis
        if (empty($username) || empty($email)) {
            View::sendErrorAlert("Tous les champs sont obligatoires.");
            Utils::redirect('showmyaccount');
            return;
        }

        // On vérifie si l'email est valdie
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            View::sendErrorAlert("L'adresse email n'est pas valide.");
            Utils::redirect('showmyaccount');
            return;
        }

        try {
            $userManager = new UserManager();
            $user = $userManager->getUserById($this->getConnectedUserId());
            $username = strtolower($username);

            // On vérifie si le mail est déjà pris
            if ($userManager->checkIfEmailUsed($email) && strtolower($user->getEmail()) != strtolower($email)) {
                View::sendErrorAlert("Un compte existe déjà avec cet email.");
                Utils::redirect('showmyaccount');
                return;
            }

            // On vérifie si le username est déjà pris
            if ($userManager->checkIfUsernameUsed($username) && strtolower($user->getUserName()) != $username) {
                View::sendErrorAlert("Un compte existe déjà avec ce pseudo.");
                Utils::redirect('showmyaccount');
                return;
            }


            $filename = Utils::generateNewFilename($picture, $user->getProfilePicture());
            // On génère un slug basé sur le username
            $slug = Utils::slugify($username);

            $password = empty($password)
                ? $user->getPassword()
                : password_hash($password, PASSWORD_DEFAULT);

            // On enregistre l’utilisateur
            $userManager->updateUser(
                $user->getId(),
                $email,
                $username,
                $password,
                $slug,
                $filename
            );

            Utils::savePicture($picture, $filename, "users");

            View::sendSuccessAlert("Information enregistré avec succès");
        } catch (Exception $ex) {
            View::sendErrorAlert(
                "Une erreur est survenue lors de la modification des informations. Veuillez réessayer ultérieurement ou contacter l'administrateur."
            );
            Utils::redirect('showmyaccount');
            return;
        }

        // On redirige vers la page du compte utilisateur
        Utils::redirect("showmyaccount");
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

    /**
     * Redirige vers le compte utilisateur si l'utilisateur est déjà connecté.
     * @return void
     */
    private function redirectIfConnected(): void
    {
        if (!empty($_SESSION['idUser'])) {
            // On redirige vers la page du compte utilisateur
            Utils::redirect("showMyAccount");
        }
    }
}
