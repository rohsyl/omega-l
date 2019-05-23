<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 10.11.18
 * Time: 16:34
 */

namespace OmegaPlugin\News\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'news_categories';

    public function posts(){
        return $this->belongsToMany('OmegaPlugin\News\Models\Post', 'news_post_category', 'category_id', 'post_id');
    }
}