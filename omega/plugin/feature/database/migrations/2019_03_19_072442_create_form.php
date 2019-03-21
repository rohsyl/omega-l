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
        $formName = 'feature';
        FormFactory::newForm($formName,
            'feature',
            false,
            true,
            'Feature');

        FormFactory::newFormEntry(
            $formName,
            'title',
            1,
            Omega\Utils\Plugin\Type\TextSimple::class,
            [],
            'Title',
            '',
            0
        );
        FormFactory::newFormEntry(
            $formName,
            'text',
            2,
            Omega\Utils\Plugin\Type\TextRich::class,
            [],
            'Text',
            '',
            0
        );
        FormFactory::newFormEntry(
            $formName,
            'image',
            3,
            Omega\Utils\Plugin\Type\MediaChooser::class,
            ['multiple' => false, 'preview' => true, 'type' => ['picture']],
            'Image',
            '',
            0
        );
        /*FormFactory::newFormEntry(
            $formName,
            'icon',
            4,
            Omega\Utils\Plugin\Type\IconChooser::class,
            [],
            'Icon',
            '',
            0
        );
        FormFactory::newFormEntry(
            $formName,
            'radio',
            5,
            Omega\Utils\Plugin\Type\RadioButtons::class,
            ['default' => 0, 'options' => ['0' => 'Image', '1' => 'Icon']],
            'Use image or icon',
            '',
            0
        );*/
        FormFactory::newFormEntry(
            $formName,
            'link',
            6,
            Omega\Utils\Plugin\Type\LinkChooser::class,
            [],
            'Link',
            '',
            0
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Form is automatically deleted when uninstalling the plugin.
    }
}
