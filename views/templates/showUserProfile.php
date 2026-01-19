<?php
/**
 * Template pour afficher la page de profil d'un utilisateur.
 */
?>
<section class="profile-container">

    <!-- Bloc profil -->
    <section id="profile-bloc">
        <div class="card">
            <figure>
                <div class="avatar">
                    <div class="rounded-full">
                        <img src="<?= Utils::getUserPictureUrl($user->getProfilePicture()) ?>" alt="photo de profil" />
                    </div>
                </div>
                <?php if ($owner): ?>
                    <btn class="btn btn-link">modifier</btn>
                <?php endif; ?>
            </figure>
            <hr>
            <div class="card-body">
                <h4>
                    <?= htmlspecialchars($user->getUsername()) ?>
                </h4>

                <span class="label subtitle">
                    <?= $user->getTimeSinceCreation(); ?>
                </span>


                <div id="library-info">
                    <h6>BIBLIOTHÈQUE</h6>
                    <span id="book-number">
                        <figure class="logo">
                            <img src="./public/img/logo-book.svg" alt="Logo livre" />
                        </figure>
                        <?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?>
                    </span>
                </div>
                <?php if (!$owner): ?>
                    <a href="?action=sendmessage" class="tomtroc-button grey">Écrire un message</a>
                <?php endif; ?>
            </div>
        </div>
    </section>


    <?php if ($owner): ?>
        <section id="editprofile-bloc" class="card">
            <h5>Vos informations personnelles</h5>

            <form action="?action=editmyprofile" method="post">
                <?php if (!empty($errorMessage)): ?>
                    <div id="connexion-error-alert" role="alert" class="alert alert-error">
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
                    <input class="input" type="email" name="email" id="email" required
                        value="<?= htmlspecialchars($user->getEmail()) ?>">

                    <label class="label" for="password">Mot de passe</label>
                    <input class="input" type="password" name="password" id="password">


                    <label class="label" for="username">Pseudo</label>
                    <input class="input" type="text" name="username" id="username" required
                        value="<?= htmlspecialchars($user->getUsername()) ?>">

                    <input type="submit" class="tomtroc-button grey" value="Enregistrer" />
                </fieldset>
            </form>
        </section>
    <?php endif; ?>


    <section id="books-bloc" class="overflow-x-auto">
        <!-- Tableau des livres -->
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Description</th>
                    <?php if ($owner): ?>
                        <th>Disponibilité</th>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td>
                            <div class="avatar">
                                <img src="<?= Utils::getBookPictureUrl($book->getPicture()) ?>"
                                    alt="<?= $book->getTitle() ?>">
                            </div>
                            </div>
                        </td>
                        <td>
                            <?= htmlspecialchars($book->getTitle()) ?>

                        </td>
                        <td>
                            <?= htmlspecialchars($book->getAuthor()) ?>
                        </td>
                        <td class="description">
                            <span>
                                <?= htmlspecialchars($book->getDescription()) ?>
                            </span>
                        </td>
                        <?php if ($owner): ?>
                            <td class="disponibilite">
                                <div class="badge <?= $book->getStatus() == Book::INDISPONIBLE ? "error" : "success" ?>">
                                    <?= $book->getStatus() ?>
                                </div>
                            </td>
                            <td class="action">
                                <a class="link" href="?action=editbookform&id=<?= $book->getId() ?>">Éditer</a>
                                <a class="link link-error" href="?action=deletebook&id=<?= $book->getId() ?>">Supprimer</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</section>