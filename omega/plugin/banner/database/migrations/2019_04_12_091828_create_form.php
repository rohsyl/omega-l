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
        $pluginName = 'banner';

        $mediaChooser = [
            'multiple' => false,
            'preview' => true,
            'type' => ['picture']
        ];

        FormFactory::newForm($pluginName, $pluginName, false, true, 'Banner');
        FormFactory::newFormEntry($pluginName, 'title', 1, \Omega\Utils\Plugin\Type\TextSimple::class, [], 'Title', '', false);
        FormFactory::newFormEntry($pluginName, 'text', 2, \Omega\Utils\Plugin\Type\TextRich::class, [], 'Text', '', false);
        FormFactory::newFormEntry($pluginName, 'background', 3, \Omega\Utils\Plugin\Type\MediaChooser::class, $mediaChooser, 'Background', '', false);
        FormFactory::newFormEntry($pluginName, 'action', 5, \Omega\Utils\Plugin\Type\LinkChooser::class, [], 'Action', 'This will display an button', false);
        FormFactory::newFormEntry($pluginName, 'action_text', 4, \Omega\Utils\Plugin\Type\TextSimple::class, [], 'Action label', 'This is the label of the button, if empty the button is not displayed.', false);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
