<form method="post" action="index.php?route=login">
    <div class="form-group">
        <label for="email">Addresse mail</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="name@exemple.com" value="<?= isset($post) ? htmlspecialchars($post->get('email')) : ''; ?>" required>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Saisir votre mot de passe" value="" required>
        <small class="form-text text-muted"><a href="index.php?route=requestAccountRecovery">Mot de passe Oublié ?</a></small>
    </div>
    <input type="submit" class="btn btn-primary" value="Se connecter" id="login" name="login">
</form>