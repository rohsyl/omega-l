<?php
namespace OmegaPlugin\Video;


use Omega\Utils\Plugin\FController;

class FControllerVideo extends  FController {


    public function __construct() {
        parent::__construct('video');
    }

    public function registerDependencies()
    {
        return [
            'css' => [
                $this->asset('css/styles.css')
            ],
            'js' => [
            ]
        ];
    }

    public function display( $args, $data) {
        $m['src'] = isset($data['video']->path) ? $this->getFrameSrc($data['video']->path) : '';
        return $this->view('display')->with($m);
    }

    private function getFrameSrc($url)
    {
        if(empty($url)) return '';

        $parse = parse_url($url);
        $host = $parse['host'];
        $frameSrc = '';
        if(strpos($host, 'vimeo') !== false)
        {
            preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $matches);
            $frameSrc = 'http://player.vimeo.com/video/'.$matches[5];
        }
        else if (strpos($host, 'youtu') !== false)
        {
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
            $frameSrc = 'https://www.youtube.com/embed/'.$matches[1];
        }
        return $frameSrc;
    }
}