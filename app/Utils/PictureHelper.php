<?php
namespace Omega\Utils;

class PictureHelper
{
    public static function CreateThumbnail($in_filename, $out_filename, $width, $height)
    {
        if(!file_exists($out_filename)) {
            $nw = $width;
            $nh = $height;

            $src_img = self::ImageCreateFromAny($in_filename);

            $w = imagesx($src_img);
            $h = imagesy($src_img);
            $dst_img = imagecreatetruecolor($width, $height);

            $wm = $w / $nw;
            $hm = $h / $nh;
            $h_height = $nh / 2;
            $w_height = $nw / 2;

            if ($w > $h) {
                $adjusted_width = $w / $hm;
                $half_width = $adjusted_width / 2;
                $int_width = $half_width - $w_height;
                imagecopyresampled($dst_img, $src_img, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
            } elseif (($w < $h) || ($w == $h)) {
                $adjusted_height = $h / $wm;
                $half_height = $adjusted_height / 2;
                $int_height = $half_height - $h_height;

                imagecopyresampled($dst_img, $src_img, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
            } else {
                imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $nw, $nh, $w, $h);
            }
            imagejpeg($dst_img, $out_filename, 100);
        }
        return $out_filename;
    }

    public static function Crop($in_filename, $out_filename, $max_width, $max_height, $quality = 80){

        //Fatal error: Allowed memory size of 134217728 bytes exhausted (tried to allocate 24984 bytes)

        $imgsize = getimagesize($in_filename);
        $width = $imgsize[0];
        $height = $imgsize[1];

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = self::ImageCreateFromAny($in_filename);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        imagejpeg($dst_img, $out_filename, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);
    }

    public static function GetImageWidth($filepath){
        $imgsize = getimagesize($filepath);
        return $imgsize[0];
    }

    public static function GetImageHeight($filepath){
        $imgsize = getimagesize($filepath);
        return $imgsize[1];
    }
	
	public static function Get($filepath, $width = null, $height = null)
	{

		$newfilename = self::GetImageName($filepath, $width, $height);
		$newfilepath = Path::Combine( ROOT, 'cache', 'app', 'PictureHelper', $newfilename);
		$newfileUrl = Url::Absolute(Url::Combine( ABSPATH, 'cache', 'app', 'PictureHelper', $newfilename));

		
		if(!file_exists($newfilepath))
			self::Crop($filepath, $newfilepath, $width, $height, 100);
			
		return $newfileUrl;
	}
	
	public static function GetImageName($filepath, $width, $height)
	{
		$extension = pathinfo($filepath, PATHINFO_EXTENSION);
		$filename = pathinfo($filepath, PATHINFO_FILENAME);
		
		return $filename . '-' . $width . 'x' . $height . '.' . $extension;
	}
	
    private static function ImageCreateFromAny($filepath) {
        $type = exif_imagetype($filepath);
        $allowedTypes = array(
            1,  //gif
            2,  //jpg
            3,  //png
            6   //bmp
        );
        if (!in_array($type, $allowedTypes)) {
            return false;
        }
        switch ($type) {
            case 1 :
                $im = imagecreatefromgif($filepath);
                break;
            case 2 :
                $im = imagecreatefromjpeg($filepath);
                break;
            case 3 :
                $im = imagecreatefrompng($filepath);
                break;
            case 6 :
                $im = imagecreatefrombmp($filepath);
                break;
        }
        return $im;
    }
}