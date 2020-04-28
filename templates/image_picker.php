<?php
$dir    = '../public/img/uploads/';
$files1 = scandir($dir, 1);
?>
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
				foreach ($files1 as $fichier) {
					$info = new SplFileInfo($fichier);
					$info->getExtension();
					if ($info->getExtension() === 'jpg' || $info->getExtension() === 'png' || $info->getExtension() === 'jpeg' || $info->getExtension() === 'gif') {
				?>
						<img class="img-pick" alt="" src="<?php echo $dir . 'thumb/' . $fichier; ?>" style=" max-width : 100%; max-height:80px" data-img="<?php echo $dir . $fichier; ?>" />
				<?php
					}
				}
				?>
			</div>
		</div>
	</div> 
</div>
