<?php $this->title = "Billet simple pour l'Alaska - L'auteur"; ?>

<main role="main">

    <div class="page-header">
        <h1 class="text-center">Administration</h1>
    </div>
    <section id="page-content">
        <div class="container pb-5">
            <h2 class="text-primary">Gestion des articles</h2>
            <a class="btn btn-warning text-dark my-3" type="button" href="index.php?route=addArticle">Ajouter un article</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Contenu</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Image</th>
                        <th scope="col">Créé le</th>
                        <th scope="col">Mis à jour</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($articles as $article) {
                    ?>
                        <tr>
                            <td><a href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId()); ?>"><?= htmlspecialchars($article->getTitle()); ?></a></td>
                            <td><?= substr(strip_tags($article->getContent()), 0, 100); ?>...</td>
                            <td><?= htmlspecialchars($article->getAuthor()); ?></td>
                            <td> <img src="<?= ARTICLE_THUMB_DIR.htmlspecialchars($article->getPicture()); ?>" class="" width="60px" alt="Défaut"></td>
                            <td><?= htmlspecialchars($article->getCreatedAt('CONDENSED')); ?></td>
                            <td><?= htmlspecialchars($article->getUpdatedAt('CONDENSED')); ?></td>
                            <td>
                                <a href="../public/index.php?route=editArticle&articleId=<?= $article->getId(); ?>">Modifier</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <h2 class="text-primary">Gestion des images</h2>
            <?php
            include('image_manager.php');
            $upload_mode = "article";
            include('form_upload.php');

            ?>
        </div>
    </section>
</main>