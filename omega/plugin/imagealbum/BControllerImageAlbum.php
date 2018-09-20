<?php
namespace Omega\Plugin\Imagealbum;

use Omega\Library\Plugin\BController;
use Omega\Library\Entity\Media;
use Omega\Library\Util\Config;
use Omega\Library\Util\Form;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Message;
use Omega\Library\Util\Path;
use Omega\Plugin\Imagealbum\Model\Albums;


class BControllerImageAlbum extends  BController {

    public function __construct(){
        parent::__construct('imagealbum');
        $this->includeFile( 'constant.php');
    }

    public function index() {
        $sections = Albums::getAllSections();
        $m['sections'] = $sections;
        return $this->view($m);
    }

    public function addSection(){

        $form = new Form('saveNewSection');
        if($form->isPosted()){
            if($form->checkValue(SEC_NAME_S)){
                $section = array(
                    SEC_NAME_S => $form->getValue(SEC_NAME_S)
                );
                Albums::saveSection($section);
                Message::success("Section added!");
                Redirect::toUrl($this->getAdminLink('index'));
            }
            else{
                Message::error("Please fill the \"Name\" field");
                Redirect::toUrl($this->getAdminLink('addSection'));
            }
        }
        return $this->view();
    }

    public function editSection(){
        $id = $_GET['id'];
        $section = Albums::getSection($id);
        $form = new Form('saveSection');
        if($form->isPosted()) {
            if ($form->checkValue(SEC_NAME_S)) {
                $section = array(
                    SEC_ID => $id,
                    SEC_NAME_S => $form->getValue(SEC_NAME_S),
                    SEC_NAME_F => $form->getValue(SEC_NAME_F),
                    SEC_DESCR => $form->getValue(SEC_DESCR),
                    SEC_IMG => $form->getValue(SEC_IMG)
                );
                Albums::saveSection($section);
                Message::success("Section saved!");
                Redirect::toUrl($this->getAdminLink('editSection', array('id' => $id)));
            }
            else{
                Message::error("Please fill the \"Name\" field");
                Redirect::toUrl($this->getAdminLink('addSection'));
            }
        }
        return $this->view( $section );
    }

    public function deleteSection(){
        $id = $_GET['id'];
        Albums::deleteSection($id);
        Message::success("Section deleted!");
        Redirect::toUrl($this->getAdminLink('index'));
    }

    public function albums(){
        $id = $_GET['id'];
        $section = Albums::getSection($id);
        $albums = Albums::getAllAlbums($id);
        $section['albums'] = $albums;
        return $this->view($section);
    }

    public function addAlbum(){
        $id = $_GET['id'];
        $section = Albums::getSection($id);
        $form = new Form('saveNewAlbum');
        if($form->isPosted()){
            if($form->checkValue(ALB_NAME) && $form->checkValue(ALB_YEAR)){
                $album = array(
                    ALB_NAME => $form->getValue(ALB_NAME),
                    ALB_YEAR => date('Y-m-d', strtotime($form->getValue(ALB_YEAR))),
                    ALB_SEC => $id
                );
                Albums::saveAlbum($album);
                Message::success("Album added!");
                Redirect::toUrl($this->getAdminLink('albums', array('id' => $id)));
            }
            else{
                Message::error("Please fill the \"Name\" field and the \"Date\" field");
                Redirect::toUrl($this->getAdminLink('addAlbum',array('id' => $id)));
            }
        }
        return $this->view($section);
    }

    public function editAlbum(){
        $id = $_GET['id'];
        $secId = $_GET['secid'];
        $section = Albums::getSection($secId);
        $album = Albums::getAlbum($id);
        $form = new Form('saveAlbum');
        if($form->isPosted()){
            if($form->checkValue(ALB_NAME) && $form->checkValue(ALB_YEAR)){
                $album = array(
                    ALB_ID => $id,
                    ALB_NAME => $form->getValue(ALB_NAME),
                    ALB_YEAR => date('Y-m-d', strtotime($form->getValue(ALB_YEAR))),
                    ALB_SEC => $secId
                );
                Albums::saveAlbum($album);
                Message::success("Album saved!");
            }
            else{
                Message::error("Please fill the \"Name\" field and the \"Date\" field");
            }
            Redirect::toUrl($this->getAdminLink('editAlbum', array('id' => $id, 'secid' => $secId)));
        }
        $m['section'] = $section;
        $m['album'] = $album;
        return $this->view($m);
    }

    public function deleteAlbum(){
        $id = $_GET['id'];
        $secId = $_GET['secid'];
        Albums::deleteAlbum($id);
        Message::success("Section deleted!");
        Redirect::toUrl($this->getAdminLink('albums', array('id' => $secId)));
    }

    public function images(){
        $id = $_GET['id'];
        $album = Albums::getAlbum($id);
        $secId = $album[ALB_SEC];
        $section = Albums::getSection($secId);
        $images = Albums::getAllImage($id);
        $m['section'] = $section;
        $m['album'] = $album;
        $m['images'] = $images;
        return $this->view($m);
    }

    public function addImages(){
        $idAlbum = $_POST['album'];
        $idImage = $_POST['image'];
        $order = $_POST['order'];
        $image = array(
            IMG_MEDIA => $idImage,
            IMG_ALBUM => $idAlbum,
            IMG_ORDER => $order
        );
        $success = Albums::saveImage($image);
        return json_encode(array(
            'success' => $success
        ));
    }

    public function deleteImage(){
        $id = $_POST['id'];
        $success = Albums::deleteImage($id);
        return json_encode(array(
            'success' => $success
        ));
    }

    public function saveImagesOrder(){
        $values = $_POST['orders'];
        $success = true;
        foreach($values as $value){
            $image = array(
                IMG_ID => $value['id'],
                IMG_ORDER => $value['order']
            );
            $success = Albums::saveImage($image);
        }
        return json_encode(array(
            'success' => $success
        ));
    }

    public function settings(){



        $form = new Form('btnSaveSettingsImageAlbum');
        if($form->isPosted()){
            $config = array(
                CFG_BIMG_W => $form->getValue(CFG_BIMG_W),
                CFG_BIMG_H => $form->getValue(CFG_BIMG_H),
                CFG_COPY_EN => $form->checkValue(CFG_COPY_EN),
                CFG_COPY_IMG => $form->getValue(CFG_COPY_IMG),
                CFG_THUMB_W => $form->getValue(CFG_THUMB_W),
                CFG_THUMB_H => $form->getValue(CFG_THUMB_H)
            );
            Config::set('imagealbum_config', json_encode($config));

            Message::success('Config saved !');
            Redirect::toUrl($this->getAdminLink('settings'));
        }
        $defaultConfig = $this->getDefaultsConfig();
        $config = Config::get('imagealbum_config');

        if(empty($config)) $config = array();
        else $config = json_decode($config, true);
        $m['config'] = array_merge($defaultConfig, $config);

        return $this->view( $m );
    }

    public function previewCopyright(){
        $idMedia = 17;
        $media = new Media($idMedia);
        $config = Albums::getConfig();
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
        $idCopy = $config[CFG_COPY_IMG];
        $mediaCopy = new Media($idCopy);

        // Load the stamp and the photo to apply the watermark to
        $im = imagecreatefromjpeg($media->GetThumbnail($config[CFG_BIMG_W], $config[CFG_BIMG_H], false));
        $copyim = imagecreatefrompng($mediaCopy->getRealpath());

        $stamp = imagecreatetruecolor(50, 20);
        $transparent = imagecolorallocatealpha($stamp, 255,255,255, 127);
        $white = imagecolorallocate($stamp, 255, 255, 255);
        imagealphablending($stamp, false);
        imagesavealpha($stamp, true);
        imagefilledrectangle($stamp, 0, 0, 50, 20, $transparent);
        imagettftext($stamp, 10, 0, 0, 10, $white, Path::Combine(PLUGINPATH, 'imagealbum', 'fonts', 'arialbold.ttf'), '2017');

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
        imagepng($im, ROOT.DS.'test.png');
        imagedestroy($im);

        return '<img src="/test.png" />';
    }

    public function install(){
        if(!$this->isInstalled())
        {
            $this->setDefaultsConfig();
            parent::install();
            parent::runSql($this->root.'/sql/install.sql');
        }
    }

    private function setDefaultsConfig(){

        $config = Config::get('imagealbum_config_defaults');
        if(empty($config)){
            $defaultConfig = array(
                CFG_BIMG_W => 1280,
                CFG_BIMG_H => 720,
                CFG_COPY_EN => true,
                CFG_COPY_IMG => null,
                CFG_COPY_W => 300,
                CFG_COPY_H => 80,
                CFG_COPY_X => 900,
                CFG_COPY_Y => 620,
                CFG_THUMB_W => 300,
                CFG_THUMB_H => 250
            );
            Config::set('imagealbum_config_defaults', json_encode($defaultConfig));

        }
    }

    private function getDefaultsConfig(){

        $config = Config::get('imagealbum_config_defaults');
        return json_decode($config, true);
    }

    public function uninstall()
    {
        parent::uninstall();
        parent::runSql($this->root.'/sql/uninstall.sql');
    }

    public function formComponent($args){
        return $this->partialView('formComponent', $args);
    }

    public function updateComponent($args){

    }

}