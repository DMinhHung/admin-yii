<?php
// Settings for web-application only -- PRODUCTION
$config = [
    'aliases' => [
        // This is for DEBUG only
        '@bower' => '/app/vendor/yidas/yii2-bower-asset/bower',
        '@yii/gii' => '/app/vendor/yiisoft/yii2-gii',
        "@web_asset" => '/app/web',
        '@yii/debug/assets' => '@vendor/yiisoft/yii2-debug/src/assets',
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
            '127.0.0.1',
            '::1',
            '192.168.*',
            '172.18.*',
        ],
    ];
    // Gii Config
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
    ];
}

return $config;