<?php

use App\src\services\Formater;

$this->title = "Billet simple pour l'Alaska - L'auteur"; ?>

<main role="main">

	<div class="page-header" style="background-image : url('<?= $article->getPicture() ?>')">
		<h1 class="text-center">Lecture</h1>
	</div>
	<ul class="nav justify-content-center sticky-top bg-dark">
		<li class="nav-item">
			<?php
			if ($previousArticleIndex) {
			?>
				<a class="nav-link px-0" href="index.php?route=article&articleId=<?= $previousArticleIndex; ?>">
					<i data-feather="chevron-left" data-toggle="tooltip" data-placement="bottom" title="Chapitre précédent"></i>
				</a>
			<?php
			}
			?>
		</li>
		<li class="nav-item">
			<a class="nav-link  px-2" href="#" data-toggle="modal" data-target="#modalchapitres">Sélection du chapitre</a>
		</li>
		<li class="nav-item">
			<?php
			if ($nextArticleIndex) {
			?>
				<a class="nav-link px-0" href="index.php?route=article&articleId=<?= $nextArticleIndex; ?>">
					<i data-feather="chevron-right" data-toggle="tooltip" data-placement="bottom" title="Chapitre suivant"></i>
				</a>
			<?php
			}
			?>
		</li>
	</ul>

	<div class="addBookmark float-right my-2 sticky-top rounded-circle bg-warning shadow">
		<?php
		if ($this->session->get('pseudo')) {
		?>
			<a href="index.php?route=setBookmark&articleId=<?= $article->getId(); ?>" data-toggle="tooltip" data-placement="bottom" title="Marquer cette page">
				<i class="text-white m-2" data-feather="bookmark"></i>
			</a>
		<?php
		} else {
		?>
			<a data-toggle="tooltip" data-placement="bottom" title="Veuillez vous connecter pour utiliser la fonction marque page">
				<i class="text-muted m-2" data-feather="bookmark"></i>
			</a>
		<?php
		}
		?>
	</div>

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
									<small class="text-muted"> Posté le <?= Formater::formatFR(htmlspecialchars($comment->getCreatedAt())); ?></small>
									<?php
									if ($comment->isReported() == 1) {
									?>
										<span class="float-right py-0 text-danger" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est déjà signalé"><i data-feather="alert-triangle"></i> </span>

									<?php
									} elseif ($comment->isReported() == 2) {
									?>
										<span class="float-right py-0 text-success" data-toggle="tooltip" data-placement="bottom" title="Ce commentaire est approuvé par le modérateur"><i data-feather="check-circle"></i> </span>

									<?php
									} else {
									?>
										<a class="btn float-right py-0 text-muted" href="index.php?route=reportComment&commentId=<?= $comment->getId(); ?>" data-toggle="tooltip" data-placement="bottom" title="Signaler le commentaire"><i data-feather="alert-triangle"></i> </a>
									<?php
									}
									if ($this->session->get('role') === 'admin' || $this->session->get('role') === 'corrector') {
									?>
										<a class="btn float-right py-0" href="index.php?route=approveComment&commentId=<?= $comment->getId(); ?>">
											<i class="text-secondary" data-feather="check-circle" data-toggle="tooltip" data-placement="bottom" title="Approuver"></i>
										</a>
										<a class="btn float-right py-0" href="index.php?route=hideComment&commentId=<?= $comment->getId(); ?>">
											<i class="text-secondary" data-feather="eye-off" data-toggle="tooltip" data-placement="bottom" title="Masquer"></i>
										</a>
										<a class="btn float-right py-0" href="index.php?route=archiveComment&commentId=<?= $comment->getId(); ?>">
											<i class="text-secondary" data-feather="save" data-toggle="tooltip" data-placement="bottom" title="Archiver"></i>
										</a>
										<a class="btn float-right py-0" href="#" onclick="setConfirmModal('index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>')">
											<i class="text-danger" data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Supprimer"></i>
										</a>
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
						foreach ($articlesIndex as $articleIndex) {
						?>
							<a href="index.php?route=article&articleId=<?= $articleIndex->getId() ?>" class="list-group-item list-group-item-action <?= $articleIndex->getId() === $article->getId() ? 'active' : ''; ?>"><?= $articleIndex->getTitle() ?></a>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>