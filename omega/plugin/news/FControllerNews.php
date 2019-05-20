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
        $page = isset($data['page']) && !empty($data['page']) ? $data['page'] : null;
        $categories = isset($data['categories']) ? $data['categories'] : [];
        $categories = array_keys($categories);

        $placement = isset($param['placement']) ? $param['placement'] : 'content';

        $request = request();

        if($request->has('post') && !empty($request->get('post'))) {
            $id = $request->get('post');
            $post = $this->postRepository->get($id);

            $next = $this->postRepository->getNext($post, $categories);
            $previous = $this->postRepository->getPrevious($post, $categories);

            return $this->view('display_item')->with([
                'post' => $post,
                'next' => $next,
                'previous' => $previous,
                'placement' => $placement,
            ]);
        }

        $posts = $this->postRepository->allWithCategoriesAndPublishedAndNotArchived($categories, $count);

        $m['posts'] = $posts;
        $m['placement'] = $placement;
        $m['page'] = $page;

        return $this->view('display_list')->with($m);
    }
}