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
                        <div class="card roman-card">
                            <img class="d-none" src="<?= $article->getThumbail() ?>" alt="Image titre <?= htmlspecialchars($article->getTitle()); ?>">
                            <div class="card-img-top " style="background-image: url('<?= $article->getThumbail() ?>')">
                                <?php
                                if ($this->session->get('last_article_id') === $article->getId()) {
                                ?>
                                    <div class="float-right m-2 rounded-circle bg-white shadow">
                                        <i class="text-primary m-2" data-feather="bookmark" data-toggle="tooltip" data-placement="bottom" title="Marque page"></i>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
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