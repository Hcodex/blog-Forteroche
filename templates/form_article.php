<?php
include('image_manager.php');
$route = isset($post) && $post->get('id') ? 'editArticle&articleId=' . $post->get('id') : 'addArticle';
$submit = $route === 'addArticle' ? 'Envoyer' : 'Mettre à jour';
?>


<form method="post" action="index.php?route=<?= $route; ?>">
    <input id="id" name="id" type="hidden" value="<?= isset($post) ? htmlspecialchars($post->get('id')) : ''; ?>">
    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" id="title" name="title" placeholder="Titre du chapitre" value="<?= isset($post) ? htmlspecialchars($post->get('title')) : ''; ?>" required>
        <div class="invalid-feedback">
            <?= isset($errors['title']) ? $errors['title'] : ''; ?>
        </div>
    </div>


    <input type="hidden" class="form-control  <?= isset($errors['picture_file_name']) ? 'is-invalid' : '' ?>" id="picture_file_name" name="picture_file_name" placeholder="Image d'illustration" value="<?= isset($post) ? htmlspecialchars($post->get('picture_file_name')) : ''; ?>">

    
    <div class="form-group mt-2">
        <label for="content">Contenu</label>
        <textarea class="tinyMCE form-control <?= isset($errors['content']) ? 'is-invalid' : '' ?>" id="content" name="content"><?= isset($post) ? htmlspecialchars($post->get('content')) : ''; ?></textarea>
        <div class="invalid-feedback">
            <?= isset($errors['content']) ? $errors['content'] : ''; ?>
        </div>
    </div>

    <div class="text-center">
        <input type="submit" class="btn btn-primary" value="Sauvegarder brouillon" id="draft" name="draft">
        <input type="submit" class="btn btn-primary" value="Soumettre au correcteur" id="toCorrect" name="toCorrect">
        <input type="submit" class="btn btn-primary" value="Publier" id="publish" name="publish">
    </div>
</form>