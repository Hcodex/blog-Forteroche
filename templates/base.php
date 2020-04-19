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
</head>

<header>
	<nav class="navbar fixed-top navbar-expand-lg">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
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
				<li class="nav-item">
					<a class="nav-link btn btn-primary text-white" type="button" href="index.php?route=inscription">Inscription</a>                  
				</li>
				<li class="nav-item">
					<a class="nav-link btn btn-danger text-white" type="button" href="#" data-toggle="modal" data-target="#myModal1">Connexion</a>
				</li>
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
				<form>
					<label class="sr-only" for="usrname">e-mail</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="e-mail" aria-label="E-mail" aria-describedby="basic-addon1">
					</div>


					<label class="sr-only" for="Password">Mot de passe</label>
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon2"><i class="fa fa-key"></i></span>
						</div>
						<input id="Password" type="password" class="form-control" placeholder="Mot de passe" aria-label="Mot de passe" aria-describedby="basic-addon2">
					</div>
				</form>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" >Se connecter</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
			</div>

		</div>
	</div>
</div>


<body>
    <div id="content">
        <?= $content ?>
    </div>
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
	$(window).scroll(function(){
		$('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
	});
</script>

</body>
</html>