<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Omega\Facades\FormFactory;

class CreateForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $display = [
            'default' => 1,
            'options' => [
                1 => 'List',
                2 => 'Grid',
                10 => 'Detail'
            ]
        ];
        FormFactory::newForm('news', 'news', true, true, 'News');
        FormFactory::newFormEntry('news', 'display', 0, \Omega\Utils\Plugin\Type\DropDown::class, $display, 'Display', 'Choose how to display this', false);
        FormFactory::newFormEntry('news', 'count', 1, \Omega\Utils\Plugin\Type\TextSimple::class, [], 'Number of post displayed', 'By default all posts are displayed', false);
        FormFactory::newFormEntry('news', 'categories', 2, \Omega\Utils\Plugin\Type\CheckBoxes::class, ['model' => \OmegaPlugin\News\Type\Models\CheckBoxesCategoriesModel::class], 'Categories', '', false);
        FormFactory::newFormEntry('news', 'page', 3, \Omega\Utils\Plugin\Type\DropDown::class, ['model' => \OmegaPlugin\News\Type\Models\DropDownPage::class], 'Page', 'The page used to display one item. Be carefull, it must be a child of this page.', false);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        FormFactory::deleteForm('news');
    }
}
