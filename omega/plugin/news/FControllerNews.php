<?php
namespace OmegaPlugin\News;

use Omega\Utils\Plugin\FController;
use OmegaPlugin\News\Models\Post;
use OmegaPlugin\news\Repository\PostRepository;

class FControllerNews extends  FController {

    private $postRepository;

    public function __construct() {
        parent::__construct('news');

        $this->postRepository = new PostRepository(new Post());
    }

    public function registerDependencies() {
        return [
            'css' => [
                $this->asset('css/styles.css')
            ],
            'js' => [
            ]
        ];
    }

    public function display($param, $data) {

        $count = isset($data['count']) && !empty($data['count']) ? $data['count'] : null;
        $categories = $data['categories'];
        $categories = array_keys($categories);

        $view = isset($param['view']) ? $param['view'] : 'list';
        $placement = isset($param['placement']) ? $param['placement'] : 'content';


        /*
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
        }*/


        $posts = $this->postRepository->allWithCategoriesAndPublishedAndNotArchived($categories, $count);



        $m['posts'] = $posts;
        $m['placement'] = $placement;

        return $this->view('display_list')->with($m);

        /*
        switch($view) {
            case 'list' :
                break;
            case 'grid' :
                return $this->view('display-grid', $m);
                break;
        }
        return null;*/
    }
}