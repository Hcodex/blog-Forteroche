<!doctype html>
<html lang="fr">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name="description" content="Billet simple pour l'Alaska, le roman en ligne de Jean Forteroche" />

	<!-- Bootstrap CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css">

	<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

	<title><?= $title ?></title>

	<script src="https://unpkg.com/feather-icons"></script>
	<script src="https://cdn.tiny.cloud/1/lvd5tn4x6nhbmks284whak0h08xg7t4u2txdd9ers8cvv2ui/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body>
	<header>
		<nav class="navbar fixed-top navbar-expand-lg">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<i data-feather="menu"></i>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto topnav">
					<li class="nav-item active">
						<a class="nav-link" href="index.php?route=home">Accueil <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="index.php?route=roman">Le roman</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php?route=auteur">L'auteur</a>
					</li>
					<?php if ($this->session->get('pseudo')) { ?>

						<li class="nav-item dropdown ">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
								<?= $this->session->get('pseudo') ?>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item text-dark" href="index.php?route=profile">
									<i data-feather="user" class="mx-2"></i>Mon profil
								</a>
								<?php
								if ($this->session->get('last_article_id') !== NULL) {
								?>
									<a class="dropdown-item text-dark" href="index.php?route=article&articleId=<?= $this->session->get('last_article_id'); ?>">
										<i data-feather="book-open" class="mx-2"></i>Reprendre la lecture
									</a>
								<?php
								} else {
								?>
									<span data-toggle="tooltip" data-placement="bottom" title="Marque page non placé">
										<a class="dropdown-item disabled text-muted" href="#">
											<i data-feather="book-open" class="mx-2"></i>Reprendre la lecture
										</a>
									</span>
								<?php
								}
								?>
								<?php if ($this->session->get('role') === 'admin' || $this->session->get('role') === 'corrector') { ?>
									<a class="dropdown-item text-warning" href="index.php?route=administration">
										<i data-feather="sliders" class="mx-2"></i>Administration
									</a>
								<? } ?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item text-danger" href="index.php?route=logout">
									<i data-feather="power" class="mx-2"></i>Déconnexion
								</a>
							</div>
						</li>
					<? } else { ?>
						<li class="nav-item">
							<a class="nav-link btn btn-primary text-white border-0" type="button" href="index.php?route=inscription">Inscription</a>
						</li>
						<li class="nav-item">
							<a class="nav-link btn btn-danger text-white border-0" type="button" href="#" data-toggle="modal" data-target="#myModal1">Connexion</a>
						</li>
					<? } ?>
				</ul>
			</div>
		</nav>
	</header>
	<!-- The Modal -->
	<div class="modal fade" id="myModal1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Se connecter</h4>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<?php include('form_login.php'); ?>
				</div>
			</div>
		</div>
	</div>

	<div id="content">
		<?= $content ?>
	</div>



	<div id="confirmModal" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i data-feather="alert-triangle" class="text-danger"></i> Attention</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<a id="confirmBtn" href="" type="button" class="btn btn-danger">Confirmer</a>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
				</div>
			</div>
		</div>
	</div>

	<footer class="bg-secondary">
		<div class="footer-copyright bg-dark text-white text-center py-3">
			<p>2020 © Tous droits réservés | <a href="index.php?route=mentionsLegales">Mentions légales</a> | <a href="index.php?route=politiqueConfidentialite">Politique de confidentialité</a></p>
			<p class="my-0">Avertissement : Ce site est un projet d'étude, l'intégralité de son contenu est purement fictif</p>
		</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="js/init.js"></script>

	<?php if ($this->session->get('success_message')) { ?>
		<script>
			showAlert("<?= $this->session->show('success_message') ?>", "success", 5000);
		</script>
	<?php } ?>
	<?php if ($this->session->get('error_message')) { ?>
		<script>
			showAlert("<?= $this->session->show('error_message') ?>", "danger", 5000);
		</script>
	<?php } ?>

</body>

</html>