<?php

/**
 * Template pour afficher le formulaire de connexion.
 */
?>

<div>
    <?php if (!empty($errorMessage)): ?>
        <div id="inscription-error-alert" role="alert" class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>
                <?= $errorMessage ?>
            </span>
        </div>
    <?php endif; ?>

    <form action="?action=showinscriptionform" method="post">
        <h3>Inscription</h3>
        <div class="formGrid">
            <label for="username">Pseudo</label>
            <input type="text" name="username" id="username" required>
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" class="tomtroc-button principal-green" value="S'inscrire'" />
        </div>
    </form>
    <p>Déjà inscrit ? <a href="index.php?action=showconnectionform"
            style="text-decoration: underline;">Connectez-vous</a>
    </p>
    <img src="./public/img/connectionform.svg" alt="Bibliothèque" />
</div>
<script>
    (function () {
        let alert = document.querySelector('#inscription-error-alert');
        if (!!alert) {
            setTimeout(() => alert.remove(), 5000);
        }
    })()
</script>