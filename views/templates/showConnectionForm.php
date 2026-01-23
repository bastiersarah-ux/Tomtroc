<?php

/**
 * Template pour afficher le formulaire de connexion.
 */
?>

<section class="form-container">

    <h2>Connexion</h2>
    <form action="?action=connectuser" method="post" autocomplete="on">
        <fieldset class="fieldset">
            <label class="label" for="email">Adresse email</label>
            <input class="input" type="email" name="email" id="email" autocomplete="username" required>
            <label class="label" for="password">Mot de passe</label>
            <input class="input" type="password" name="password" id="password" autocomplete="current-password" required>
            <input type="submit" class="tomtroc-button principal-green" value="Se connecter">
        </fieldset>
    </form>
    <p class="link-container">
        Pas de compte ? <a href="index.php?action=showinscriptionform">Inscrivez-vous</a>
    </p>
</section>
<figure>
    <img src="./public/img/connectionform.svg" alt="Bibliothèque">
</figure>