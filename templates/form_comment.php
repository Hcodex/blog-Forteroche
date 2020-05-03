<form method="post" action="../public/index.php?route=addComment&articleId=<?= htmlspecialchars($article->getId()); ?>">
    <div class="form-group">
        <label for="content">Votre commentaire</label>
        <textarea id="content" class="comment-text-area form-control <?= isset($errors['content']) ? 'is-invalid' : '' ?>" name="content" maxlength=600><?= isset($post) ? htmlspecialchars($post->get('content')) : ''; ?></textarea>
        <div class="invalid-feedback">
            <?= isset($errors['content']) ? $errors['content'] : ''; ?>
        </div>
        <small id="char_counter" class="form-text text-muted float-right">0/600 max</small>
    </div>
    <input class="btn btn-primary" type="submit" value="Commenter" id="submit" name="submit">
</form>