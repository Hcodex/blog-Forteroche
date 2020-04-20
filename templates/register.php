
<?php $this->title = "Billet simple pour l'Alaska - inscription"; ?>
	
<main role="main">
	
	<div class="page-header">
		<h1 class="text-center">Créer un compte</h1>
	</div>
	<section id="page-content">	
        <div class="container pb-5">	
            <h1 class="text-center text-primary pb-2">Formulaire d'inscription</h1>

            <p class="text-center text-success font-weight-bold"><?= isset($success) ? $success : ''; ?></p>
            
            <form method="post" action="../public/index.php?route=inscription">

                <div class="form-group">
                    <label for="email">Addresse mail</label>
                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="name@exemple.com" value="<?= isset($post) ? htmlspecialchars($post['email']): ''; ?>" required>
                    <div class="invalid-feedback">
                            <?= isset($errors['email']) ? $errors['email'] : ''; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control <?= isset($errors['pseudo']) ? 'is-invalid' : '' ?>" id="pseudo" name="pseudo" placeholder="Votre pseudo" value="<?= isset($post) ? htmlspecialchars($post['pseudo']): ''; ?>" required>
                    <div class="invalid-feedback">
                        <?= isset($errors['pseudo']) ? $errors['pseudo'] : ''; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" id="password" placeholder="Au moins 8 caractères " value="<?= isset($post) ? htmlspecialchars($post['password']): ''; ?>" required>   
                    <div class="invalid-feedback">
                        <?= isset($errors['password']) ? $errors['password'] : ''; ?>
                    </div>
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





