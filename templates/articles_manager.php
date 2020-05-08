<?php

use App\src\services\Formater; ?>

<div class="page-header">
    <h1 class="text-center">Administration</h1>
</div>
<section id="page-content">
    <div class="container pb-5">
        <h2 class="text-primary">Gestion des articles</h2>
        <?php
        if ($this->session->get('role') === 'admin') {
        ?>
            <a class="btn btn-warning text-dark my-3" type="button" href="index.php?route=addArticle">Ajouter un article</a>
        <?php
        }
        ?>
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
                    <th class="col-sm-1" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($articles as $article) {
                ?>
                    <tr>
                        <td><a href="index.php?route=article&articleId=<?= htmlspecialchars($article->getId()); ?>"><?= htmlspecialchars($article->getTitle()); ?></a></td>
                        <td><?= substr(strip_tags($article->getContent()), 0, 100); ?>...</td>
                        <td><?= htmlspecialchars($article->getAuthor()); ?></td>
                        <td> <img src="<?= $article->getThumbail(); ?>" class="" width="60px" alt="Défaut"></td>
                        <td><?= Formater::formatCondensed(htmlspecialchars($article->getCreatedAt())); ?></td>
                        <td><?= Formater::formatCondensed(htmlspecialchars($article->getUpdatedAt())); ?></td>
                        <td class="text-center"><?= Formater::setStatusIcon(htmlspecialchars($article->getStatus())); ?></td>
                        <td class="text-center">
                            <a class="btn p-0" href="index.php?route=editArticle&articleId=<?= $article->getId(); ?>">
                                <i class="text-primary" data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Editer"></i>
                            </a>
                            <?php
                            if ($this->session->get('role') === 'admin') {
                            ?>
                                <a class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=deleteArticle&articleId=<?= $article->getId(); ?>', 'L\'article et les commentaires qui lui sont liés vont être supprimés définitivement')">
                                    <i class="text-danger" data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Supprimer"></i>
                                </a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</section>