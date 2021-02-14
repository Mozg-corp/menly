<?php

use yii\rbac\DbManager;

$params = file_exists(__DIR__ . '/params_local.php')
			?
			(require __DIR__ . '/params_local.php')
			:
			(require __DIR__ . '/params.php');
$db = file_exists(__DIR__ . '/db_local.php')?
    (require __DIR__ . '/db_local.php')
    :(require __DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
	'container' => [
		'singletons' => [
			\app\interfaces\ClientInterface::class => [
				'class' => \app\services\HttpClientService::class
				],
			\app\interfaces\ServiceFactoryInterface::class => [
				'class' => \app\services\ServiceFactory::class
			]
			
		]
	],
    'components' => [
		'schedule' => 'omnilight\scheduling\Schedule',
        'auth' => ['class' => app\components\AuthComponent::class],
        'authManager' => [
            'class' => DbManager::class
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
			//'useMemcached' => true,
			//'servers' => [
			//	[
			//		'host' => '127.0.0.1',
			//		'port' => 11211
			//	],
			//],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
