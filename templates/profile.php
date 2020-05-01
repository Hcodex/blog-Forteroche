<?php $this->title = "Billet simple pour l'Alaska - Mon compte"; ?>
<main role="main">
    <div class="page-header">
        <h1 class="text-center">Mon compte</h1>
    </div>
    <section id="page-content">
        <div class="container pb-5">
            <h2 class="text-center text-primary pb-5"><?= $this->session->get('pseudo'); ?></h2>
            <h3 class="pt-4">Avatar</h3>
            <?php
            include('image_picker.php');
            include('image_manager.php');
            $upload_mode = "avatar";
            include('form_upload.php');
            ?>
            <form method="post" action='../public/index.php?route=editProfile'>
                <div class="form-group">
                    <input type="hidden" id="picture" name="picture" placeholder="Image d' illustration" value="<?= $this->session->get('avatar') ?>">

                <h3 class="pt-4">Email</h3>
                <p><?= $this->session->get('email'); ?></p>
                <h3 class="pt-4">Rôle</h3>
                <p><?= $this->session->get('role'); ?></p>

                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Mettre à jour" id="submit" name="submit">
                </div>

            </form>

        </div>
    </section>
    <a href="../public/index.php">Retour à l'accueil</a>
</main>