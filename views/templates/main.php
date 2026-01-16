<?php

/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="./public/tomtroc.css">
</head>

<body>
    <header class="header">
        <nav role="navigation" aria-label="main navigation" class="navbar">
            <div class="navbar-start">
                <img class="logo max-sm:w-19.5 md:w-38.75" src="./public/img/logo.svg" alt="Logo Tom Troc entier" />
            </div>

            <div class="navbar-center">

            </div>

            <!-- Menu burger (mobile) -->
            <div class="navbar-end">
                <div class="dropdown md:hidden">
                    <button tabindex="0" class="btn btn-square btn-ghost" aria-label="menu">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block h-5 w-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <ul class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li><a href="?action=home">Accueil</a></li>

                        <li><a href="?action=showbooks">Nos livres à l'échange</a></li>
                        <li><a href="?action=showthreads">Messagerie</a></li>
                        <li><a href="?action=showmyaccount">Mon compte</a></li>
                        <li><a href="?action=showconnectionform">Connexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>

    <footer class="footer">
        <a href="#">Politique de confidentialité</a>
        <a href="#">Mentions légales</a>
        <p>Tom Troc©</p>
        <img src="./public/img/tt.svg" alt="Logo Tom Troc avec les initiales" />
    </footer>

</body>

</html>