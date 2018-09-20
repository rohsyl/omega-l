<?php
namespace Omega\Plugin\News;

use Omega\Library\Plugin\BController;
use Omega\Library\Util\ParamUtil;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Form;
use Omega\Library\Util\Message;
use Omega\Library\Util\Util;
use Omega\Plugin\News\Library\BLL\NewsCategoryManager;
use Omega\Plugin\News\Library\BLL\NewsPostCategoryManager;
use Omega\Plugin\News\Library\BLL\NewsPostManager;
use Omega\Plugin\News\Library\DTO\NewsCategory;
use Omega\Plugin\News\Library\DTO\NewsPost;

class BControllerNews extends  BController {

    public function __construct() {
        parent::__construct('news');
    }

    public function install() {
        if(!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root.'/sql/install.sql');
        }
    }

    public function index() {
        $posts = NewsPostManager::GetAllPosts();

        foreach($posts as $post){
            $post->categories = NewsCategoryManager::GetAllCategoriesOfPost($post->id);
        }

        $m['posts'] = $posts;
        return $this->view( $m );
    }

    public function add() {

        $form = new Form('btnAdd');
        if($form->isPosted())
        {

            $post = new NewsPost();
            $post->title = $form->getValue('title');
            $post->created = date('Y-m-d');
            $post->fkUser = $_SESSION['id'];

            $id = NewsPostManager::Save($post);

            Message::success('Article créé !');
            Redirect::toUrl($this->getAdminLink('edit', array('id' => $id)));
        }

        return $this->view( array() );
    }

    public function edit() {
        if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];
            $post = NewsPostManager::GetPost($id);
            $postCategories = NewsPostCategoryManager::GetAllByPost($id);
            $categories = NewsCategoryManager::GetAllCategories();

            $form = new Form('', 'btnSave');

            if($form->isPosted())
            {
                $post->title = $form->getValue('title');
                $post->hat = $form->getValue('hat');
                $post->idImage = $form->getValue('idImage');
                $post->text = $form->getValue('text');
                $post->created = date('Y-m-d H:i:s', strtotime($form->getValue('created')));

                $scategories = $form->getValue('categories');
                NewsPostCategoryManager::RemovePostFromAllCategories($id);
                foreach($scategories as $c){
                    NewsPostCategoryManager::AddPostInCategory($id, $c);
                }

                NewsPostManager::Save($post);

                Message::success('News sauvegardée !');
                Redirect::toUrl($this->getAdminLink('edit', array('id' => $id)));
            }

            $m['item'] = $post;
            $m['postCategories'] = $postCategories;
            $m['categories'] = $categories;
            return $this->view( $m );

        }
    }

    public function delete() {
        if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];

            NewsPostCategoryManager::RemovePostFromAllCategories($id);
            NewsPostManager::Delete($id);

            Redirect::toUrl($this->getAdminLink('index'));
        }
    }

    public function categories(){
        $categories = NewsCategoryManager::GetAllCategories();
        $m['categories'] = $categories;
        return $this->view( $m );
    }

    public function addcategory(){

        $form = new Form('addCategory');
        if($form->isPosted()){
            if($form->checkValue('name')){
                $category = new NewsCategory();
                $category->name = $form->getValue('name');
                $category->slug = Util::SlugifyText($category->name);
                NewsCategoryManager::Save($category);

                Redirect::toUrl($this->getAdminLink('categories'));
            }
        }
        return $this->view();
    }

    public function editcategory(){
        if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];
            $category = NewsCategoryManager::GetCategory($id);

            $form = new Form('editCategory');
            if($form->isPosted()){
                if($form->checkValue('name')){
                    $category->name = $form->getValue('name');
                    $category->slug = Util::SlugifyText($category->name);
                    NewsCategoryManager::Save($category);

                    Redirect::toUrl($this->getAdminLink('categories'));
                }
            }

            $m['category'] = $category;
            return $this->view($m);
        }
    }

    public function deletecategory() {
        if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];

            NewsPostCategoryManager::RemoveAllPostFromCategory($id);
            NewsCategoryManager::Delete($id);

            Redirect::toUrl($this->getAdminLink('categories'));
        }
    }
}