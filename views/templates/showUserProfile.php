<?php
/**
 * Template pour afficher la page de profil d'un utilisateur.
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

    <!-- Tableau des livres -->
    <table class="books-table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Description</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><img src="<?= Utils::getBookPictureUrl($book->getPicture()) ?>" alt="photo du livre"></td>

                    <td>
                        <?= htmlspecialchars($book->getTitle()) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($book->getAuthor()) ?>
                    </td>
                    <td><em>
                            <?= htmlspecialchars($book->getDescription()) ?>
                        </em></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</section>