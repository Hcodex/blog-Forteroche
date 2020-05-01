<?php

if ($this->request->getGet()->get('route') === "profile") {
    $dir = AVATAR_IMG_DIR . $this->session->get('id') . '/';
    $thumb_dir = AVATAR_IMG_DIR . $this->session->get('id') . '/thumb/';
    $default_img = DEFAULT_AVATAR_IMG;
    $current_img = $this->session->get('avatar') !== NULL && $this->session->get('avatar') !== "" && $this->session->get('avatar') !== $default_img ? $thumb_dir . $this->session->get('avatar') : $default_img;;
} elseif ($this->request->getGet()->get('route') === "editArticle") {
    $dir = ARTICLE_IMG_DIR;
    $thumb_dir = ARTICLE_THUMB_DIR;
    $default_img = DEFAULT_ARTICLE_IMG;
    $current_img = $post->get('picture') !== NULL && $post->get('picture') !== "" && $this->session->get('picture') !== $default_img ? ARTICLE_THUMB_DIR . htmlspecialchars($post->get('picture')) : $default_img;
} else {
    $dir = ARTICLE_IMG_DIR;
    $thumb_dir = ARTICLE_THUMB_DIR;
}


if (is_dir($dir)) {
    $img_list = array();
    $files = scandir($dir, 1);
    foreach ($files as $fichier) {
        $info = new SplFileInfo($fichier);
        $info->getExtension();
        if ($info->getExtension() === 'jpg' || $info->getExtension() === 'png' || $info->getExtension() === 'jpeg' || $info->getExtension() === 'gif') {
            array_push($img_list, array($dir . $fichier, $thumb_dir . $fichier));
        }
    }
}

?>


<a class="col-md-2 btn btn-primary text-white" type="button" href="" data-toggle="modal" data-target="#image_manager">Images</a>

<div class="modal fade" id="image_manager">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Images</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="../public/index.php?route=filesdelete">

                    <select class="custom-select" id="file_selector" name="file_selector[]" multiple>
                        <?php
                        foreach ($img_list as $img) {
                        ?>
                            <option value="<?= $img[0]; ?>">Cute Kitten 4</option>
                        <?php
                        }

                        ?>
                    </select>

                    <?php
                    foreach ($img_list as $img) {
                    ?>
                        <img class="img-select" alt="" src="<?= $img[1] ?>" style=" max-width : 100%; max-height:80px" data-img="<?= $img[0] ?>" />
                    <?php
                    }
                    ?>

                    <input type="submit" class="btn btn-danger" value="Supprimer" id="submit" name="submit">

                </form>


            </div>
        </div>
    </div>
</div>