
<?php $this->title = "Billet simple pour l'Alaska - Connexion"; ?>	
<main role="main">   
    <div class="page-header">
        <h1 class="text-center">Connexion</h1>
    </div>
    <section id="page-content">	
        <div class="container pb-5">	
            <h1 class="text-center text-primary pb-2">Formulaire de connexion</h1> 
            <p class="text-center text-danger font-weight-bold"> <?= $this->session->show('error_login'); ?></p>
            <p class="text-center text-danger font-weight-bold"> <?= $this->session->show('need_login'); ?></p>
            <?php
            require_once '../templates/form_login.php';
            ?>
        </div>	
    </section>
</main>
    
    
    
    
    
    