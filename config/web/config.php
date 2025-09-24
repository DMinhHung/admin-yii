<?php
// Settings for web-application only -- PRODUCTION
$config = [
    'aliases' => [
        '@bower' => '@vendor/yidas/yii2-bower-asset/bower',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => require("_modules.php"),
    'components' => require ("_components.php"),
];
if (YII_ENV_DEV)
{
    // Debug Config
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => [
            '*'
        ],
    ];
    // Gii Config
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
    ];
}

return $config;