<?php

use App\src\services\Formater;

$this->title = "Billet simple pour l'Alaska - Admin"; ?>

<main role="main">
    <?php
    if ($this->session->get('role') === 'admin' || $this->session->get('role') === 'corrector') {
        include('articles_manager.php');
    }
    if ($this->session->get('role') === 'admin') {
    ?>
        <section>
            <div class="container pb-5">
                <h2 class="text-primary ">Gestion des images</h2>
                <?php
                include('image_manager.php');
                ?>
            </div>
        </section>
    <?php
    }
    if ($this->session->get('role') === 'admin' || $this->session->get('role') === 'corrector') {
        include('comments_manager.php');
    }
    if ($this->session->get('role') === 'admin') {
        include('users_manager.php');
    }
    ?>


</main>