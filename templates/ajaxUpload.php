<?php
$route = $this->request->getGet()->get('route');
if ($route === "administration") {
    $upload_mode = "article";
}elseif   ($route === "profile"){
    $upload_mode = "avatar";
}
?>

<b>Envoyer une image</b>
<form id="uploadForm" method="post" action="index.php?route=ajax" enctype="multipart/form-data">
	<div class="input-group my-2 ">
		<div class="input-group-prepend">
			<input type="submit" class="btn btn-primary" value="Envoyer" id="submit" name="submit">
		</div>
		<input type="hidden" id="mode" name="mode" value="<?= $upload_mode ?>">
		<div class="custom-file">
			<input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" required>
			<label class="custom-file-label" for="fileToUpload" data-browse="Parcourir">Image à uploader</label>
		</div>
	</div>
</form>
<div class="progress">
	<div class="progress-bar" role="progressbar"></div>
</div>

<div class="alert alert-success alert-dismissible fade fixed-top msg-box col-6 mx-auto" role="alert">
	<span class="alert-content"></span>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="alert alert-danger alert-dismissible fade fixed-top msg-box col-6 mx-auto" role="alert">
	<span class="alert-content"></span>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div id='testdiv'></div>