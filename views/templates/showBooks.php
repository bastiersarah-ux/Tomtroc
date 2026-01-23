<?php

/**
 * Template pour la page des livres à l'échange.
 */

$search = Utils::request("search");

?>

<div class="page-container">
    <form method="get" action="?action=showbooks" class="page-header">
        <h1>Nos livres à l’échange</h1>
        <label class="input">
            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </g>
            </svg>
            <input type="hidden" name="action" value="showbooks">
            <input type="search" role="search" name="search" class="grow" placeholder="Rechercher un livre"
                value="<?= $search ?>" />
        </label>
    </form>

    <!-- LISTE DES LIVRES -->
    <div class="grid">
        <?php foreach ($books as $book): ?>
            <a class="card book-card" href="?action=showbookdetail&id=<?= $book->getIdBook() ?>">
                <figure>
                    <?php if ($book->getStatus() == Book::INDISPONIBLE): ?>
                        <div class="badge error"><?= $book->getStatus() ?></div>
                    <?php endif; ?>
                    <img src="<?= Utils::getBookPictureUrl($book->getPicture()) ?>" alt="<?= $book->getTitle() ?>">
                </figure>
                <div class="card-body">
                    <span class="title">
                        <?= htmlspecialchars($book->getTitle()) ?>
                    </span>
                    <span class="subtitle">
                        <?= htmlspecialchars($book->getAuthor()) ?>
                    </span>
                    <legend>
                        Vendu par :
                        <?= htmlspecialchars($book->getUsername()) ?>
                    </legend>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>