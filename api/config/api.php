<?php

$params = require(__DIR__ . '/../../config/params.php');

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__) . '/..',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/api/modules/v1',
            'class' => 'app\api\modules\v1\Api',
        ]
    ],
    'components' => [
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;

                if ($response->data !== null) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            },
        ],
        'errorAction' => 'v1/info/error',
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/user'
                    ],
                ],
                'info' => 'v1/info/index',
                'profile' => 'v1/user/profile',
                'logout' => 'v1/user/logout',
                'login' => 'v1/auth/login',
                'register' => 'v1/auth/register',
                'author' => 'v1/author/index',
                'quote' => 'v1/quote/index',
                '/' => 'v1/info/error',
                '/<url:[a-zA-Z0-9-]+>' => 'v1/info/error',
            ],
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\api\modules\v1\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@api/runtime/logs/error.log'
                ],
            ],
        ],
        'db' => (YII_ENV=='dev')?require(__DIR__ . '/../../config/test_db.php'):require(__DIR__ . '/../../config/db.php')
    ],
    'params' => $params,
];

return $config;