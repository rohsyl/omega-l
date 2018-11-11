<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 10.11.18
 * Time: 16:37
 */

namespace OmegaPlugin\news\Repository;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use OmegaPlugin\News\Models\Post;

class PostRepository
{
    private $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    public function all(){
        return $this->post->get();
    }

    private function _allWithCategoriesAndPublishedAndNotArchived($categories){
        return $this->post
            ->join('news_post_category', 'news_post_category.fkPost', '=', 'news_post.id')
            ->join('news_category', 'news_post_category.fkCategory', '=', 'news_category.id')
            ->whereIn('news_category.id', $categories)
            ->whereDate('published_at', '<=', Carbon::today()->toDateString())
            ->where('archived', 0);
    }

    public function allWithCategoriesAndPublishedAndNotArchived($categories, $limit){
        return $this->_allWithCategoriesAndPublishedAndNotArchived($categories)
            ->select('news_post.*')
            ->limit($limit)
            ->orderBy('published_at', 'DESC')
            ->get();
    }

    public function getNext($post, $categories){
        return $this->_allWithCategoriesAndPublishedAndNotArchived($categories)
            ->where('published_at', '>', function($q) use ($post)
            {
                $q->from('news_post')
                    ->select('published_at')
                    ->where('id', $post->id);
            })
            ->orderBy('published_at', 'ASC')
            ->select('news_post.*')
            ->limit(1)
            ->first();
    }

    public function getPrevious($post, $categories){
        return $this->_allWithCategoriesAndPublishedAndNotArchived($categories)
            ->where('published_at', '<', function($q) use ($post)
            {
                $q->from('news_post')
                    ->select('published_at')
                    ->where('id', $post->id);
            })
            ->orderBy('published_at', 'ASC')
            ->select('news_post.*')
            ->limit(1)
            ->first();
    }

    public function get($id){
        return $this->post->find($id);
    }

    public function create($inputs){
        $post = new $this->post;
        $post->title = $inputs['title'];
        $post->fkUser = Auth::id();
        $post->save();
        return $post->id;
    }

    public function save($post, $inputs){
        $post->title = $inputs['title'];
        $post->brief = $inputs['brief'];
        $post->text = $inputs['text'];
        $post->fkMedia = $inputs['image'];
        $post->published_at = $inputs['published_at'];

        $post->categories()->detach();

        if(isset($inputs['categories']))
            foreach($inputs['categories'] as $category){
                $post->categories()->attach($category);
            }

        $post->save();
    }

    public function delete($id){
        return $this->post->destroy($id);
    }
}