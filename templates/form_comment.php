<form method="post" action="../public/index.php?route=<?= $route; ?>&articleId=<?= htmlspecialchars($article->getId()); ?>">
    <div class="form-group">
        <label for="content">Votre commentaire</label>
        <textarea id="content" class="form-control <?= isset($errors['content']) ? 'is-invalid' : '' ?>" name="content"><?= isset($post) ? htmlspecialchars($post->get('content')) : ''; ?></textarea>
        <div class="invalid-feedback">
            <?= isset($errors['content']) ? $errors['content'] : ''; ?>
        </div>
    </div>
    <input class="btn btn-primary" type="submit" value="Commenter" id="submit" name="submit">
</form>