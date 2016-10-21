<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'BN-YWdanrpmcc23tInnvDJl2PDjg7gKi',
        ],
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\DummyCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
//'enableStrictParsing' => true,
        'rules' => [
        [
        'pattern' => '/',
        'route' => 'news/site/',
        ],
        [
        'pattern' => '<action>',
        'route' => 'news/site/<action>',
        ],
        [
        'pattern' => 'feed/<controller>/<action>',
        'route' => 'feedbackamocrm/<controller>/<action>',
        ],
        ],
        ],

        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],

                'modules' => [
        'news' => [
            'class' => 'app\modules\news\news',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
