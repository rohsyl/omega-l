<?php
namespace OmegaPlugin\News;

use Omega\Facades\Entity;
use Omega\Utils\Plugin\FController;
use OmegaPlugin\News\Models\Post;
use OmegaPlugin\news\Repository\PostRepository;

class FControllerNews extends  FController {

    private $postRepository;

    public const DISPLAY_LIST = 1;
    public const DISPLAY_GRID = 2;
    public const DISPLAY_DETAIL = 10;

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
        $display = isset($data['display']) && !empty($data['display']) ? $data['display'] : self::DISPLAY_LIST;
        $count = isset($data['count']) && !empty($data['count']) ? $data['count'] : null;
        $page = isset($data['page']) && !empty($data['page']) ? $data['page'] : null;
        $categories = isset($data['categories']) ? array_keys($data['categories']) : [];
        $placement = isset($param['placement']) ? $param['placement'] : 'content';

        $request = request();

        switch($display['value']) {
            case self::DISPLAY_LIST:
                $posts = $this->postRepository->allWithCategoriesAndPublishedAndNotArchived($categories, $count);

                return $this->view('display_list')->with([
                    'posts' => $posts,
                    'placement' => $placement,
                    'page' => $page
                ]);
                break;

            case self::DISPLAY_GRID:
                $posts = $this->postRepository->allWithCategoriesAndPublishedAndNotArchived($categories, $count);

                return $this->view('display_grid')->with([
                    'posts' => $posts,
                    'placement' => $placement,
                    'page' => $page
                ]);
                break;
                break;

            case self::DISPLAY_DETAIL:
                $post = null;
                $next = null;
                $previous = null;
                if($request->has('post') && !empty($request->get('post'))) {
                    $slug = $request->get('post');
                    $post = $this->postRepository->getBySlug($slug);

                    $next = $this->postRepository->getNext($post, $categories);
                    $previous = $this->postRepository->getPrevious($post, $categories);


                    Entity::Page()->set('name', __('News') . ' - ' . $post->title);
                }
                return $this->view('display_item')->with([
                    'post' => $post,
                    'next' => $next,
                    'previous' => $previous,
                    'placement' => $placement,
                ]);
                break;
        }
    }
}