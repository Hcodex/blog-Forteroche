
<?php 
$this->title = "Billet simple pour l'Alaska - inscription"; 
?>
	
    <main role="main">
        
        <div class="page-header">
            <h1 class="text-center">Réinitialisation mot de passe</h1>
        </div>
        <section id="page-content">	
            <div class="container pb-5">	
                <h1 class="text-center text-primary pb-2">Nouveau mot de passe</h1>
                  
                <form method="post" action="index.php?route=accountRecovery">
    
                    <div class="form-group">
                        <label for="email">Addresse mail</label>
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="name@exemple.com" value="<?= isset($post) ? htmlspecialchars($post->get('email')): ''; ?>" required>
                        <div class="invalid-feedback">
                                <?= isset($errors['email']) ? $errors['email'] : ''; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" id="password" placeholder="Au moins 8 caractères" value="" required>   
                        <div class="invalid-feedback">
                            <?= isset($errors['password']) ? $errors['password'] : ''; ?>
                        </div>
                    </div>
                    <input type="hidden" name="token"  value="<?= $post->get('token') !== NULL  ? htmlspecialchars($post->get('token')): $this->request->getGet()->get('token'); ?>"/>
                    <div class="form-group">
                        <label for="passwordConfirm">Confirmer le mot de passe</label>
                        <input type="password" class="form-control <?= isset($errors['passwordConfirm']) ? 'is-invalid' : '' ?>" name="passwordConfirm" id="passwordConfirm" placeholder="Confirmer le mot de passe" value="" required>   
                        <div class="invalid-feedback">
                            <?= isset($errors['passwordConfirm']) ? $errors['passwordConfirm'] : ''; ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Valider" id="submit" name="submit">
                    </div>
                </form>
            </div>	
        </section>
    </main>
    
    
    
    
    
    