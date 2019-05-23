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
            ->join('news_post_category', 'news_post_category.post_id', '=', 'news_posts.id')
            ->join('news_categories', 'news_post_category.category_id', '=', 'news_categories.id')
            ->whereIn('news_categories.id', $categories)
            ->whereDate('published_at', '<=', Carbon::today()->toDateString())
            ->where('archived', 0);
    }

    public function allWithCategoriesAndPublishedAndNotArchived($categories, $limit){
        return $this->_allWithCategoriesAndPublishedAndNotArchived($categories)
            ->select('news_posts.*')
            ->limit($limit)
            ->orderBy('published_at', 'DESC')
            ->get();
    }

    public function getNext($post, $categories){

        return $this->_allWithCategoriesAndPublishedAndNotArchived($categories)
            ->where('published_at', '>', function($q) use ($post)
            {
                $q->from('news_posts')
                    ->select('published_at')
                    ->where('id', $post->id);
            })
            ->orderBy('published_at', 'ASC')
            ->select('news_posts.*')
            ->limit(1)
            ->first();
    }

    public function getPrevious($post, $categories){
        return $this->_allWithCategoriesAndPublishedAndNotArchived($categories)
            ->where('published_at', '<', function($q) use ($post)
            {
                $q->from('news_posts')
                    ->select('published_at')
                    ->where('id', $post->id);
            })
            ->orderBy('published_at', 'ASC')
            ->select('news_posts.*')
            ->limit(1)
            ->first();
    }

    public function get($id){
        return $this->post->find($id);
    }


    public function getBySlug($slug){
        return $this->post->where('slug', $slug)->first();
    }

    public function create($inputs){
        $post = new $this->post;
        $post->title = $inputs['title'];
        $post->slug = unique_slug($post, str_slug($post->title));
        $post->user_id = Auth::id();
        $post->save();
        return $post->id;
    }

    public function save($post, $inputs){
        $post->title = $inputs['title'];
        $post->brief = $inputs['brief'];
        $post->text = $inputs['text'];
        $post->media_id = $inputs['image'];
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