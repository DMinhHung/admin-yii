<?php
$routeRules = require('_routes.php');
$components = [
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'user' => [
        'identityClass' => 'app\models\User',
        'enableAutoLogin' => true,
    ],
    'cache' => require("_cache.php"),
    'request' => [
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ],
        'enableCsrfCookie' => false,
        'enableCookieValidation' => false,
    ],
    'db' => require('_db.php'),
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'enableStrictParsing' => false,
        'rules' => $routeRules['rules'],
    ],
    'response' => [
        'class' => 'yii\web\Response',
        'format' => \yii\web\Response::FORMAT_JSON,
    ],
    'fileStorage' => [
        'class' => \app\components\filekit\Storage::class,
        'baseUrl' => env("STORAGE_URL"),
        'filesystem' => [
            'class' => \app\components\filesystem\ClouldflareR2::class,
            'key' => env('S3_KEY'),
            'secret' => env('S3_SECRET'),
            'region' => env('S3_REGION'),
            'bucket' => env('S3_BUCKET'),
            'end_point' => env('S3_END_POINT')
        ]
    ],
    'mailer' => [
        'class' => \yii\symfonymailer\Mailer::class,
        'useFileTransport' => false,
        'transport' => [
            'scheme'   => 'smtp',
            'host'     => 'smtp.gmail.com',
            'username' => env('MAIL_USER'),
            'password' => env('MAIL_PASSWORD'),
            'port'     => 587,
        ],
    ],
];

return $components;
