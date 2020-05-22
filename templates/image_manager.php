<?php

$route = $this->request->getGet()->get('route');
if ($route === "profile") {
    $dir = AVATAR_IMG_DIR . $this->session->get('id') . '/';
    $thumb_dir = AVATAR_IMG_DIR . $this->session->get('id') . '/thumb/';
    $default_img = DEFAULT_AVATAR_IMG;
    $current_img = $user->getAvatarSrc();
    $select_btn_text = "Choisir comme avatar";
} elseif ($route  === "editArticle") {
    $dir = ARTICLE_IMG_DIR;
    $thumb_dir = ARTICLE_THUMB_DIR;
    $default_img = DEFAULT_ARTICLE_IMG;
    $current_img = $post->get('thumbail');
    $select_btn_text = "Définir comme image de l'article";
} else {
    $dir = ARTICLE_IMG_DIR;
    $thumb_dir = ARTICLE_THUMB_DIR;
    $default_img = DEFAULT_ARTICLE_IMG;
    $current_img = DEFAULT_ARTICLE_IMG;
    $select_btn_text = "Définir comme image de l'article";
}

$img_list = array();
if (is_dir($dir)) {
    $files = scandir($dir, 1);
    foreach ($files as $fichier) {
        $info = new SplFileInfo($fichier);
        $info->getExtension();
        if ($info->getExtension() === 'jpg' || $info->getExtension() === 'png' || $info->getExtension() === 'jpeg' || $info->getExtension() === 'gif') {
            array_push($img_list, array('picture' => $dir . $fichier, 'thumbail' => $thumb_dir . $fichier, 'fileName' => $fichier));
        }
    }
}

if ($route === "profile" || $route === "editArticle" || $route === "addArticle") {
?>
    <img id="picked_img" src="<?= $current_img ?>" class="border" width="180px" alt="Image Actuelle" data-toggle="modal" data-target="#image_picker">
<?php
}
?>
<div class="my-2">
    <a class="btn btn-primary text-white" type="button" href="" data-toggle="modal" data-target="#image_manager">Parcourir les images</a>
</div>

<div class="modal fade" id="image_manager">
    <div class="modal-dialog modal-dialog-centered text-left">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Images</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <form id="filesDelete" method="post" action="index.php?route=filesdelete">
                <div class="modal-body">
                    <select class="custom-select" id="file_selector" name="file_selector[]" multiple>
                        <?php
                        foreach ($img_list as $img) {
                        ?>
                            <option value="<?= $img['picture']; ?>" data-filename="<?= $img['fileName'] ?>"></option>
                            <option value="<?= $img['thumbail']; ?>" data-filename="<?= $img['fileName'] ?>"></option>

                        <?php
                        }

                        ?>
                    </select>
                    <div id="img-list">
                        <div id="uploaded-img-list" class="d-flex flex-wrap">
                        <?php
                        foreach ($img_list as $img) {
                        ?>
                            <img class="img-select" alt="" src="<?= $img['thumbail'] ?>" style=" max-width : 100%; max-height:80px" data-img="<?= $img['fileName'] ?>" />
                        <?php
                        }
                        ?>
                        </div>
                        <div>
                            <p class="mt-3 mb-0">Image par défaut :</p>
                            <img class="img-select default-img" alt="" src="<?= $default_img ?>" style="height:80px" data-img="" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="mr-auto" type="button" href="" data-toggle="collapse" data-target="#collapseExample">
                        <i data-feather="file-plus" data-toggle="tooltip" data-placement="bottom" title="Uploader une image"></i>
                    </a>
                    <input type="submit" class="btn btn-danger img-delete-btn" value="Effacer du serveur" id="submit" name="submit" disabled>
                    <?
                    if ($route === "profile" || $route === "editArticle" || $route === "addArticle") {
                    ?>
                        <a id="img-select-btn" class="btn btn-primary text-white" type="button" href="#"><?= $select_btn_text ?></a>
                    <?php
                    }
                    ?>
                </div>
            </form>
            <div class="collapse p-3" id="collapseExample">
                <?php
                include('ajaxUpload.php');
                ?>
            </div>
        </div>
    </div>
</div>