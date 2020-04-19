
<?php $this->title = "Billet simple pour l'Alaska - inscription"; ?>
	
<main role="main">
	
	<div class="page-header">
		<h1 class="text-center">Créer un compte</h1>
	</div>
	<section id="page-content">	
        <div class="container pb-5">	
            <h1 class="text-center text-primary pb-2">Formulaire d'inscription</h1>

            
            <form method="post" action="../public/index.php?route=inscription">

                <div class="form-group">
                    <label for="email">Addresse mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                </div>
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Votre pseudo" required>
                    <small id="pseudoHelpInline" class="text-muted">
                         <?= isset($errors['pseudo']) ? $errors['pseudo'] : ''; ?>
                    </small>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" required>   
                    <small id="passwordHelpInline" class="text-muted">
                    Au moins 8 caractères  <?= isset($errors['password']) ? $errors['password'] : ''; ?>
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
                    <input type="submit" class="btn btn-primary" value="Inscription" id="submit" name="submit">
				</div>
            </form>
        </div>	
    </section>
</main>





