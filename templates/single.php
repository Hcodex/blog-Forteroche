<?php $this->title = "Billet simple pour l'Alaska - L'auteur"; ?>


<?php
$article_list = array();
foreach ($articles as $article2) {
	array_push($article_list, $article2->getId());
}
$index = (array_search($article->getId(), $article_list));
?>


<main role="main">

	<div class="page-header" style="background-image : url('<?=$article->getPicture() && file_exists(ARTICLE_IMG_DIR . $article->getPicture()) ? ARTICLE_IMG_DIR.$article->getPicture() : DEFAULT_ARTICLE_IMG?>')">
		<h1 class="text-center">Lecture</h1>
	</div>
	<ul class="nav justify-content-center sticky-top bg-dark">
		<li class="nav-item">
			<?php
			if ($index + 1 < count($article_list)) {
				$previous_article = $article_list[$index + 1];
			?>
				<a class="nav-link active" href="../public/index.php?route=article&articleId=<?= $previous_article; ?>">Chapitre précédent</a>
			<?php
			} else {
			?>
				<a class="nav-link active disabled text-secondary" href="">Chapitre précédent</a>
			<?php
			}
			?>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#" data-toggle="modal" data-target="#modalchapitres">Sélection du chapitre</a>
		</li>
		<li class="nav-item">
			<?php
			if ($index > 0) {
				$next_article = $article_list[$index - 1];
			?>
				<a class="nav-link" href="../public/index.php?route=article&articleId=<?= $next_article; ?>">Chapitre suivant</a>
			<?php
			} else {
			?>
				<a class="nav-link disabled text-secondary" href="">Chapitre suivant</a>
			<?php
			}
			?>
		</li>
	</ul>
	<section class="paper">
		<div class="container roman text-justify ">
			<h2 class="title text-primary"><?= htmlspecialchars($article->getTitle()); ?></h2>
			<?= $article->getContent(); ?>
		</div>
	</section>

	<div class="modal fade" id="modalchapitres" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Choisir un chapitre</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="list-group">
						<?php
						foreach ($articles as $article2) {
						?>
							<a href="../public/index.php?route=article&articleId=<?= $article2->getId() ?>" class="list-group-item list-group-item-action <?= $article2->getId() === $article->getId() ? 'active' : ''; ?>"><?= $article2->getTitle() ?></a>
						<?php
						}
						?>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

</main>