<!doctype html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../public/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/styles.css" >

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
				<?php if ($this->session->get('pseudo')) {?>
					<li class="nav-item">
						<a class="nav-link btn btn-primary text-white" type="button" href="index.php?route=profile">Mon compte</a>                  
					</li>
					<li class="nav-item">
						<a class="nav-link btn btn-danger text-white" type="button" href="index.php?route=logout">Deconnexion</a>
					</li>
					<?php if ($this->session->get('role')==='admin') {?>
						<li class="nav-item">
							<a class="nav-link btn btn-warning text-dark" type="button" href="index.php?route=administration">Admin</a>
						</li>
					<? } ?>
				<? } else {?>
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

	<?php if ($this->session->get('success_message')) {?>

		<div class="row fixed-top msg-box">
			<div class="mx-auto alert alert-success alert-dismissible fade show col-md-4 col-md-offset-4" role="alert">
				<?= $this->session->show('success_message');?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div> 
	<?php }?>
	<?php if ($this->session->get('error_message')) {?>
		<div class="row fixed-top msg-box">
			<div class="mx-auto alert alert-danger alert-dismissible fade show col-md-4 col-md-offset-4" role="alert">
				<?= $this->session->show('error_message');?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div> 
	<?php }?>
</body>

<footer class="bg-secondary">
	<div class="footer-copyright bg-dark text-white text-center py-3">
        <p>2020 © Tous droits réservés | <a href="index.php?route=mentions_legales">Mentions légales</a> | <a href="index.php?route=politique_confidentialite">Politique de confidentialité</a></p>
		 <p class="my-0">Avertissement : Ce site est un projet d'étude, l'intégralité de son contenu est purement fictif</p>
	</div>
</footer>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
	feather.replace();
	$(window).scroll(function(){
		$('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
	});
	tinymce.init({
      selector: '.tinyMCE',
      plugins: 'code autoresize',
      toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent  |' + 'forecolor backcolor emoticons | help |'  + 'code'
      ,
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    }); 

	$(".img-pick").click(function(){
		$("#picture").val($(this).attr('data-img')) ;
		$("#article_img").attr('src', $(this).attr('data-img')) ;
		$('#image_picker').modal('hide');
	});

</script>

</body>
</html>