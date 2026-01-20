<?php

/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */

/**
 * Calcul si la page courante correspond à l'entrée du menu courant. Renvoie la classe active ou une chaine vide
 * @param mixed $action
 * @return string
 */
function menuClass($action): string
{
    $current = Utils::request("action", "home");
    return $current == $action ? "active" : "";
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="./public/tomtroc.css">
    <link rel="icon" type="image/x-icon" href="./public/favicon.ico">
</head>

<body>
    <header class="header">
        <nav role="navigation" aria-label="main navigation" class="navbar max-lg:justify-between">
            <a class="navbar-start" href="?action=home">
                <img class="logo" src="./public/img/logo.svg" alt="Logo Tom Troc entier" />
            </a>

            <div class="navbar-center">
                <ul class="menu menu-horizontal">
                    <li class="<?= menuClass('home') ?>">
                        <a href="?action=home">Accueil</a>
                    </li>
                    <li class="<?= menuClass('showbooks') ?>">
                        <a href="?action=showbooks">Nos livres à l'échange</a>
                    </li>
                </ul>
            </div>

            <!-- Menu burger (mobile) -->
            <div class="navbar-end">
                <ul class="menu menu-horizontal">
                    <?php if (Utils::hasUserConnected()): ?>
                        <li class="thread-menu <?= menuClass('showthreads') ?>">
                            <a href="?action=showthreads">
                                <img class="message-icon" src="./public/img/messagerie.svg" alt="Icône messagerie" />
                                Messagerie
                            </a>
                        </li>
                        <li class="<?= menuClass('showmyaccount') ?>">
                            <a href="?action=showmyaccount">
                                <img class="account-icon" src="./public/img/account.svg" alt="Icône mon compte" />
                                Mon compte
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="?action=<?= Utils::hasUserConnected() ? 'disconnectuser' : 'showconnectionform' ?>">
                            <?= Utils::hasUserConnected() ? 'Déconnexion' : 'Connexion' ?>
                        </a>
                    </li>
                </ul>
                <div id="mobile-menu" class="dropdown dropdown-end">
                    <button tabindex="0" class="btn btn-square btn-ghost" aria-label="menu">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block h-5 w-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <ul class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li class="<?= menuClass('home') ?>">
                            <a class="p-5" href="?action=home">Accueil</a>
                        </li>
                        <li class="<?= menuClass('showbooks') ?>">
                            <a class="p-5" href="?action=showbooks">Nos livres à l'échange</a>
                        </li>
                        <?php if (Utils::hasUserConnected()): ?>
                            <li class="thread-menu <?= menuClass('showthreads') ?>">
                                <a class="p-5" href="?action=showthreads">
                                    <img class="message-icon" src="./public/img/messagerie.svg" alt="Icône messagerie" />
                                    Messagerie
                                </a>
                            </li>
                            <li class="<?= menuClass('showmyaccount') ?>">
                                <a class="p-5" href="?action=showmyaccount">
                                    <img class="account-icon" src="./public/img/account.svg" alt="Icône mon compte" />
                                    Mon compte
                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a class="p-5"
                                href="?action=<?= Utils::hasUserConnected() ? 'disconnectuser' : 'showconnectionform' ?>">
                                <?= Utils::hasUserConnected() ? 'Déconnexion' : 'Connexion' ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main id="<?= $idPage ?>">
        <div id="message-container">
            <?php if (!empty($successMessage)): ?>
                <div id="success-alert" role="alert" class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>
                        <?= $successMessage ?>
                    </span>
                </div>
            <?php endif; ?>
            <?php if (!empty($errorMessage)): ?>
                <div id="error-alert" role="alert" class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>
                        <?= $errorMessage ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>

    <footer class="footer">
        <a href="#">Politique de confidentialité</a>
        <a href="#">Mentions légales</a>
        <p>Tom Troc©</p>
        <img src="./public/img/tt.svg" alt="Logo Tom Troc avec les initiales" />
    </footer>

    <?php if (Utils::hasUserConnected()): ?>
        <script src="./public/main.js"></script>
    <?php endif; ?>

    <script>
        (function () {
            let alert = document.querySelector('#success-alert');
            if (!!alert) {
                setTimeout(() => alert.remove(), 3000);
            }
        })()
    </script>

    <script>
            (function () {
                let alert = document.querySelector('#error-alert');
                if (!!alert) {
                    setTimeout(() => alert.remove(), 3000);
                }
            })()
    </script>

</body>

</html>