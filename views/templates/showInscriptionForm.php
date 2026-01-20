<?php

/**
 * Template pour afficher le formulaire de connexion.
 */
?>

<section class="form-container">
    <h2>Inscription</h2>
    <form action="?action=registeruser" method="post">
        <fieldset class="fieldset">
            <label class="label" for="username">Pseudo</label>
            <input class="input" type="text" name="username" id="username" required>
            <label class="label" for="email">Adresse email</label>
            <input class="input" type="text" name="email" id="email" required>
            <label class="label" for="password">Mot de passe</label>
            <input class="input" type="password" name="password" id="password" required>
            <input type="submit" class="tomtroc-button principal-green" value="S'inscrire" />
        </fieldset>
    </form>
    <p class="link-container">
        Déjà inscrit ? <a href="index.php?action=showconnectionform">Connectez-vous</a>
    </p>
</section>
<figure>
    <img src="./public/img/connectionform.svg" alt="Bibliothèque" />
</figure>