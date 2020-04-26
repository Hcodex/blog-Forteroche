<?php $this->title = "Billet simple pour l'Alaska - Mon compte"; ?>	
<main role="main">   
    <div class="page-header">
        <h1 class="text-center">Mon compte</h1>
    </div>
    <section id="page-content">	
        <div class="container pb-5">
            <h2 class="text-center text-primary pb-5"><?= $this->session->get('pseudo'); ?></h2>
            <h3>Email</h3>
            <p><?= $this->session->get('email'); ?></p>
            <h3>Rôle</h3>
            <p><?= $this->session->get('role'); ?></p>
            <img src="..." alt="..." class="img-thumbnail">
            <p><?= $this->session->get('id'); ?></p>
        </div>	
    </section>
    <a href="../public/index.php">Retour à l'accueil</a>
</main>