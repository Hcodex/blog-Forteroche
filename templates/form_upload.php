<?php
$route = $this->request->getGet()->get('route');
if ($route === "administration") {
    $upload_mode = "article";
}elseif   ($route === "profile"){
    $upload_mode = "avatar";
}

?>
<div class="my-3">
    <b>Envoyer une image</b>
    <form method="post" action="index.php?route=upload&upload_mode=<?= $upload_mode ?>" enctype="multipart/form-data">
        <div class="input-group my-2 ">
            <div class="input-group-prepend">
                <input type="submit" class="btn btn-primary" value="Envoyer" id="submit" name="submit">
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" required>
                <label class="custom-file-label" for="fileToUpload" data-browse="Parcourir">Image à uploader</label>
            </div>
        </div>
    </form>
</div>