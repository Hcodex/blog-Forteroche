<?php
$route = "addComment";
foreach ($comments as $comment) {
    if ($this->session->get('pseudo') === $comment->getPseudo()) {
        $mycomment = htmlspecialchars(strip_tags($comment->getContent()));
        $route = "editComment";
    }
}
$submit = $route === 'addComment' ? 'Ajouter' : 'Mettre à jour';
?>

<form method="post" action="../public/index.php?route=<?= $route; ?>&articleId=<?= htmlspecialchars($article->getId()); ?>">
    <div class="form-group">
        <label for="content">Votre commentaire</label>
        <textarea id="content" class="comment-text-area form-control <?= isset($errors['content']) ? 'is-invalid' : '' ?>" name="content" maxlength=600><?= isset($post) ? htmlspecialchars($post->get('content')) : $mycomment; ?></textarea>
        <div class="invalid-feedback">
            <?= isset($errors['content']) ? $errors['content'] : ''; ?>
        </div>
        <small id="char_counter" class="form-text text-muted float-right">0/600 max</small>
    </div>
    <input class="btn btn-primary" type="submit" value="<?= $submit; ?>" id="submit" name="submit">
</form>