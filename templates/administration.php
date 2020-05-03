<?php $this->title = "Billet simple pour l'Alaska - Admin"; ?>

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
                    <tr class="text-center">
                        <th scope="col">Titre</th>
                        <th scope="col">Contenu</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Image</th>
                        <th scope="col">Créé le</th>
                        <th scope="col">Mis à jour</th>
                        <th scope="col">Statut</th>
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
                            <td> <img src="<?=$article->getThumbail();?>" class="" width="60px" alt="Défaut"></td>
                            <td><?= htmlspecialchars($article->getCreatedAt('CONDENSED')); ?></td>
                            <td><?= htmlspecialchars($article->getUpdatedAt('CONDENSED')); ?></td>
                            <td><?= htmlspecialchars($article->getStatus()); ?></td>
                            <td class="text-center">
                                <a class="btn btn-primary mb-1 p-1" href="../public/index.php?route=editArticle&articleId=<?= $article->getId(); ?>">Modifier</a>
                                <button class="btn btn-danger p-1" onclick="setConfrimModal('../public/index.php?route=deleteArticle&articleId=<?= $article->getId(); ?>')" type="button" >Supprimer</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <h2 class="text-primary mt-5">Gestion des images</h2>
            <?php
            include('image_manager.php');
            include('form_upload.php');
            ?>
        </div>

        <div id="confirmModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i data-feather="alert-triangle" class="text-danger"></i> Suppression Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Attention, l'article sélectionné va être supprimé définitivement !</p>
                </div>
                <div class="modal-footer">
                    <a id="confirmBtn" href="" type="button" class="btn btn-primary">Supprimer</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                </div>
                </div>
            </div>
            </div>


    </section>
</main>