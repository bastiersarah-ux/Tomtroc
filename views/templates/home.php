<?php

/**
 * Template pour la page home.
 */
?>

<title>Home</title>

<div class="home">
    <!-- <button class="btn rounded-[10px]">Test</button> -->
    <!-- Présentation Tomtroc -->
    <section class="presentation">
        <h2 style="font-family: 'Playfair Display'; font-size: 30px; color: #000000;">
            Rejoignez nos lecteurs passionnés
        </h2>

        <p class="presentation.text">
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
            Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
        </p>
        <img src="./public/img/hamza-nouasria.svg" alt="Hamza Nouasria" />
        <p class="signature" style="text-align: right" ;>Hamza</p>
        <a href="?action=showbooks" class="tomtroc-button principal-green">Découvrir</a>
    </section>

    <hr>

    <!-- DERNIERS LIVRES -->
    <section class="lastbooks">
        <h3 class="h3">Les derniers livres ajoutés</h3>

        <div>
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <article>
                        <img src="<?= htmlspecialchars($book->getPicture()) ?>" alt="">
                        <h3><?= htmlspecialchars($book->getTitle()) ?></h3>
                        <p><?= htmlspecialchars($book->getAuthor()) ?></p>
                        <small>
                            Vendu par : <?= htmlspecialchars($book->getUsername()) ?>
                        </small>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun livre pour le moment.</p>
            <?php endif; ?>
        </div>

        <br>

        <a href="?action=showbooks" class="max-md:hidden! tomtroc-button principal-green">
            Voir tous les livres
        </a>
    </section>

    <!-- COMMENT CA MARCHE ?. -->
    <section class="concept">

        <img src="./public/img/valeurs.svg" alt="Nos valeurs" />
        <br>

        <h3 class="h3">Comment ça marche ?</h3>
        <br>

        <p class="principaltxt">Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour
            commencer :</p>
        <br>

        <div class="flex w-full flex-col">
            <div class="card rounded-box grid h-20 place-items-center" style="background-color: #FFFFFF;">Inscrivez-vous
                gratuitement sur notre plateforme</div>
            <br>
            <div class=" card rounded-box grid h-20 place-items-center" style="background-color: #FFFFFF;">Ajoutez les
                livres que vous souhaitez échanger à votre profil.</div>
            <br>
            <div class=" card rounded-box grid h-20 place-items-center" style="background-color: #FFFFFF;">Parcourez les
                livres disponibles chez d'autres membres.</div>
            <br>
            <div class=" card rounded-box grid h-20 place-items-center" style="background-color: #FFFFFF;">Proposez un
                échange et discutez avec d'autres passionnés de lecture.</div>
        </div>
        <br>

        <a href=" /index.php?action=showbooks" class="tomtroc-button grey">Voir tous les livres</a>
        <br>

    </section>

    <!-- NOS VALEURS -->
    <section class="principaltxt">

        <img src="./public/img/valeurs.svg" alt="Nos valeurs" />

        <h3 class="h3">Nos valeurs</h3>

        <p>
            Chez TomTroc, nous mettons l’accent sur le partage, la découverte
            et la communauté. Nos valeurs sont ancrées dans notre passion
            pour les livres et notre désir de créer des liens entre les lecteurs.
        </p>

        <p>
            Nous croyons en la puissance des histoires pour rassembler les gens
            et inspirer des conversations enrichissantes.
        </p>

        <p>
            Notre association a été fondée avec une conviction profonde :
            chaque livre mérite d’être lu et partagé.
        </p>

        <p>
            Nous sommes passionnés par la création d’une plateforme conviviale
            qui permet aux lecteurs de se connecter, de partager leurs découvertes
            littéraires et d’échanger des livres qui attendent patiemment
            leur prochaine lecture.
        </p>

        <p>
            <em class="signature" style="text-align: left" ;>L’équipe TomTroc</em>
        </p>

        <img src="./public/img/coeur.svg" alt="Coeur" />

    </section>
</div>