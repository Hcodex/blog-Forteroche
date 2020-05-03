<?php
$route = isset($post) && $post->get('id') ? 'editComment' : 'addComment';
$submit = $route === 'addComment' ? 'Commenter' : 'Mettre à jour';
?>
<div class="container">
    <h2 class="text-primary">Commenter</h2>
    <form method="post" action="../public/index.php?route=<?= $route; ?>&articleId=<?= htmlspecialchars($article->getId()); ?>">
        <label for="content">Votre commentaire</label><br>
        <textarea id="content" name="content"><?= isset($post) ? htmlspecialchars($post->get('content')) : ''; ?></textarea><br>
        <?= isset($errors['content']) ? $errors['content'] : ''; ?>
        <input class="btn btn-primary" type="submit" value="<?= $submit; ?>" id="submit" name="submit">
    </form>
</div>