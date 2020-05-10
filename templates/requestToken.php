<?php $this->title = "Billet simple pour l'Alaska - Connexion"; ?>	
<main role="main">   
    <div class="page-header">
        <h1 class="text-center">Activer mon compte</h1>
    </div>
    <section id="page-content">	
        <div class="container pb-5">	
            <h1 class="text-center text-primary pb-2">Demander une clé d'activation</h1> 
            <p class="text-center text-danger font-weight-bold"> <?= $this->session->show('error_login'); ?></p>
            <p class="text-center text-danger font-weight-bold"> <?= $this->session->show('need_login'); ?></p>
            <?php
                include('../templates/form_activation.php');
            ?>
        </div>	
    </section>
</main>