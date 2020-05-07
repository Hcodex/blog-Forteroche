<!doctype html>
<html lang="fr">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css">

	<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

	<title><?= $title ?></title>

	<script src="https://unpkg.com/feather-icons"></script>
	<script src="https://cdn.tiny.cloud/1/lvd5tn4x6nhbmks284whak0h08xg7t4u2txdd9ers8cvv2ui/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

</head>

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
					<li class="nav-item">
						<a class="nav-link btn btn-primary text-white" type="button" href="index.php?route=profile">Mon compte</a>
					</li>
					<li class="nav-item">
						<a class="nav-link btn btn-danger text-white" type="button" href="index.php?route=logout">Deconnexion</a>
					</li>
					<?php if ($this->session->get('role') === 'admin') { ?>
						<li class="nav-item">
							<a class="nav-link btn btn-warning text-dark" type="button" href="index.php?route=administration">Admin</a>
						</li>
					<? } ?>
				<? } else { ?>
					<li class="nav-item">
						<a class="nav-link btn btn-primary text-white" type="button" href="index.php?route=inscription">Inscription</a>
					</li>
					<li class="nav-item">
						<a class="nav-link btn btn-danger text-white" type="button" href="#" data-toggle="modal" data-target="#myModal1">Connexion</a>
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
				<?php
				include '../templates/form_login.php';
				?>
			</div>
		</div>
	</div>
</div>


<body>
	<div id="content">
		<?= $content ?>
	</div>

	<?php if ($this->session->get('success_message')) { ?>

		<div class="row fixed-top msg-box">
			<div class="mx-auto alert alert-success alert-dismissible fade show col-md-4 col-md-offset-4" role="alert">
				<?= $this->session->show('success_message'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->session->get('error_message')) { ?>
		<div class="row fixed-top msg-box">
			<div class="mx-auto alert alert-danger alert-dismissible fade show col-md-4 col-md-offset-4" role="alert">
				<?= $this->session->show('error_message'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php } ?>

	<div id="confirmModal" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i data-feather="alert-triangle" class="text-danger"></i> Suppression</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Attention, l'élément sélectionné va être supprimé définitivement !</p>
				</div>
				<div class="modal-footer">
					<a id="confirmBtn" href="" type="button" class="btn btn-danger">Supprimer</a>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
				</div>
			</div>
		</div>
	</div>

	<footer class="bg-secondary">
		<div class="footer-copyright bg-dark text-white text-center py-3">
			<p>2020 © Tous droits réservés | <a href="index.php?route=mentions_legales">Mentions légales</a> | <a href="index.php?route=politique_confidentialite">Politique de confidentialité</a></p>
			<p class="my-0">Avertissement : Ce site est un projet d'étude, l'intégralité de son contenu est purement fictif</p>
		</div>
	</footer>

	<script src="js/init.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	
	<script>
		feather.replace();
		$(window).scroll(function() {
			$('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
		});
		tinymce.init({
			selector: '.tinyMCE',
			plugins: 'code autoresize',
			toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
				'bullist numlist outdent indent  |' + 'forecolor backcolor emoticons | help |' + 'code',
			toolbar_mode: 'floating',
			tinycomments_mode: 'embedded',
			tinycomments_author: 'Author name',
		});

		$("#img-select-btn").click(function() {
			$("#picture_file_name").val($('.custom-select>option[selected="selected"]').attr('data-filename'));
			$("#picked_img").attr('src', $(".img-select.selected").attr('src'));
			$('#image_manager').modal('hide');

		});

		$("#uploaded-img-list").on('click', '.img-select', function() {
			$val = $(this).attr('data-img')
			$('.custom-select>option[data-filename="' + $val + '"]').attr('selected') ?
				$('.custom-select>option[data-filename="' + $val + '"]').removeAttr('selected') : $('.custom-select>option[data-filename="' + $val + '"]').attr('selected', 'selected');
			$(this).toggleClass('border border-primary selected');
			$('.img-select.selected').length == 1 ?
				$("#img-select-btn").removeClass('disabled') : $("#img-select-btn").addClass('disabled', 'disabled');
			$('.custom-select>option[selected="selected"]').length < 1 ?
				$(".img-delete-btn").attr('disabled', 'disabled') : $(".img-delete-btn").removeAttr('disabled');
		});

		$('.custom-file input').change(function(e) {
			if (e.target.files.length) {
				$(this).next('.custom-file-label').html(e.target.files[0].name);
			}
		});


		$('#image_manager').on('hide.bs.modal', function(e) {
			$('.img-select.selected').removeClass('selected border-primary border');
			$('.custom-select>option').removeAttr('selected')
		});

		function setConfirmModal(data) {
			//you can do anything with data, or pass more data to this function. i set this data to modal header for example
			event.preventDefault();
			$("#confirmModal #confirmBtn").attr('href', data);
			$("#confirmModal").modal();
		}

		$('.comment-text-area').on("input", function() {
			var maxlength = $(this).attr("maxlength");
			var currentLength = $(this).val().length;

			if (currentLength >= maxlength) {
				$('#char_counter').text(currentLength + "/" + maxlength + 'max')
				$('#char_counter').removeClass('text-muted');
				$('#char_counter').addClass('text-danger');
			} else {
				$('#char_counter').text(currentLength + "/" + maxlength + 'max')
				$('#char_counter').addClass('text-muted');
				$('#char_counter').removeClass('text-danger');
			}
		});

		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})



		$("#myForm").submit(function(e) {
			e.preventDefault();

			$.ajax({
				type: 'POST',
				url: 'index?route=ajax',
				data: new FormData(this),
				contentType: false,
				processData: false,
				xhr: function() {
					//upload Progress
					var xhr = $.ajaxSettings.xhr();
					if (xhr.upload) {
						xhr.upload.addEventListener('progress', function(event) {
							var percent = 0;
							var position = event.loaded || event.position;
							var total = event.total;
							if (event.lengthComputable) {
								percent = Math.ceil(position / total * 100);
							}
							if (percent == 100) {
								$('.progress-bar').text("Envoi terminé, compression en cours...");
								$('.progress-bar').width(percent + "%");
								$('.progress-bar').addClass('progress-bar-striped progress-bar-animated');

							} else {
								$('.progress-bar').text(percent + "%");
								$('.progress-bar').width(percent + "%");
							}
						}, true);
					}
					return xhr;
				},
				//end upload progress
				success: function(data) {
					$('.progress-bar').removeClass('progress-bar-striped progress-bar-animated');
					$('.progress-bar').text("Terminé");
					const response = JSON.parse(data);
					if (response["error"] === null) {
						showAlert("<strong>Upload réussi</strong>", "success", 5000);
						$('#image_manager #file_selector').append('<option value="'+response["imageThumbail"]+'" data-filename="'+response["imageName"]+'"></option>');
						$('#image_manager #file_selector').append('<option value="'+response["imageSrc"]+'" data-filename="'+response["imageName"]+'"></option>');
						$('#image_manager #uploaded-img-list').append('<img class="img-select" alt="" src="'+response["imageThumbail"]+'" style=" max-width : 100%; max-height:80px" data-img="'+response["imageName"]+'">');

					} else {
						showAlert(response["message"], "danger", 5000);
					}
				},
				error: function() {
					showAlert("<strong>Erreur</strong>, la reqête n'a pu aboutir", "danger", 5000);
				}
			});
		});
	</script>

</body>

</html>