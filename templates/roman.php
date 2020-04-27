
<?php $this->title = "Billet simple pour l'Alaska - Le roman"; ?>	
<main role="main">   
    <div class="page-header">
        <h1 class="text-center">Le roman</h1>
    </div>
    <section id="page-content">	
        <div class="container pb-5">	
            <h2 class="text-center text-primary pb-2">Chapitres publiés</h2> 
            
            <div class="row">
            
                <?php
                foreach ($articles as $article)
                {
                ?>
                 <div class="col-sm-4">  
                    <div class="card">

                    <?php if ($article->getPicture()){?>
                        <img class="card-img-top" src="<?= $article->getPicture() ?>" alt="Card image cap">
                    <?php } else {?>
                        <img class="card-img-top" src="../public/img/header.jpg" alt="Card image cap">
                    <?php } ?>

                        
                        <div class="card-body">
                            <h3><?= htmlspecialchars($article->getTitle());?></h3>
                            <p><?= substr($article->getContent(), 0, 150);?>...</p>
                            <a href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId());?>" class="card-link">Lire la suite</a>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Publié le : <?= htmlspecialchars($article->getCreatedAt());?></small>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>	
    </section>
</main>