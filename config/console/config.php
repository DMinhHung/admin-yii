<?php
$config = [
    'id' => 'console',
    'basePath' => dirname(__DIR__,2)."/src",
    'controllerNamespace' => 'app\commands',
    'bootstrap' => ['queue'],
    'controllerMap' => [
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@app/migrations/db',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'batch' => [
            'class' => 'schmunk42\giiant\commands\BatchController',
            'interactive' => false,
            'overwrite' => true,
            'skipTables' => ['system_db_migration','system_rbac_migration'],
            'modelNamespace' => 'app\models',
            'crudTidyOutput' => false,
            'useTranslatableBehavior' => true,
            'useTimestampBehavior' => true,
            'enableI18N' => false,
            'modelQueryNamespace' => 'app\models',
            'modelBaseClass' => yii\db\ActiveRecord::className(),
            'modelQueryBaseClass' => yii\db\ActiveQuery::className()
        ],
    ],
    'components' => [
        'db' => require('_db.php'),
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis', // Redis connection component or its config
            'channel' => 'queue', // Queue channel key
            'as log' => \yii\queue\LogBehavior::class
        ],
//        'mqtt' => [
//            'class' => \app\components\mqtt\MqttClient::class,
//            'host' => env('MQTT_HOST_SERVER'),
//            'port' => env('MQTT_PORT_SERVER'),
//            'username' => env('MQTT_USERNAME_SERVER'),
//            'password' => env('MQTT_PASSWORD_SERVER'),
//        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => env('REDIS_HOSTNAME'),
            'port' => env('REDIS_PORT'),
            'database' => env('REDIS_DB'),
            'password' => env('REDIS_PASSWORD')
        ]
    ]
];
if (YII_ENV_DEV) {
    // Gii Config
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'allowedIPs' => [
            '*'
        ]
    ];
}
return $config;