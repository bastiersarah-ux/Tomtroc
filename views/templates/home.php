<?php

/**
 * Template pour la page home.
 */
?>

<!-- <button class="btn rounded-[10px]">Test</button> -->
<!-- Présentation Tomtroc -->
<article class="presentation">
    <section id="discover">
        <h1>
            Rejoignez nos lecteurs passionnés
        </h1>

        <p>
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
            Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
        </p>
        <a href="?action=showbooks" class="tomtroc-button principal-green">Découvrir</a>
    </section>
    <figure id="discover-image">
        <img src="./public/img/hamza-nouasria.svg" alt="Hamza Nouasria" />
        <legend class="signature">Hamza</legend>
    </figure>
</article>

<!-- DERNIERS LIVRES -->
<article class="lastbooks">
    <h2>Les derniers livres ajoutés</h2>

    <section>
        <?php if (!empty($books)): ?>
            <div class="card-container">
                <?php foreach ($books as $book): ?>
                    <div class="card">
                        <figure>
                            <img src="<?= Utils::getBookPictureUrl($book->getPicture()) ?>" alt="<?= $book->getTitle() ?>">
                        </figure>
                        <div class="card-body">
                            <h3 class="title">
                                <?= htmlspecialchars($book->getTitle()) ?>
                            </h3>
                            <span class="subtitle">
                                <?= htmlspecialchars($book->getAuthor()) ?>
                            </span>
                            <legend>
                                Vendu par :
                                <?= htmlspecialchars($book->getUsername()) ?>
                            </legend>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun livre pour le moment.</p>
            <?php endif; ?>
        </div>
        <a href="?action=showbooks" class="max-md:hidden! tomtroc-button principal-green">
            Voir tous les livres
        </a>
    </section>
</article>

<!-- COMMENT CA MARCHE ?. -->
<article class="concept">

    <h2>Comment ça marche ?</h2>

    <p class="subtitle">
        Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour
        commencer :
    </p>

    <section>
        <div class="card">
            Inscrivez-vous
            gratuitement sur notre plateforme.
        </div>

        <div class="card">
            Ajoutez les
            livres que vous souhaitez échanger à votre profil.
        </div>

        <div class="card">
            Parcourez les
            livres disponibles chez d'autres membres.
        </div>

        <div class="card">
            Proposez un
            échange et discutez avec d'autres passionnés de lecture.
        </div>
    </section>

    <a href="?action=showbooks" class="tomtroc-button grey">Voir tous les livres</a>

</article>

<!-- NOS VALEURS -->
<article class="valeurs">
    <figure>
        <img src="./public/img/valeurs.jpg" alt="Nos valeurs" />
    </figure>

    <section>
        <h2>Nos valeurs</h2>
        <div class="message-container">
            <p>
                Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté.
                Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les
                lecteurs.
                Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations
                enrichissantes.
            </p>

            <p>
                Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.
            </p>

            <p>
                Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se
                connecter,
                de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les
                étagères.
            </p>
        </div>

        <div class="signature-container">
            <legend class="signature">L’équipe TomTroc</legend>
            <img src="./public/img/coeur.svg" alt="Coeur" />
        </div>
    </section>
</article>