<?php $this->title = "Billet simple pour l'Alaska - L'auteur"; ?>


<?php
$article_list = array();
foreach ($articles as $article2) {
	array_push($article_list, $article2->getId());
}
$index = (array_search($article->getId(), $article_list));
?>


<main role="main">

	<div class="page-header" style="background-image : url('<?= $article->getPicture() ?>')">
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
		<div class="container">
			<hr>
			<h2 class="text-primary">Commentaires</h2>

			<?php
			if ($this->session->get('pseudo')) {
				include('form_comment.php');
			} else {
			?>
				<p>Vous devez être connecté pour commenter</p>
			<?php
			}
			?>
		</div>
		<?php
		if (count($comments) !== 0) {
		?>
			<div class="container mt-5">
				<?php
				foreach ($comments as $comment) {
				?>
					<div class="card mb-3">
						<div class="row">
							<div class="col">
								<div class="card-body">
									<div class="media">
										<img src="<?= htmlspecialchars($comment->getAvatar()); ?>" class="align-self-center mr-3 comment-avatar" alt="Avatar <?= htmlspecialchars($comment->getPseudo()); ?>">
										<div class="media-body">
											<h5 class="mt-0 text-primary"><?= htmlspecialchars($comment->getPseudo()); ?></h5>
											<p><?= htmlspecialchars(strip_tags($comment->getContent())); ?></p>
										</div>
									</div>
								</div>
								<div class="card-footer table-active">
									<small class="text-muted"> Posté le <?= htmlspecialchars($comment->getCreatedAt("FR")); ?></small>
									<?php
									if ($comment->isReported() == 1) {
									?>
										<a class="btn float-right py-0 text-danger" href="#" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est déjà signalé"><i data-feather="alert-triangle"></i> </a>

									<?php
									} elseif ($comment->isReported() == 2) {
									?>
										<a class="btn float-right py-0 text-success" href="#" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est approuvé par le modérateur"><i data-feather="check-circle"></i> </a>

									<?php
									} else {
									?>
										<a class="btn float-right py-0 text-muted" href="../public/index.php?route=reportComment&commentId=<?= $comment->getId(); ?>" data-toggle="tooltip" data-placement="bottom" title="Signaler le commentaire"><i data-feather="alert-triangle"></i> </a>
									<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
			<?php
				}
			}
			?>
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