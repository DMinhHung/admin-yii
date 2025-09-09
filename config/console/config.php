<?php
$config = [
    'id' => 'console',
    'basePath' => dirname(__DIR__,2)."/src",
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => require('_db.php'),
    ]
];
if (YII_ENV_DEV) {

    // Load Dumper
//    $config['bootstrap'][] = 'dumper';
//    $config['modules']['dumper'] = [
//        'class' => 'Guanguans\YiiVarDumper\Module',
//        //'host' => 'tcp://127.0.0.1:9913'
//    ];
}
return $config;