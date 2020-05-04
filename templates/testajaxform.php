<b>Envoyer une image</b>
	<form id="myForm" method="post" action="index.php?route=ajax" enctype="multipart/form-data">
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
	<div class="progress">
		<div class="progress-bar" role="progressbar"></div>
	</div>