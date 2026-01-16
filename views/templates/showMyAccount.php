<?php

/**
 * Template pour afficher la page "Mon compte".
 */
?>


<section class="account-container">

    <!-- Bloc profil -->
    <div>
        <img src="<?= Utils::getUserPictureUrl($user->getProfilePicture()) ?>" alt="photo de profil" />
    </div>

    <h2>
        <?= htmlspecialchars($user->getUsername()) ?>
    </h2>

    <p>
        Membre depuis
        <?= Utils::convertDateToFrenchFormat($user->getDateCreation()) ?>
    </p>

    <p>BIBLIOTHÈQUE</p>
    <span>📚</span>
    <strong>
        <?= htmlspecialchars(count($books)) ?> livre
        <?= count($books) > 1 ? 's' : '' ?>
    </strong>
    </div>

    <!-- Bloc informations personnelles -->

    <form method="POST" action="?action=showMyAccount&id=<?= $user->getId() ?>"></form>

    <label for="email">Adresse email</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>">

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password">

    <label for="username">Pseudo</label>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>">

    <button type="submit" class="tomtroc-button grey">Enregistrer</button>

    </form>


    <!-- Tableau des livres -->
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Statut</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td>
                        <img src="<?= Utils::getBookPictureUrl($book->getPicture()) ?>" alt="photo du livre">
                    </td>

                    <td>
                        <?= htmlspecialchars($book->getTitle()) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($book->getAuthor()) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($book->getStatus()) ?>
                    </td>

                    <td>
                        <em>
                            <?php
                            $desc = htmlspecialchars($book->getDescription());
                            echo mb_strlen($desc) > 80
                                ? mb_substr($desc, 0, 80) . '...'
                                : $desc;
                            ?>
                        </em>
                    </td>

                    <td>
                        <a href="?action=editbookform&id=<?= $book->edit() ?>">Éditer</a>
                        <a href="?action=deletebook&id=<?= $book->getId() ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Bouton créer un livre -->
    <a href="editBook.php" class="tomtroc-button principal-green">Créer un livre</a>

</section>