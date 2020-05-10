<form  method="post" action="index.php?route=requestToken">
        <div class="form-group">
            <label for="email">Addresse mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@exemple.com" value="<?= isset($post) ? htmlspecialchars($post->get('email')): ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Saisir votre mot de passe" value="" required>
        </div>  
        <input type="submit" class="btn btn-primary" value="Renvoyer une clé d'activation" id="submit" name="submit">
</form>