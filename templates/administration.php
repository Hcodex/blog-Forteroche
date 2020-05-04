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
                            <td> <img src="<?= $article->getThumbail(); ?>" class="" width="60px" alt="Défaut"></td>
                            <td><?= htmlspecialchars($article->getCreatedAt('CONDENSED')); ?></td>
                            <td><?= htmlspecialchars($article->getUpdatedAt('CONDENSED')); ?></td>
                            <td><?= htmlspecialchars($article->getStatus()); ?></td>
                            <td class="text-center">
                                <a href="../public/index.php?route=editArticle&articleId=<?= $article->getId(); ?>">
                                    <i class="text-success" data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Editer"></i>
                                </a>
                                <a href="#" onclick="setConfirmModal('../public/index.php?route=deleteArticle&articleId=<?= $article->getId(); ?>')">
                                    <i class="text-danger" data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Supprimer"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <section>
        <div class="container pb-5">
            <h2 class="text-primary ">Gestion des images</h2>
            <?php
            include('image_manager.php');
            include('form_upload.php');
            ?>
        </div>
    </section>

    <section>
        <div class="container pb-5">
            <h2 class="text-primary">Commentaires</h2>

            <h3 class="h4 mt-4">Commentaires signalés</h3>
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Pseudo</th>
                        <th scope="col">Commentaire</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($comments as $comment) {
                        if ($comment->isReported() == 1) {
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($comment->getPseudo()); ?></a></td>
                                <td><?= htmlspecialchars($comment->getContent()) ?></td>
                                <td><?= htmlspecialchars($comment->getCreatedAt("CONDENSED")); ?></td>
                                <td class="text-center">
                                    <a href="../public/index.php?route=approveComment&commentId=<?= $comment->getId(); ?>">
                                        <i class="text-secondary" data-feather="check-circle" data-toggle="tooltip" data-placement="bottom" title="Approuver"></i>
                                    </a>
                                    <a href="../public/index.php?route=hideComment&commentId=<?= $comment->getId(); ?>">
                                        <i class="text-secondary" data-feather="eye-off" data-toggle="tooltip" data-placement="bottom" title="Masquer"></i>
                                    </a>
                                    <a href="../public/index.php?route=archiveComment&commentId=<?= $comment->getId(); ?>">
                                        <i class="text-secondary" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Archiver"></i>
                                    </a>
                                    <a href="#" onclick="setConfirmModal('../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>')">
                                        <i class="text-danger" data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Supprimer"></i>
                                    </a>

                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

            <h3 class="h4 mt-4">Commentaires approuvés</h3>

            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Pseudo</th>
                        <th scope="col">Commentaire</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($comments as $comment) {
                        if ($comment->isReported() == 2) {
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($comment->getPseudo()); ?></a></td>
                                <td><?= htmlspecialchars($comment->getContent()) ?></td>
                                <td><?= htmlspecialchars($comment->getCreatedAt("CONDENSED")); ?></td>
                                <td class="text-center">
                                    <i class="text-success" data-feather="check-circle" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est approuvé"></i>
                                    <a href="../public/index.php?route=hideComment&commentId=<?= $comment->getId(); ?>">
                                        <i class="text-secondary" data-feather="eye-off" data-toggle="tooltip" data-placement="bottom" title="Masquer"></i>
                                    </a>
                                    <a href="../public/index.php?route=archiveComment&commentId=<?= $comment->getId(); ?>">
                                        <i class="text-secondary" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Archiver"></i>
                                    </a>
                                    <a href="#" onclick="setConfirmModal('../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>')">
                                        <i class="text-danger" data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Supprimer"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

            <h3 class="h4 mt-4">Commentaires masqués</h3>

            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Pseudo</th>
                        <th scope="col">Commentaire</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($comments as $comment) {
                        if ($comment->isReported() == 3 || $comment->isReported() == 4) {
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($comment->getPseudo()); ?></a></td>
                                <td><?= htmlspecialchars($comment->getContent()) ?></td>
                                <td><?= htmlspecialchars($comment->getCreatedAt("CONDENSED")); ?></td>
                                <td class="text-center">
                                    <a href="../public/index.php?route=approveComment&commentId=<?= $comment->getId(); ?>">
                                        <i class="text-secondary" data-feather="check-circle" data-toggle="tooltip" data-placement="bottom" title="Approuver"></i>
                                    </a>
                                    <i class="text-success" data-feather="eye-off" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est masqué"></i>
                                    <?php if ($comment->isReported() == 4) {
                                    ?>
                                        <i class="text-success" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est archivé"></i>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="../public/index.php?route=archiveComment&commentId=<?= $comment->getId(); ?>">
                                            <i class="text-secondary" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Archiver"></i>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                    <a href="#" onclick="setConfirmModal('../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>')">
                                        <i class="text-danger" data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Supprimer"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>



        </div>







    </section>


    <div id="confirmModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i data-feather="alert-triangle" class="text-danger"></i> Suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Attention, l'élément sélectionné va être supprimé définitivement !</p>
                </div>
                <div class="modal-footer">
                    <a id="confirmBtn" href="" type="button" class="btn btn-danger">Supprimer</a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

</main>