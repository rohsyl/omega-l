<?php
namespace Omega\Plugin\Imagealbum\Model;

use Omega\Library\Entity\Media;
use Omega\Library\Util\Path;
use Omega\Library\Util\Url;

class MediaImageAlbum extends Media{

    private $album;

    function __construct($id = null, $album)
    {
        parent::__construct($id);
        $this->album = $album;
    }

    function getImageWithCopyRight($config){
        /*$form = new Form();
        $config = array(
            CFG_BIMG_W => $form->getValue(CFG_BIMG_W),
            CFG_BIMG_H => $form->getValue(CFG_BIMG_H),
            CFG_COPY_EN => $form->checkValue(CFG_COPY_EN),
            CFG_COPY_IMG => $form->getValue(CFG_COPY_IMG),
            CFG_COPY_W => $form->getValue(CFG_COPY_W),
            CFG_COPY_H => $form->getValue(CFG_COPY_H),
            CFG_COPY_X => $form->getValue(CFG_COPY_X),
            CFG_COPY_Y => $form->getValue(CFG_COPY_Y),
        );*/
        $year = date('Y', strtotime($this->album[ALB_YEAR]));
        $filenameOutput = $this->name . '-copyright-' . $year . '.' . $this->ext;
        $pathOutput = Path::Combine(ROOT, 'media', $this->id, $filenameOutput);
        $urlOutput = Url::CombAndAbs(ABSPATH, 'media', $this->id, $filenameOutput);

        if(!file_exists($pathOutput)) {
            $idCopy = $config[CFG_COPY_IMG];
            $mediaCopy = new Media($idCopy);

            // Load the stamp and the photo to apply the watermark to
            $im = imagecreatefromjpeg($this->GetThumbnail($config[CFG_BIMG_W], $config[CFG_BIMG_H], false));
            $copyim = imagecreatefrompng($mediaCopy->getRealpath());

            $stamp = imagecreatetruecolor(50, 20);
            $transparent = imagecolorallocatealpha($stamp, 255, 255, 255, 127);
            $white = imagecolorallocate($stamp, 255, 255, 255);
            imagealphablending($stamp, false);
            imagesavealpha($stamp, true);
            imagefilledrectangle($stamp, 0, 0, 50, 20, $transparent);
            imagettftext($stamp, 10, 0, 0, 10, $white, Path::Combine(PLUGINPATH, 'imagealbum', 'fonts', 'arialbold.ttf'), $year);

            $margin_left = 60;
            $marge_bottom = 10;
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);

            imagecopy($im, $stamp, $margin_left, imagesy($im) - $sy - $marge_bottom, 0, 0, $sx, $sy);

            $margin_left = 10;
            $marge_bottom = 10;
            $sx = imagesx($copyim);
            $sy = imagesy($copyim);

            imagealphablending($im, true);
            imagesavealpha($im, true);
            imagealphablending($copyim, true);
            imagesavealpha($copyim, true);

            //imagecopymerge($im, $copyim, $margin_left, imagesy($im) - $sy - $marge_bottom, 0, 0, $sx, $sy, 100);

            imagecopy($im, $copyim, $margin_left, imagesy($im) - $sy - $marge_bottom, 0, 0, $sx, $sy);
            // Save the image to file and free memory
            imagepng($im, $pathOutput);
            imagedestroy($im);
        }
        return $urlOutput;
    }
}