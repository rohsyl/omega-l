<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 10.11.18
 * Time: 16:37
 */

namespace OmegaPlugin\news\Repository;


use OmegaPlugin\News\Models\Category;

class CategoryRepository
{
    private $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    public function all(){
        return $this->category->get();
    }

    public function get($id){
        return $this->category->find($id);
    }

    public function create($inputs){
        $category = new $this->category;
        $category->name = $inputs['name'];
        $category->slug = unique_slug($this->category, str_slug($inputs['name']));
        $category->save();
    }

    public function save($category, $inputs){
        $category->name = $inputs['name'];
        $category->save();
    }

    public function delete($id){
        return $this->category->destroy($id);
    }
}