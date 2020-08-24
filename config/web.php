<?php

use app\components\AuthComponent;
use yii\rbac\DbManager;
use yii\rest\UrlRule;
use yii\web\JsonParser;

$params = require __DIR__ . '/params.php';
$db = file_exists(__DIR__ . '/db_local.php')?
    (require __DIR__ . '/db_local.php')
    :(require __DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'defaultRoute' => 'index/vue',
    'components' => [
        'authManager' => [
            'class' => DbManager::class
        ],
        'auth' => ['class' => app\components\AuthComponent::class],
        'rbac' => ['class' => app\components\RbacComponent::class],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_n6lQGZDNHlJgmT4zrXP0znB4iuVaUYL',
            'parsers' => [
                'application/json' => JsonParser::class
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class'=>UrlRule::class,
                    'controller' => 'posts',
//                    'pluralize' => false
                ],
                ['class'=>UrlRule::class,
                    'controller' => 'racks',
//                    'pluralize' => false
                ],
                ['class'=>UrlRule::class,
                    'controller' => 'connections',
//                    'pluralize' => false
                ],
                'shops/<id:\d+>' => 'shops/index',
                'shop/<id:\d+>' => 'shop/index',
                'categories/<id:\d+>' => 'categories/index',
                'category/<id:\d+>' => 'category/index',
                'racks/<id:\d+>' => 'racks/index',
                'find-path/<id:\d+>' => 'find-path/index',
                'POST maps/<id:\d+>' => 'maps/create',
                'maps/<id:\d+>' => 'maps/index',

            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
