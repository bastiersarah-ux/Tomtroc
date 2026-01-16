<?php

/**
 * Template pour modifier/créer un livre.
 */
?>
<title><?= $isEdit ? 'Modifier un livre' : 'Créer un livre' ?></title>

<section class="pt-13.5 pb-13.5">
    <a href="index.php" class="btn btn-link">
        <img src="./public/img/arrow-left.svg" alt="flèche retour" />
        <span>retour</span>
    </a>
    <h2 class="page-title">
        <?= $isEdit ? 'Modifier les informations' : 'Ajouter un livre' ?>
    </h2>

    <div class="card rounded-box bg-white">
        <form class="container" method="post" action="<?= $isEdit ? 'update.php' : 'store.php' ?>"
            enctype="multipart/form-data">

            <!-- Colonne gauche -->
            <fieldset>
                <label>Photo</label>

                <img src="<?= htmlspecialchars(Utils::getBookPictureUrl($book->getPicture())) ?>"
                    alt="photo du livre" />

                <input type="file" name="photo">
            </fieldset>


            <!-- Colonne droite -->
            <fieldset class="fieldset">
                <label class="label">Titre</label>
                <input type="text" class="input w-full" name="title" value="<?= htmlspecialchars($book?->getTitle()) ?>"
                    required>

                <label class="label">Auteur</label>
                <input type="text" class="input w-full" name="author"
                    value="<?= htmlspecialchars($book?->getAuthor()) ?>" required>

                <label class="label">Description</label>
                <textarea class="textarea w-full"
                    name="description"><?= htmlspecialchars($book?->getDescription()) ?></textarea>

                <label class="label">Disponibilité</label>
                <select class="select w-full" name="availability">
                    <option value="disponible" <?= $book?->getStatus() === 'disponible' ? 'selected' : '' ?>>Disponible
                    </option>
                    <option value="non dispo" <?= $book?->getStatus() === 'non dispo' ? 'selected' : '' ?>>Non disponible
                    </option>
                </select>

                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $book->getId() ?>">
                <?php endif; ?>

                <button class="tomtroc-button principal-green" type="submit">
                    <?= $isEdit ? 'Valider' : 'Créer le livre' ?>
                </button>
            </fieldset>

        </form>
    </div>
</section>