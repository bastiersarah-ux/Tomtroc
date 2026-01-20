<?php

/**
 * Template pour la page d'un livre en détail (style "fiche").
 */

function getOrDefault($value, $default)
{
    return empty($value) ? $default : $value;
}

?>

<div>
    <!-- Image du livre -->
    <div>
        <img src="<?= Utils::getBookPictureUrl($book->getPicture()) ?>"
            alt="Couverture du livre <?= htmlspecialchars($book->getTitle()) ?>">
    </div>

    <!-- Titre et auteur -->
    <div>
        <h1>
            <?= htmlspecialchars($book->getTitle()) ?>
        </h1>
        <p>par
            <?= htmlspecialchars($book->getAuthor()) ?>
        </p>
    </div>

    <!-- Description -->
    <div>
        <h4>Description</h4>
        <p>
            <?= nl2br(htmlspecialchars($book->getDescription())) ?>
        </p>
    </div>

    <!-- Propriétaire -->
    <div>
        <h4>Propriétaire</h4>
        <img src="<?= Utils::getUserPictureUrl($book->getProfilePicture()) ?>"
            alt="Photo de profil de <?= $book->getUsername() ?>">
        <a class="tomtroc-button grey" href="?action=createthread&user=<?= $book->getSlugUser() ?>">Envoyer un message</a>
    </div>

</div>