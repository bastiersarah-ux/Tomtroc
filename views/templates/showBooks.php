<?php

/**
 * Template pour la page des livres à l'échange.
 */
?>
<title>Nos livres à l'échange</title>

<h1>Nos livres à l’échange</h1>

<div class="search">
    <input type="text" placeholder="🔍 Rechercher un livre" disabled>
</div>

<!-- LISTE DES LIVRES -->
<div class="grid">

    <?php foreach ($books as $book): ?>
        <div class="card">
            <img src="uploads/<?= htmlspecialchars($book['picture']) ?>" alt="">
            <h3>
                <?= htmlspecialchars($book['title']) ?>
            </h3>
            <p>
                <?= htmlspecialchars($book['author']) ?>
            </p>
            <p></p>Vendu par :
            <?= htmlspecialchars($user['username']) ?>
                </p>
            </div>
    <?php endforeach; ?>

</div>