<?php
namespace OmegaPlugin\News;

use Illuminate\Support\Facades\Validator;
use Omega\Utils\Plugin\BController;
use OmegaPlugin\News\Models\Category;
use OmegaPlugin\News\Models\Post;
use OmegaPlugin\news\Repository\CategoryRepository;
use OmegaPlugin\news\Repository\PostRepository;
use OmegaPlugin\News\Request\CreatePostRequest;

class BControllerNews extends  BController {

    private $categoryRepository;
    private $postRepository;

    private $createRules = [
        'title' => 'required|string'
    ];

    private $updateRules = [
        'title' => 'required|string',
        'brief' => 'nullable|string',
        'text' => 'nullable|string',
        'published_at' => 'nullable|date',
        'image' => 'nullable|integer',
        'categories.*' => 'required|integer',
    ];


    private $createCategoryRules = [
        'name' => 'required|string'
    ];

    public function __construct() {
        parent::__construct('news');
        $this->categoryRepository = new CategoryRepository(new Category());
        $this->postRepository = new PostRepository(new Post());
    }

    public function install() {
        parent::runSql($this->root.'/sql/install.sql');
        return true;
    }

    public function uninstall() {
        parent::runSql($this->root.'/sql/uninstall.sql');
        return true;
    }

    public function index() {
        return $this->view('index')->with([
            'menu' => $this->view('menu')->render(),
            'posts' => $this->postRepository->all()
        ]);
    }

    public function add() {
        return $this->view('add')->with([
            'menu' => $this->view('menu')->render(),
        ]);
    }

    public function create(){

        $request = request();
        $validator = Validator::make($request->all(), $this->createRules);

        if ($validator->fails()) {
            return $this->redirect('add')
                ->withErrors($validator)
                ->withInput();
        }

        $id = $this->postRepository->create($request->all());

        toast()->success(__('Post created'));
        return $this->redirect('edit', ['id' => $id]);
    }

    public function edit() {
        $request = request();
        $id = $request->input('id');

        $post = $this->postRepository->get($id);
        $categories = $this->categoryRepository->all();

        return $this->view('edit')->with([
            'menu' => $this->view('menu')->render(),
            'item' => $post,
            'categories' => $categories,
        ]);

    }

    public function save(){
        $request = request();
        $id = $request->get('id');
        $validator = Validator::make($request->all(), $this->updateRules);

        if ($validator->fails()) {
            return $this->redirect('edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $post = $this->postRepository->get($id);
        $this->postRepository->save($post, $request->all());

        toast()->success(__('Post updated'));
        return $this->redirect('edit', ['id' => $id]);
    }

    public function delete() {
        $request = request();
        $id = $request->get('id');

        $this->postRepository->delete($id);

        toast()->success(__('Post deleted'));
        return $this->redirect('edit', ['id' => $id]);
    }

    public function categories(){
        return $this->view('categories')->with([
            'menu' => $this->view('menu')->render(),
            'categories' => $this->categoryRepository->all()
        ]);
    }

    public function addcategory(){

        return $this->view('addcategory')->with([
            'menu' => $this->view('menu')->render(),
        ]);
    }

    public function createcategory(){

        $request = request();
        $validator = Validator::make($request->all(), $this->createCategoryRules);

        if ($validator->fails()) {
            return $this->redirect('addcategory')
                ->withErrors($validator)
                ->withInput();
        }

        $this->categoryRepository->create($request->all());

        toast()->success(__('Category created'));
        return $this->redirect('categories');
    }

    public function editcategory(){
        $request = request();
        $id = $request->get('id');

        $category = $this->categoryRepository->get($id);

        return $this->view('editcategory')->with([
            'menu' => $this->view('menu')->render(),
            'category' => $category
        ]);
    }

    public function savecategory(){
        $request = request();
        $id = $request->get('id');

        $validator = Validator::make($request->all(), $this->createCategoryRules);

        if ($validator->fails()) {
            return $this->redirect('editcateogry', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $category = $this->categoryRepository->get($id);
        $this->categoryRepository->save($category, $request->all());


        toast()->success(__('Category updated'));
        return $this->redirect('categories');
    }

    public function deletecategory() {
        $request = request();
        $id = $request->get('id');

        $this->categoryRepository->delete($id);

        toast()->success(__('Category deleted'));
        return $this->redirect('categories');
    }
}