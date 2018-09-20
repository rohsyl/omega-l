<?php
namespace Omega\Plugin\Fichedepresentation;

use Omega\Library\Plugin\BController;
use Omega\Library\Util\Form;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Message;
use Omega\Plugin\Fichedepresentation\Model\Articles;
use Omega\Plugin\Fichedepresentation\Model\LocalArticle;
use Omega\Plugin\Fichedepresentation\Model\LocalArticles;


class BControllerFichedepresentation extends  BController {

    public function __construct(){
        parent::__construct('fichedepresentation');
        $this->includeFile( 'constant.php');
    }

    public function index() {
        $localArticles = LocalArticles::getAll();
        $m['localArticles'] = $localArticles;
        return $this->view($m);
    }

    public function getArticlesFromDatabase(){
        $articles = Articles::getAll();
        $localArticles = LocalArticles::getAll();
        $m['articles'] = $articles;
        $m['localArticles'] = $localArticles;
        return $this->view($m);
    }

    public function saveArticleInLocal(){
        $ref = $_GET['ref'];
        $article = Articles::getOne($ref);
        $local = new LocalArticle();
        $local->ref = $article->getRef();
        $local->name = $article->getDesignation();
        LocalArticles::save($local);
        Message::success("Article saved locally");
        Redirect::toUrl($this->getAdminLink('getArticlesFromDatabase'));
    }

    public function editLocale(){
        $id = $_GET['id'];
        $article = LocalArticles::getOne($id);
        $form = new Form('saveLocaleArticle');
        if($form->isPosted()){
            $article->name = $form->getValue('name');
            if($form->checkValue('image'))
                $article->fkMediaImage = $form->getValue('image');
            if($form->checkValue('panel'))
                $article->fkMediaPanel = $form->getValue('panel');
            if($form->checkValue('pres'))
                $article->fkMediaPres = $form->getValue('pres');
            LocalArticles::save($article);
            Message::success('Locale article saved !');
            Redirect::toUrl($this->getAdminLink('index'));
        }
        $m['article'] = $article;
        return $this->view($m);
    }

    public function deleteLocale(){
        $id = $_GET['id'];
        LocalArticles::delete($id);
        Message::success('Locale article deleted !');
        Redirect::toUrl($this->getAdminLink('index'));
    }

    public function install(){
        if(!$this->isInstalled())
        {
            parent::install();
            parent::runSql($this->root.'/sql/install.sql');
        }
    }


    public function uninstall()
    {
        parent::uninstall();
        parent::runSql($this->root.'/sql/uninstall.sql');
    }

}