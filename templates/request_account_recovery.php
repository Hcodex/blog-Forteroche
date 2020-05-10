<?php $this->title = "Billet simple pour l'Alaska - Connexion"; ?>
<main role="main">
    <div class="page-header">
        <h1 class="text-center">Récupérer l'accès</h1>
    </div>
    <section id="page-content">
        <div class="container pb-5">
            <h1 class="text-center text-primary pb-2">Demande de réinitialisation de mot de passe</h1>
            <form method="post" action="index.php?route=requestAccountRecovery">
                <div class="form-group">
                    <label for="email">Addresse mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@exemple.com" value="<?= isset($post) ? htmlspecialchars($post->get('email')) : ''; ?>" required>
                </div>
                <input type="submit" class="btn btn-primary" value="Envoyer la demande" id="submit" name="submit">
            </form>
        </div>
    </section>
</main>