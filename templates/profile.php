<?php $this->title = "Billet simple pour l'Alaska - Mon compte"; ?>
<main role="main">
    <div class="page-header">
        <h1 class="text-center">Mon compte</h1>
    </div>
    <section id="page-content">
        <div class="container pb-5">
            <div class="row">
                <div class="col-md-8 col-sm-12 order-md-last">
                    <h2 class="text-md-center text-primary pt-1"><span class="text-muted">pseudo : </span><?= htmlspecialchars($this->session->get('pseudo')); ?></h2>
                    <div class="row pt-md-5">
                        <div class="col-md-6 col-sm-12 text-md-center">
                            <h3 class="pt-4 text-muted">Email</h3>
                            <p><?= htmlspecialchars($this->session->get('email')); ?>
                                <a href="index.php?route=passwordModify"><i class="text-primary m-2 " data-feather="key" data-toggle="tooltip" data-placement="bottom" title="Changer le mot de passe"></i></a>
                            </p>
                        </div>
                        <div class="col-md-6 col-sm-12 text-md-center">
                            <h3 class="pt-4 text-muted">Marque page </h3>
                            <?php
                            if ($this->session->get('last_article_id') !== NULL) {
                            ?>
                                <a href="index.php?route=article&articleId=<?= $this->session->get('last_article_id'); ?>">
                                    <i class="text-primary m-2 " data-feather="book-open"></i> Reprendre la lecture
                                </a>
                            <?php
                            } else {
                            ?>
                                <p><i class="text-primary m-2 " data-feather="slash"></i>Non défini</p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 text-md-center pt-md-1 pt-5">
                    <h3 class=" text-muted h2">Avatar</h3>
                    <?php
                    include('image_manager.php');
                    ?>
                </div>
            </div>
            <form method="post" action='index.php?route=editProfile'>
                <div class="form-group pt-3 pt-md-1">
                    <input type="hidden" id="picture_file_name" name="picture_file_name" placeholder="Image d' illustration" value="<?= htmlspecialchars($this->session->get('avatar')) ?>">
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Mettre à jour" id="submit" name="submit">
                        <a class="btn btn-danger" href="#" onclick="setConfirmModal('index.php?route=deleteUser&userId=<?= htmlspecialchars($this->session->get('id')); ?>', 'Votre compte va être supprimé définitivement')">
                            Supprimer mon compte
                        </a>
                    </div>

            </form>


        </div>
    </section>
</main>