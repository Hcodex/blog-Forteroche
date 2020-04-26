<?php

namespace App\src\controller;

use App\config\Parameter;

class UploadController extends Controller
{
     public function upload(){
        $dossier = '../public/img/uploads/';
        if(!is_dir($dossier)){
           mkdir($dossier);
        }
        $fichier = basename($_FILES['fileToUpload']['name']);
        $taille_maxi = 10000000;
        $taille = filesize($_FILES['fileToUpload']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['fileToUpload']['name'], '.'); 
        
        $image_src = $dossier . $fichier ;
        $image_dest = $dossier . "thumb/" . $fichier ;
        if(!is_dir($dossier . "thumb/")){
            mkdir($dossier . "thumb/");
        };
        
        //Début des vérifications de sécurité...
        if(!in_array($extension, $extensions))
        {
            $erreur = 'Erreur format';
            $this->session->set('error_message', '<Strong>Echec de l\'upload !</strong>Vous devez uploader un fichier de type png, gif, jpg ou jpeg') ;
        }
        if($taille>$taille_maxi)
        {
            $erreur = 'Erreur poids';
            $this->session->set('error_message', '<Strong>Echec de l\'upload</strong> Le fichier est trop gros');
        }
        if(!isset($erreur))
        {
             $fichier = strtr($fichier, 
                  'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                  'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
             $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
             if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $dossier . $fichier))
             {
                $image_src	=  $dossier . $fichier ;
                $image_dest = $dossier . "thumb/" . $fichier ;
                if($this->imagethumb($image_src, $image_dest, 400)){
                    $this->session->set('success_message', '<Strong>Upload réussi ! </strong>');
                }			
                else {
                    $this->session->set('error_message', '<Strong>erreur lors de la la compression</strong> ');
                }
             }
             else
             {
                $this->session->set('error_message', '<Strong>Echec de l\'upload</strong>');
            }
        }
        header('Location: ../public/index.php?route=administration');
    }


    public function imagethumb( $image_src , $image_dest = NULL , $max_size = 100, $expand = FALSE, $square = FALSE )
    {
	if( !file_exists($image_src) ) return FALSE;

	$fileinfo = getimagesize($image_src);
	if( !$fileinfo ) return FALSE;

	$width     = $fileinfo[0];
	$height    = $fileinfo[1];
	$type_mime = $fileinfo['mime'];
	$type      = str_replace('image/', '', $type_mime);

	if( !$expand && max($width, $height)<=$max_size && (!$square || ($square && $width==$height) ) )
	{
		if($image_dest)
		{
			return copy($image_src, $image_dest);
		}
		else
		{
			header('Content-Type: '. $type_mime);
			return (boolean) readfile($image_src);
		}
	}

	$ratio = $width / $height;

	if( $square )
	{
		$new_width = $new_height = $max_size;

		if( $ratio > 1 )
		{
			// Paysage
			$src_y = 0;
			$src_x = round( ($width - $height) / 2 );

			$src_w = $src_h = $height;
		}
		else
		{
			// Portrait
			$src_x = 0;
			$src_y = round( ($height - $width) / 2 );

			$src_w = $src_h = $width;
		}
	}
	else
	{
		$src_x = $src_y = 0;
		$src_w = $width;
		$src_h = $height;

		if ( $ratio > 1 )
		{
			// Paysage
			$new_width  = $max_size;
			$new_height = round( $max_size / $ratio );
		}
		else
		{
			// Portrait
			$new_height = $max_size;
			$new_width  = round( $max_size * $ratio );
		}
	}


	$func = 'imagecreatefrom' . $type;
	if( !function_exists($func) ) return FALSE;

	$image_src = $func($image_src);
	$new_image = imagecreatetruecolor($new_width,$new_height);

	if( $type=='png' )
	{
		imagealphablending($new_image,false);
		if( function_exists('imagesavealpha') )
			imagesavealpha($new_image,true);
	}

	elseif( $type=='gif' && imagecolortransparent($image_src)>=0 )
	{
		$transparent_index = imagecolortransparent($image_src);
		$transparent_color = imagecolorsforindex($image_src, $transparent_index);
		$transparent_index = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
		imagefill($new_image, 0, 0, $transparent_index);
		imagecolortransparent($new_image, $transparent_index);
	}

	// Redimensionnement de l'image
	imagecopyresampled(
		$new_image, $image_src,
		0, 0, $src_x, $src_y,
		$new_width, $new_height, $src_w, $src_h
	);

	// Enregistrement de l'image
	$func = 'image'. $type;
	if($image_dest)
	{
		$func($new_image, $image_dest);
	}
	else
	{
		header('Content-Type: '. $type_mime);
		$func($new_image);
	}
	
	// Libération de la mémoire
	imagedestroy($new_image); 

	return TRUE;
    }
}