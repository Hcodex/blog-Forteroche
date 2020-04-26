
<?php $this->title = "Billet simple pour l'Alaska - Le roman"; ?>	
<main role="main">   
    <div class="page-header">
        <h1 class="text-center">Le roman</h1>
    </div>
    <section id="page-content">	
        <div class="container pb-5">	
            <h2 class="text-center text-primary pb-2">Chapitres publiés</h2> 
            
            
            <div class="card-deck">              
                <?php
                foreach ($articles as $article)
                {
                ?>
                    <div class="card">
                        <img class="card-img-top" src="../public/img/header.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h3><?= htmlspecialchars($article->getTitle());?></h3>
                            <p><?= substr(htmlspecialchars($article->getContent()), 0, 150);?></p>
                            <p class='text-center'><a class="btn btn-primary mx-auto" href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId());?>">Lire</a></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Publié le : <?= htmlspecialchars($article->getCreatedAt());?></small>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>	
    </section>
</main>