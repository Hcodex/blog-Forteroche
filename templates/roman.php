<?php

use App\src\services\Formater;

$this->title = "Billet simple pour l'Alaska - Le roman"; ?>
<main role="main">
    <div class="page-header">
        <h1 class="text-center">Le roman</h1>
    </div>
    <section id="page-content">
        <div class="container pb-5">
            <h2 class="text-center text-primary pb-2">Chapitres publiés</h2>

            <div class="row">

                <?php
                foreach ($articles as $article) {
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <img class="d-none" src="<?= $article->getThumbail() ?>" alt="Card image cap">
                            <div class="card-img-top" style="background-image: url('<?= $article->getThumbail() ?>')" alt="Card image cap"></div>
                            <div class="card-body">
                                <h3><?= htmlspecialchars($article->getTitle()); ?></h3>
                                <p><?= substr(strip_tags($article->getContent()), 0, 150); ?>...</p>
                                <a href="index.php?route=article&articleId=<?= htmlspecialchars($article->getId()); ?>" class="card-link">Lire la suite</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Publié le : <?= Formater::formatFR(htmlspecialchars($article->getCreatedAt("FR"))); ?></small>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
</main>