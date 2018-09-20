<?php
namespace Omega\Plugin\News;

use Omega\Library\BLL\UserManager;
use Omega\Library\Plugin\FController;
use Omega\Library\Util\Config;
use Omega\Library\Util\Util;
use Omega\Plugin\News\Library\BLL\NewsPostManager;

class FControllerNews extends  FController {

    public function __construct() {
        parent::__construct('news');
    }

    public function registerDependencies() {
        return array(
            'css' => array(
                'plugin/news/css/style.css'
            ),
            'js' => array(
            )
        );
    }

    public function display($param, $data) {

        $count = isset($data['count']) && !empty($data['count']) ? $data['count'] : null;
        $categories = $data['categories'];
        $categories = array_keys($categories);

        $view = isset($param['view']) ? $param['view'] : 'list';
        $placement = isset($param['placement']) ? $param['placement'] : 'content';


        if(isset($_GET['post']) && !empty($_GET['post'])) {
            $idPost = $_GET['post'];
            $post = NewsPostManager::GetPost($idPost);
            $post->user = UserManager::GetUser($post->fkUser);
            $newer = NewsPostManager::GetNewerPost($idPost, $categories);
            $older = NewsPostManager::GetOlderPost($idPost, $categories);

            $m['post'] = $post;
            $m['newer'] = $newer;
            $m['older'] = $older;
            $m['placement'] = $placement;
            return $this->partialView('display-item', $m);
        }


        $posts = NewsPostManager::GetAllPostsWithCategories($categories, $count);

        foreach($posts as $post){
            $post->user = UserManager::GetUser($post->fkUser);
        }

        $m['posts'] = $posts;
        $m['placement'] = $placement;
        switch($view) {
            case 'list' :
                return $this->partialView('display-list', $m);
                break;
            case 'grid' :
                return $this->partialView('display-grid', $m);
                break;
        }
        return null;
    }
}