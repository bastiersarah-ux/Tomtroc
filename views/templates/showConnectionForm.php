<?php

/**
 * Template pour afficher le formulaire de connexion.
 */
?>

<section class="form-container">

    <h2>Connexion</h2>
    <form action="?action=connectuser" method="post">
        <?php if (!empty($errorMessage)): ?>
            <div id="connection-error-alert" role="alert" class="alert alert-error">
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
        <fieldset class="fieldset">
            <label class="label" for="email">Adresse email</label>
            <input class="input" type="text" name="email" id="email" required>
            <label class="label" for="password">Mot de passe</label>
            <input class="input" type="password" name="password" id="password" required>
            <input type="submit" class="tomtroc-button principal-green" value="Se connecter" />
        </fieldset>
    </form>
    <p class="link-container">
        Pas de compte ? <a href="index.php?action=showinscriptionform">Inscrivez-vous</a>
    </p>
</section>
<figure>
    <img src="./public/img/connectionform.svg" alt="Bibliothèque" />
</figure>

<script>
    (function () {
        let alert = document.querySelector('#connection-error-alert');
        if (!!alert) {
            setTimeout(() => alert.remove(), 5000);
        }
    })()
</script>