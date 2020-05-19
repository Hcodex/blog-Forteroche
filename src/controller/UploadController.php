<?php

namespace App\src\controller;

use App\config\Parameter;

class UploadController extends Controller
{

	public function fileValidation($file, $extension)
	{
		$size = filesize($file['tmp_name']);
		$img_info = getimagesize($file['tmp_name']);
		$mime   = $img_info['mime'];
		if (!in_array($extension, IMG_ALLOWED_EXTENSIONS)) {
			return 'Vous devez uploader un fichier de type png, gif, jpg ou jpeg';
		}
		if ($size > UPLOAD_MAX_SIZE) {
			return 'Le fichier est trop gros (Max 5Mo)';
		}
		if (!$mime) {
			return 'Le fichier est corrompu';
		}
	}

	public function uploadLimit($dir, $limit)
	{
		$files = scandir($dir, 1);
		$count = 0;
		foreach ($files as $fichier) {
			$extension = strrchr($fichier, '.');
			if ($extension === '.jpg' || $extension === '.png' || $extension === '.jpeg' || $extension === '.gif') {
				$count++;
			}
		}
		if ($count >= $limit) {
			return 'Vous ne pourvez pas avoir plus de ' . $limit . ' images enregistrées';
		}
	}

	public function setDir($img_dir, $thumb_dir)
	{
		if (!is_dir($img_dir)) {
			mkdir($img_dir, 0777, true);
		};
		if (!is_dir($thumb_dir)) {
			mkdir($thumb_dir, 0777, true);
		};
	}

	public function imagethumb($img_src, $img_dest = NULL, $max_size = 100, $expand = FALSE, $square = FALSE)
	{
		if (!file_exists($img_src)) return FALSE;

		$fileinfo = getimagesize($img_src);
		if (!$fileinfo) return FALSE;

		$width     = $fileinfo[0];
		$height    = $fileinfo[1];
		$type_mime = $fileinfo['mime'];
		$type      = str_replace('image/', '', $type_mime);

		if (!$expand && max($width, $height) <= $max_size && (!$square || ($square && $width == $height))) {
			if ($img_dest) {
				return copy($img_src, $img_dest);
			} else {
				header('Content-Type: ' . $type_mime);
				return (bool) readfile($img_src);
			}
		}

		$ratio = $width / $height;

		if ($square) {
			$new_width = $new_height = $max_size;

			if ($ratio > 1) {
				// Paysage
				$src_y = 0;
				$src_x = round(($width - $height) / 2);

				$src_w = $src_h = $height;
			} else {
				// Portrait
				$src_x = 0;
				$src_y = round(($height - $width) / 2);

				$src_w = $src_h = $width;
			}
		} else {
			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;

			if ($ratio > 1) {
				// Paysage
				$new_width  = $max_size;
				$new_height = round($max_size / $ratio);
			} else {
				// Portrait
				$new_height = $max_size;
				$new_width  = round($max_size * $ratio);
			}
		}

		$func = 'imagecreatefrom' . $type;
		if (!function_exists($func)) return FALSE;

		$img_src = $func($img_src);
		$new_image = imagecreatetruecolor($new_width, $new_height);

		if ($type == 'png') {
			imagealphablending($new_image, false);
			if (function_exists('imagesavealpha'))
				imagesavealpha($new_image, true);
		} elseif ($type == 'gif' && imagecolortransparent($img_src) >= 0) {
			$transparent_index = imagecolortransparent($img_src);
			$transparent_color = imagecolorsforindex($img_src, $transparent_index);
			$transparent_index = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
			imagefill($new_image, 0, 0, $transparent_index);
			imagecolortransparent($new_image, $transparent_index);
		}

		// Redimensionnement de l'image
		imagecopyresampled(
			$new_image,
			$img_src,
			0,
			0,
			$src_x,
			$src_y,
			$new_width,
			$new_height,
			$src_w,
			$src_h
		);

		// Enregistrement de l'image
		$func = 'image' . $type;
		if ($img_dest) {
			$func($new_image, $img_dest);
		} else {
			header('Content-Type: ' . $type_mime);
			$func($new_image);
		}

		// Libération de la mémoire
		imagedestroy($new_image);

		return TRUE;
	}

	public function _ajaxUpload(Parameter $post)
	{
		$upload_mode = $post->get('mode');

		switch ($upload_mode) {
			case "article":
				$img_dir = ARTICLE_IMG_DIR;
				$thumb_dir = ARTICLE_THUMB_DIR;
				$this->setDir($img_dir, $thumb_dir);
				break;
			case "avatar":
				$img_dir = AVATAR_IMG_DIR . $this->session->get('id') . '/';
				$thumb_dir = AVATAR_IMG_DIR . $this->session->get('id') . '/thumb/';
				$this->setDir($img_dir, $thumb_dir);
				$errors = $this->uploadLimit($img_dir, AVATAR_LIMIT);
				break;
			default:
				$errors = "Erreur interne";
		}

		if (!$errors) {
			$file = $_FILES['fileToUpload'];
			$extension = strrchr($file['name'], '.');
			$errors = $this->fileValidation($file, $extension);
			$newName = md5(session_id() . microtime());
			$img_src =  $img_dir . $newName . $extension;
			$img_dest = $thumb_dir . $newName . $extension;
			if (!$errors) {
				if (move_uploaded_file($file['tmp_name'], $img_dir . $newName . $extension)) {
					if ($this->imagethumb($img_src, $img_dest, 400)) {
						$success = true;
					} else {
						$errors = 'Erreur lors de la compression';
					}
				} else {
					$errors = 'Erreur lors l\'envoi du fichier';
				}
			}
		}
		echo json_encode(array(
			'success' =>  $success,
			'errorMessage' => '<Strong>Echec de l\'upload </strong>' . $errors,
			'imageSrc' => $img_src,
			'imageName' => $newName . $extension,
			'imageThumbail' => $img_dest
		));
	}

	public function _ajaxfilesDelete(Parameter $post)
	{
		foreach ($post->get('file_selector') as $file) {
			if (!file_exists($file)) {
				$errors .= "Impossible de supprimer le fichier " . $file . "<br>";
			} else {
				!unlink($file);
			}
		}
		if (!$errors) {
			$success = true;
		} else {
			$success = false;
		}

		echo json_encode(array(
			'success' =>  $success,
			'errorMessage' => $errors
		));
	}
}
