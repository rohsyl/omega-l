<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 10.11.18
 * Time: 16:33
 */

namespace OmegaPlugin\News\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Omega\Utils\Entity\Media;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'news_posts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'publised_at'
    ];

    public function categories(){
        return $this->belongsToMany('OmegaPlugin\News\Models\Category', 'news_post_category', 'post_id', 'category_id');
    }

    public function author(){
        return $this->belongsTo('Omega\Models\User', 'user_id');
    }

    public function publishedAtFormatted(){
        $date = new Carbon($this->published_at);
        return $date->format('d-m-Y');
    }

    public function image(){
        if(!isset($this->media_id)){
            return null;
        }
        return Media::Get($this->media_id);
    }
}