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
    ]
];
