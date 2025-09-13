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
    // using DB
    'db' => require('_db.php'),
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'enableStrictParsing' => false,
        // Comment Below if you only using UrlManager.
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
//    'queue' => [
//        'class' => \yii\queue\redis\Queue::class,
//        'redis' => 'redis', // Redis connection component or its config
//        'channel' => 'queue', // Queue channel key
//        'as log' => \yii\queue\LogBehavior::class
//    ],
//    'mqtt' => [
//        'class' => \app\components\mqtt\MqttClient::class,
//        'host' => env('MQTT_HOST_SERVER'),
//        'port' => env('MQTT_PORT_SERVER'),
//        'username' => env('MQTT_USERNAME_SERVER'),
//        'password' => env('MQTT_PASSWORD_SERVER'),
//    ],
//    'redis' => [
//        'class' => \yii\redis\Connection::class,
//        'hostname' => env('REDIS_HOSTNAME'),
//        'port' => env('REDIS_PORT'),
//        'database' => env('REDIS_DB'),
//        'password' => env('REDIS_PASSWORD')
//    ]
];
return $components;
