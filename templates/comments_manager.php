<?php

use App\src\services\Formater; ?>

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