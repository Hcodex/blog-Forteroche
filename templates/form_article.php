<form method="post" action="../public/index.php?route=addArticle">
    
    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" id="title" name="title" placeholder="Titre du chapitre" value="<?= isset($post) ? htmlspecialchars($post->get('title')): ''; ?>" required>
        <div class="invalid-feedback">
                <?= isset($errors['title']) ? $errors['title'] : ''; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="picture">Image</label>
        <input type="text" class="form-control <?= isset($errors['picture']) ? 'is-invalid' : '' ?>" id="picture" name="picture" placeholder="Image d'illustration" value="<?= isset($post) ? htmlspecialchars($post->get('picture')): ''; ?>">
        <div class="invalid-feedback">
                <?= isset($errors['picture']) ? $errors['picture'] : ''; ?>
        </div>
     </div>

     <div class="form-group">
        <label for="content">Contenu</label>
        <textarea class="form-control <?= isset($errors['content']) ? 'is-invalid' : '' ?>" id="content" name="content" value="<?= isset($post) ? htmlspecialchars($post->get('content')): ''; ?>"></textarea>
        <div class="invalid-feedback">
                <?= isset($errors['content']) ? $errors['content'] : ''; ?>
        </div>
     </div>

    
    <div class="text-center">
        <input type="submit" class="btn btn-primary" value="Publier" id="submit" name="submit">
    </div>
</form>