<?php $this->title = "Billet simple pour l'Alaska - Mon compte"; ?>	
<main role="main">   
    <div class="page-header">
        <h1 class="text-center">Mon compte</h1>
    </div>
    <section id="page-content">	
        <div class="container pb-5">
            <h2 class="text-center text-primary pb-5"><?= $this->session->get('pseudo'); ?></h2>
            <h3 class="pt-4">Avatar</h3>

            <?php if ($this->session->get('avatar')){?>
                <img src="../public/img/avatars/<?= $this->session->get('avatar') ?>" width="150px" height="150px" alt="avatar" class="img-thumbnail rounded-circle">
            <?php } else {?>
            <img src="../public/img/avatars/user_default.svg" width="150px" alt="avatar" class="img-thumbnail rounded-circle">
            <?php } ?>
           
            <h3 class="pt-4">Email</h3>
            <p><?= $this->session->get('email'); ?></p>
            <h3 class="pt-4">Rôle</h3>
            <p><?= $this->session->get('role'); ?></p>
        </div>	
    </section>
    <a href="../public/index.php">Retour à l'accueil</a>
</main>