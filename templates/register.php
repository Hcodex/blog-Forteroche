<?php $this->title = "Billet simple pour l'Alaska - inscription"; ?>
	
<main role="main">
	
	<div class="page-header">
		<h1 class="text-center">Créer un compte</h1>
	</div>
	<section id="page-content">	
        <div class="container pb-5">	
            <h1 class="text-center text-primary pb-2">Formulaire d'inscription</h1>
            <form method="post" action="../public/index.php?route=register">

                <div class="form-group">
                    <label for="email">Addresse mail</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                </div>
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" placeholder="Votre pseudo" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" required>   
                    <small id="passwordHelpInline" class="text-muted">
                    Au moins 8 caractères
                    </small>
                </div>
                <div class="form-group">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="policy-checkbox" required>
                    <label class="form-check-label" for="policy-checkbox">
                        J'accepte les termes de la <a href="index.php?route=politique_confidentialite">politique de confidentialité</a></p>
                    </label>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Inscription</button>
				</div>
            </form>
        </div>	
    </section>
</main>