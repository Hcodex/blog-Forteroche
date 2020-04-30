<?php

if ($this->request->getGet()->get('route') === "profile") {
	$dir = AVATAR_IMG_DIR . $this->session->get('id') . '/';
	$thumb_dir = AVATAR_IMG_DIR . $this->session->get('id') . '/thumb/';
	$current_img = $thumb_dir.$this->session->get('avatar');
} else {
	$dir = ARTICLE_IMG_DIR;
	$thumb_dir = ARTICLE_THUMB_DIR;
	$current_img = ARTICLE_THUMB_DIR.htmlspecialchars($post->get('picture'));
}
?>

<img id="article_img" src="<?=$current_img ?>" class="" width="100px" alt="Défaut">

<a class="col-md-2 btn btn-primary text-white" type="button" href="#" data-toggle="modal" data-target="#image_picker">Images</a>

<div class="modal fade" id="image_picker">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Images</h4>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<?php
				if (is_dir($dir)) {
					$files1 = scandir($dir, 1);
					foreach ($files1 as $fichier) {
						$info = new SplFileInfo($fichier);
						$info->getExtension();
						if ($info->getExtension() === 'jpg' || $info->getExtension() === 'png' || $info->getExtension() === 'jpeg' || $info->getExtension() === 'gif') {
				?>
							<img class="img-pick" alt="" src="<?php echo $thumb_dir . $fichier; ?>" style=" max-width : 100%; max-height:80px" data-img="<?php echo $fichier; ?>" />
				<?php
						}
					}
				}
				?>
				<img class="img-pick" alt="" src="../public/img/user_default.svg" style="height:80px" data-img="../public/img/user_default.svg" />

			</div>
		</div>
	</div>
</div>