


<form  method="post" action="../public/index.php?route=connexion">
        <div class="form-group">
            <label for="email">Addresse mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@exemple.com" value="<?= isset($post) ? htmlspecialchars($post->get('email')): ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Saisir votre mot de passe" value="<?= isset($post) ? htmlspecialchars($post->get('password')): ''; ?>" required>
        </div>  
        <input type="submit" class="btn btn-primary" value="Se connecter" id="submit" name="submit">
</form>