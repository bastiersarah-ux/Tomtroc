<?php

/**
 * Template pour afficher la page "Mon compte".
 */
?>

<h1 class="page-title">Mon compte</h1>

<section class="account-container">

    <!-- Bloc profil -->
    <div class="profile-card">
        <div class="profile-picture">
            <img src="<?= $user['profile_picture'] ?>" alt="photo de profil">
        </div>

        <div class="avatar">
            <div class="w-24 rounded-xl">
                <img src="https://img.daisyui.com/images/profile/demo/yellingwoman@192.webp" />
            </div>
        </div>
        <div class="avatar">
            <div class="w-24 rounded-full">
                <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
            </div>
        </div>

        <a href="#" class="edit-photo">modifier</a>

        <h2 class="username"><?= $user['username'] ?></h2>
        <p class="member-since">Membre depuis <?= $user['membre_depuis'] ?></p>

        <div class="library-info">
            <p class="library-title">BIBLIOTHÈQUE</p>
            <span class="icon">📚</span>
            <strong><?= $user['nb_livres'] ?> livres</strong>
        </div>
    </div>


    <!-- Bloc informations personnelles -->
    <form method="POST" action="update_user.php">

        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email" value="<?= $user['email'] ?>">

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password">

        <label for="pseudo">Pseudo</label>
        <input type="text" id="username" name="username" value="<?= $user['username'] ?>">

        <button type="submit" class="save-btn">Enregistrer</button>
    </form>


    <!-- Tableau des livres -->
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><img src="<?= $book['photo'] ?>" class="book-picture"></td>

                <td><?= $book['title'] ?></td>

                <td><?= $book['author'] ?></td>

                <td><em><?= $book['description'] ?></em></td>

                <td>
                    <?php if ($book['disponible']): ?>
                        <span class="badg- dispo">disponible</span>
                    <?php else: ?>
                        <span class="badge-no-dispo">non dispo.</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="edit.php?id=<?= $book['id'] ?>" class="edit">Éditer</a>
                    <a href="delete.php?id=<?= $book['id'] ?>" class="delete">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>