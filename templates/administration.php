<?php

use App\src\services\Formater;

$this->title = "Billet simple pour l'Alaska - Admin"; ?>

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
                                <a class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=deleteArticle&articleId=<?= $article->getId(); ?>', 'L\'article et les commentaires qui lui sont liés vont être supprimés définitivement')">
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
            include('ajaxUpload.php');
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
                        <th class="col-sm-2" scope="col">Pseudo</th>
                        <th class="col-sm-7" scope="col">Commentaire</th>
                        <th class="col-sm-1" class="col-sm-2" scope="col">Date</th>
                        <th class="col-sm-2" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($commentsReported as $comment) {
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($comment->getPseudo()); ?></a></td>
                            <td>
                                <a href="index.php?route=article&articleId=<?= $comment->getArticleId(); ?>">
                                    <?= htmlspecialchars($comment->getContent()) ?>
                                </a>
                            </td>
                            <td class="text-center"><?= Formater::formatCondensed(htmlspecialchars($comment->getCreatedAt())); ?></td>
                            <td class="text-center">
                                <a class="btn p-0" href="index.php?route=approveComment&commentId=<?= $comment->getId(); ?>">
                                    <i class="text-secondary" data-feather="check-circle" data-toggle="tooltip" data-placement="bottom" title="Approuver"></i>
                                </a>
                                <a class="btn p-0" href="index.php?route=hideComment&commentId=<?= $comment->getId(); ?>">
                                    <i class="text-secondary" data-feather="eye-off" data-toggle="tooltip" data-placement="bottom" title="Masquer"></i>
                                </a>
                                <a class="btn p-0" href="index.php?route=archiveComment&commentId=<?= $comment->getId(); ?>">
                                    <i class="text-secondary" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Archiver"></i>
                                </a>
                                <a class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>', 'Le commentaire sélectionné va être supprimé définitivement')">
                                    <i class="text-danger" data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Supprimer"></i>
                                </a>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <h3 class="h4 mt-4">Commentaires approuvés</h3>

            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th class="col-sm-2" scope="col">Pseudo</th>
                        <th class="col-sm-7" scope="col">Commentaire</th>
                        <th class="col-sm-1" class="col-sm-2" scope="col">Date</th>
                        <th class="col-sm-2" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($commentsApproved as $comment) {
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($comment->getPseudo()); ?></a></td>
                            <td>
                                <a href="index.php?route=article&articleId=<?= $comment->getArticleId(); ?>">
                                    <?= htmlspecialchars($comment->getContent()) ?>
                                </a>
                            </td>
                            <td class="text-center"><?= Formater::formatCondensed(htmlspecialchars($comment->getCreatedAt())); ?></td>
                            <td class="text-center">
                                <i class="text-success" data-feather="check-circle" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est approuvé"></i>
                                <a class="btn p-0" href="index.php?route=hideComment&commentId=<?= $comment->getId(); ?>">
                                    <i class="text-secondary" data-feather="eye-off" data-toggle="tooltip" data-placement="bottom" title="Masquer"></i>
                                </a>
                                <a class="btn p-0" href="index.php?route=archiveComment&commentId=<?= $comment->getId(); ?>">
                                    <i class="text-secondary" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Archiver"></i>
                                </a>
                                <a class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>', 'Le commentaire sélectionné va être supprimé définitivement')">
                                    <i class="text-danger" data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Supprimer"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <h3 class="h4 mt-4">Commentaires masqués</h3>

            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th class="col-sm-2" scope="col">Pseudo</th>
                        <th class="col-sm-7" scope="col">Commentaire</th>
                        <th class="col-sm-1" class="col-sm-2" scope="col">Date</th>
                        <th class="col-sm-2" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($commentsHided as $comment) {
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($comment->getPseudo()); ?></td>
                            <td><?= htmlspecialchars($comment->getContent()) ?></td>
                            <td class="text-center"><?= Formater::formatCondensed(htmlspecialchars($comment->getCreatedAt())); ?></td>
                            <td class="text-center">
                                <a class="btn p-0" href="index.php?route=approveComment&commentId=<?= $comment->getId(); ?>">
                                    <i class="text-secondary" data-feather="check-circle" data-toggle="tooltip" data-placement="bottom" title="Approuver"></i>
                                </a>
                                <i class="text-success" data-feather="eye-off" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est masqué"></i>
                                <?php if ($comment->isReported() == 4) {
                                ?>
                                    <i class="text-success" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est archivé"></i>
                                <?php
                                } else {
                                ?>
                                    <a class="btn p-0" href="index.php?route=archiveComment&commentId=<?= $comment->getId(); ?>">
                                        <i class="text-secondary" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Archiver"></i>
                                    </a>
                                <?php
                                }
                                ?>
                               <a class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>', 'Le commentaire sélectionné va être supprimé définitivement')">
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
            <h2 class="text-primary">Gestion des utilisateurs</h2>
            <h3 class="h4 mt-4">Utilisateurs enregistrés</h3>
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Pseudo</th>
                        <th scope="col">email</th>
                        <th scope="col">Créé le</th>
                        <th scope="col">avatar</th>
                        <th scope="col">role</th>
                        <th class="col-sm-2" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($usersRegistered as $user) {
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($user->getPseudo()); ?></td>
                            <td class="text-center"><?= htmlspecialchars($user->getEmail()); ?></td>
                            <td class="text-center"><?= Formater::formatCondensed(htmlspecialchars($user->getCreatedAt())); ?></td>
                            <td class="text-center"> <img src="<?= $user->getThumbail(); ?>" class="" width="60px" alt="Défaut"></td>
                            <td class="text-center"><?= Formater::setRoleIcon(htmlspecialchars($user->getRole())); ?></td>

                            <td class="text-center">
                                <a  class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=setRole&role=1&userId=<?= $user->getId();?>', 'Vous allez donner les doit d\'administeur à l\'utilisateur sélectionné')">
                                    <i class="text-secondary" data-feather="star" data-toggle="tooltip" data-placement="bottom" title="Définir administrateur"></i>
                                </a>
                                <a  class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=setRole&role=3&userId=<?= $user->getId();?>', 'Vous allez donner les doit de correcteur à l\'utilisateur sélectionné')">
                                    <i class="text-secondary" data-feather="pen-tool" data-toggle="tooltip" data-placement="bottom" title="Définir correcteur"></i>
                                </a>
                                <a  class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=setRole&role=2&userId=<?= $user->getId();?>', 'Vous allez retirer tous les privilièges accordés à l\'utilisateur sélectionné')">
                                    <i class="text-secondary" data-feather="user" data-toggle="tooltip" data-placement="bottom" title="Définir utilisateur"></i>
                                </a>
                                <a  class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=banUser&userId=<?= $user->getId();?>', 'Vous allez banir l\'utilisateur sélectionné')">
                                    <i class="text-danger" data-feather="minus-circle" data-toggle="tooltip" data-placement="bottom" title="banir"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <h3 class="h4 mt-4">Utilisateurs banis</h3>
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Pseudo</th>
                        <th scope="col">email</th>
                        <th scope="col">Créé le</th>
                        <th scope="col">avatar</th>
                        <th scope="col">role</th>
                        <th class="col-sm-2" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($usersBanned as $user) {
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($user->getPseudo()); ?></td>
                            <td class="text-center"><?= htmlspecialchars($user->getEmail()); ?></td>
                            <td class="text-center"><?= Formater::formatCondensed(htmlspecialchars($user->getCreatedAt())); ?></td>
                            <td class="text-center"> <img src="<?= $user->getThumbail(); ?>" class="" width="60px" alt="Défaut"></td>
                            <td class="text-center"><?= Formater::setRoleIcon("banned"); ?></td>

                            <td class="text-center">
                                <a  class="btn p-0" href="#" onclick="setConfirmModal('index.php?route=unbanUser&userId=<?= $user->getId();?>', 'Vous allez réactiver le compte de l\'utilisateur sélectionné')">
                                    <i class="text-primary" data-feather="share" data-toggle="tooltip" data-placement="bottom" title="Réactiver"></i>
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
</main>