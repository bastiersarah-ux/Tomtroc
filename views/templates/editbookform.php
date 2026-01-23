<?php

/**
 * Template pour modifier/créer un livre.
 */
?>

<article>
    <section id="page-container">
        <div class="page-header">
            <a href="?action=showmyaccount" class="label link link-hover">
                <img src="./public/img/arrow-left.svg" alt="flèche retour">
                <span>retour</span>
            </a>
            <h3>
                <?= $isEdit ? 'Modifier les informations' : 'Ajouter un livre' ?>
            </h3>
        </div>

        <form class="card" method="post" action="?action=editbook" enctype="multipart/form-data">
            <!-- Colonne gauche -->
            <fieldset class="fieldset">
                <label class="label">Photo</label>

                <img id="image-preview" src="<?= htmlspecialchars(Utils::getBookPictureUrl($book->getPicture())) ?>"
                    alt="photo du livre">

                <button id="btn-image-input" class="link">Modifler la photo</button>
                <input type="file" id="image-input-field" name="picture" accept="image/*" hidden>
            </fieldset>

            <!-- Colonne droite -->
            <fieldset class="fieldset">
                <label class="label" for="title">Titre</label>
                <input id="title" type="text" class="input" name="title"
                    value="<?= htmlspecialchars($book?->getTitle()) ?>" required>

                <label class="label" for="author">Auteur</label>
                <input id="author" type="text" class="input" name="author"
                    value="<?= htmlspecialchars($book?->getAuthor()) ?>" required>

                <label class="label" for="descrption">Description</label>
                <textarea id="descrption" class="textarea" name="description"><?= htmlspecialchars($book?->getDescription()) ?>
                </textarea>

                <label class="label" for="status">Disponibilité</label>
                <select id="status" class="select" name="status">
                    <option value="<?= Book::DISPONIBLE ?>" <?= $book?->getStatus() === Book::DISPONIBLE ? 'selected' : '' ?>>
                        Disponible
                    </option>
                    <option value="<?= Book::INDISPONIBLE ?>" <?= $book?->getStatus() === Book::INDISPONIBLE ? 'selected' : '' ?>>
                        Non disponible
                    </option>
                </select>

                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $book->getId() ?>">
                <?php endif; ?>

                <input class="tomtroc-button principal-green" type="submit"
                    value="<?= $isEdit ? 'Valider' : 'Créer le livre' ?>">
            </fieldset>
        </form>
    </section>
</article>

<script src="./public/edit-image.js"></script>
<script>
    (function () {
        let alert = document.querySelector('#error-alert');
        if (!!alert) {
            setTimeout(() => alert.remove(), 3000);
        }
    })()
</script>