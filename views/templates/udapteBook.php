<?php

/**
 * Template pour modifier/créer un livre.
 */
?>
<title><?= $isEdit ? 'Modifier un livre' : 'Créer un livre' ?></title>

<a href="index.php" class="back-link">← retour</a>
<h2 style="text-align:center">
    <?= $isEdit ? 'Modifier les informations' : 'Ajouter un livre' ?>
</h2>

<form class="container" method="post" action="<?= $isEdit ? 'update.php' : 'store.php' ?>" enctype="multipart/form-data">

    <!-- Colonne gauche -->
    <div>
        <label>Photo</label>

        <?php if ($photo): ?>
            <img src="uploads/<?= htmlspecialchars($photo) ?>" alt="Livre">
        <?php else: ?>
            <p>Aucune image</p>
        <?php endif; ?>

        <input type="file" name="photo">
    </div>

    <!-- Colonne droite -->
    <div>
        <label>Titre</label>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>

        <label>Auteur</label>
        <input type="text" name="author" value="<?= htmlspecialchars($author) ?>" required>

        <label>Commentaire</label>
        <textarea name="description"><?= htmlspecialchars($description) ?></textarea>

        <label>Disponibilité</label>
        <select name="availability">
            <option value="disponible" <?= $availability === 'disponible' ? 'selected' : '' ?>>Disponible</option>
            <option value="indisponible" <?= $availability === 'indisponible' ? 'selected' : '' ?>>Indisponible</option>
        </select>

        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <?php endif; ?>

        <button type="submit">
            <?= $isEdit ? 'Valider' : 'Créer le livre' ?>
        </button>
    </div>

</form>

</body>

</html>