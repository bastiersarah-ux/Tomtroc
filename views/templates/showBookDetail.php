<?php

/**
 * Template pour la page d'un livre en détail (style "fiche").
 */

function getOrDefault($value, $default)
{
    return empty($value) ? $default : $value;
}

?>
<!-- Navigation-->
<section id="nav-book">
    <nav aria-label="Fil d’Ariane">
        <a class="link link-hover" href="?action=showbooks">Nos livres</a> &gt;
        <span>
            <?= htmlspecialchars($book->getTitle()) ?>
        </span>
    </nav>
</section>

<!-- Image du livre -->
<section id="picture-bloc">
    <div class="card lg:card-side">
        <figure>
            <img src="<?= Utils::getBookPictureUrl($book->getPicture()) ?>"
                alt="Couverture du livre <?= htmlspecialchars($book->getTitle()) ?>">
        </figure>
        <div class="card-content">
            <!-- Titre et auteur -->
            <section id="bookdetail-bloc">
                <h1>
                    <?= htmlspecialchars($book->getTitle()) ?>
                </h1>
                <span class="author">par
                    <?= htmlspecialchars($book->getAuthor()) ?>
                </span>
                <hr>
                <div class="description">
                    <span class="bloc-title">Description</span>
                    <p>
                        <?= nl2br(htmlspecialchars($book->getDescription())) ?>
                    </p>
                </div>
                <!-- Propriétaire -->
                <div id="owner-bloc">
                    <span class="bloc-title">Propriétaire</span>
                    <a class="owner-badge" href="?action=showuserprofile&user=<?= $book->getSlugUser() ?>">
                        <div class="avatar">
                            <div class="rounded-full">
                                <img src="<?= Utils::getUserPictureUrl($book->getProfilePicture()) ?>"
                                    alt="Photo de profil de <?= $book->getUsername() ?>" class="owner-avatar">
                            </div>
                        </div>
                        <?= htmlspecialchars($book->getUsername()) ?>
                    </a>
                </div>
            </section>

            <!-- Envoyer un message -->
            <section id="sendmessage">
                <a class="tomtroc-button principal-green" href="?action=createthread&user=<?= $book->getSlugUser() ?>">
                    Envoyer un message
                </a>
            </section>
        </div>
    </div>
</section>