<?php $this->title = "Billet simple pour l'Alaska - L'auteur"; ?>
	
<main role="main">
	
	<div class="page-header">
		<h1 class="text-center">Lecture</h1>
    </div>
    <ul class="nav justify-content-center sticky-top bg-dark">
			<li class="nav-item">
				<a class="nav-link active" href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId()-1);?>">Chapitre précédent</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModalCenter">Sélection du chapitre</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId()+1);?>">Chapitre suivant</a>
			</li>
	</ul>
    <section  class="paper">
        <div class="container roman text-justify ">	
        <h2 class="title text-primary"><?= $article->getTitle();?></h2>    
        <?= htmlspecialchars($article->getContent());?>
        </div> 
    </section>       
</main>