<?php

return [

    /**
     * Debug level
     * 0 => no error message
     * 1 => E_ALL ^ E_STRICT ^ E_WARNING
     * 2 => E_ALL
     */
    'debug' => [
        'level' => 2
    ],

    /**
     * Set default Controller and action to be called at the root of the admin
     */
    'mvc' => [
        'defaultcontroller' => 'DashboardController',
        'defaultaction' => 'index'
    ],

    /**
     * Member part
     * TODO: implement the public part
     */
    'member' => [
        /**
         * Keep it disabled until it's implemented
         */
        'enabled' => true,

        'password' => [
            'salt' => 'Jb0=nuxa)2'
        ],

        'loginwith' => [
            'enable' => false,
            'enableFacebook' => false,
            'enableTwitter' => false,
            'enableGooglePlus' => false,
            'facebookKey' => '',
            'facebookSecret' => '',
            'twitterKey' => '',
            'twitterSecret' => '',
            'googleKey' => '',
            'googleSecret' => ''
        ],

        'custom' => [
            'name' => '',
            'dataInstance' => '',
            'customSignup' => '',
            'customProfileInfo' => ''
        ]
    ],

    /**
     * Define the icon to be used in the media library
     */
    'media' => [
        'icons' => [
            'folder_icon_class' => 'glyphicon glyphicon-folder-open',
            'video_icon_class' => 'glyphicon glyphicon-facetime-video',
            'picture_icon_class' => 'glyphicon glyphicon-picture',
            'file_icon_class' => 'glyphicon glyphicon-file',
            'music_icon_class' => 'glyphicon glyphicon-headphones',
            'videoext_icon_class' => 'glyphicon glyphicon-play',
        ],
    ],

    'page' => [

        /**
         * This entry allow you to define the number
         * of item per pages in the pages list.
         */
        'paginate' => 20,

        'trash' => [
            'paginate' => 20,
        ]
    ],


    /**
     * These string must not be used as page slug
     * You can put here some static string
     * or even database table column.
     * Exemple :
     * $[table_name].[column_name]
     */
    'reserved_slug' => [
        'admin', 'module', '$langs.slug'
    ]
];
