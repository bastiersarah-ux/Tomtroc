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
                        <img id="image-preview" src="<?= Utils::getUserPictureUrl($user->getProfilePicture()) ?>"
                            alt="photo de profil" />
                    </div>
                </div>
                <?php if ($owner): ?>
                    <btn id="btn-image-input" class="link label">modifier</btn>
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

            <form action="?action=editmyprofile" method="post" enctype="multipart/form-data">
                <fieldset class="fieldset">
                    <input type="file" name="picture" id="image-input-field" accept="image/*" hidden>

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
                                <button class="link link-error" onclick="showModal(<?= $book->getId() ?>);">Supprimer</button>

                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($owner): ?>
            <dialog id="delete-dialog" class="modal">
                <div class="modal-box">
                    <h3>Suppression</h3>
                    <p class="py-4">Êtes-vous sûr·e de vouloir supprimer ce livre ?</p>
                    <div class="modal-action">
                        <form method="dialog">
                            <button class="btn btn-ghost">Non</button>
                            <a id="delete-anchor" class="btn btn-ghost btn-error" href="#">Oui</a>
                        </form>
                    </div>
                </div>
            </dialog>
        <?php endif; ?>
    </section>
</section>

<?php if ($owner): ?>
    <script src="./public/edit-image.js"></script>
    <script>
        function showModal(id) {
            const dialog = document.getElementById("delete-dialog");
            dialog.showModal();
            const anchor = document.querySelector("#delete-anchor");
            anchor.href = `?action=deletebook&id=${id}`;
        }
    </script>
    <script>
        (function () {
            let alert = document.querySelector('#error-alert');
            if (!!alert) {
                setTimeout(() => alert.remove(), 3000);
            }
        })()
    </script>
<?php endif; ?>