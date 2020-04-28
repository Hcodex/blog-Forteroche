<?php
$route = isset($post) && $post->get('id') ? 'editArticle&articleId=' . $post->get('id') : 'addArticle';
$submit = $route === 'addArticle' ? 'Envoyer' : 'Mettre à jour';


?>

<form method="post" action="../public/index.php?route=<?= $route; ?>">
    <input id="id" name="id" type="hidden" value="<?= isset($post) ? htmlspecialchars($post->get('id')) : ''; ?>">
    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" id="title" name="title" placeholder="Titre du chapitre" value="<?= isset($post) ? htmlspecialchars($post->get('title')) : ''; ?>" required>
        <div class="invalid-feedback">
            <?= isset($errors['title']) ? $errors['title'] : ''; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="picture">Image</label>
        <input type="text" class="form-control  <?= isset($errors['picture']) ? 'is-invalid' : '' ?>" id="picture" name="picture" placeholder="Image d'illustration" value="<?= isset($post) ? htmlspecialchars($post->get('picture')) : ''; ?>">
        <div class="invalid-feedback">
            <?= isset($errors['picture']) ? $errors['picture'] : ''; ?>
        </div>
    </div>
    <img id="article_img" src="<?= isset($post) ? htmlspecialchars($post->get('picture')) : ''; ?>" class="" width="100px" alt="Défaut">
    <?php include('image_picker.php'); ?>
    
    <div class="form-group mt-2">
        <label for="content">Contenu</label>
        <textarea class="tinyMCE form-control <?= isset($errors['content']) ? 'is-invalid' : '' ?>" id="content" name="content"><?= isset($post) ? htmlspecialchars($post->get('content')) : ''; ?></textarea>
        <div class="invalid-feedback">
            <?= isset($errors['content']) ? $errors['content'] : ''; ?>
        </div>
    </div>

    <div class="text-center">
        <input type="submit" class="btn btn-primary" value="Publier" id="submit" name="submit">
    </div>
</form>