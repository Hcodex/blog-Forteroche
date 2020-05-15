<?php use App\src\services\Formater;?>
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
            <h3 class="h4 mt-4">Utilisateurs bannis</h3>
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