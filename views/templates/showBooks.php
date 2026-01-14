<?php

/**
 * Template pour la page des livres à l'échange.
 */
?>

<h1>Nos livres à l’échange</h1>

<div class="search">
    <input type="text" placeholder="🔍 Rechercher un livre" disabled>
</div>

<!-- LISTE DES LIVRES -->
<div class="grid">
    <?php foreach ($books as $book): ?>
        <div class="card">
            <img src="/uploads/<?= htmlspecialchars($book->getPicture()) ?>" alt="">
        </div>
        <h3>
            <?= htmlspecialchars($book->getTitle()) ?>
        </h3>
        <p>
            <?= htmlspecialchars($book->getAuthor()) ?>
        </p>
        <p></p>Vendu par :
        <?= htmlspecialchars($book->getUsername()) ?>
        </p>
    <?php endforeach; ?>

</div>