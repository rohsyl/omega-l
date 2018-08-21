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


    'mvc' => [
        'defaultcontroller' => 'DashboardController',
        'defaultaction' => 'index'
    ],

    'member' => [
        'enabled' => false,

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
];
