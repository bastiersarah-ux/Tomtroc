<?php

/**
 * Template pour afficher le formulaire de connexion.
 */
?>

<div class="connection-form">
    <form action="index.php?action=connectUser" method="post" class="foldedCorner">
        <h2>Connexion</h2>
        <div class="formGrid">
            <label for="username">Pseudo</label>
            <input type="text" name="username id=" username" required>
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            <button class="submit">S'inscrire</button>
        </div>
    </form>
    <p>Pas de compte ? <a href="index.php?action=inscriptionForm" style="text-decoration: underline;">Inscrivez-vous</a></p>
    <img src="./public/img/connectionform.svg" alt="Bibliothèque" />

</div>