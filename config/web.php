<?php

use app\components\AuthComponent;
use yii\rbac\DbManager;
use yii\rest\UrlRule;
use yii\web\JsonParser;

$params = file_exists(__DIR__ . '/params_local.php')
			?
			(require __DIR__ . '/params_local.php')
			:
			(require __DIR__ . '/params.php');
$db = file_exists(__DIR__ . '/db_local.php')?
    (require __DIR__ . '/db_local.php')
    :(require __DIR__ . '/db.php');
// $transport = file_exists(__DIR__.'/mail_local.php')
			// ? (require __DIR__.'/mail_local.php')
			// : [];
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', \app\bootstrap\EventsSubscriber::class],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	'language'=> 'ru-RU',
    'defaultRoute' => '',
	'container' => [
		'singletons' => [
			\Symfony\Contracts\EventDispatcher\EventDispatcherInterface::class => ['class' => \Symfony\Component\EventDispatcher\EventDispatcher::class]
		]
	],
    'components' => [
        'authManager' => [
            'class' => DbManager::class
        ],
        'auth' => ['class' => app\components\AuthComponent::class],
        'rbac' => ['class' => app\components\RbacComponent::class],
		'notifier' => ['class' => app\components\NotificationComponent::class],
		'async' => [
            'class' => 'vxm\async\Async',
            'appConfigFile' => '@app/config/async.php' // optional when you need to use yii feature in async process.
        ],
		'consoleRunner' => [
			'class' => 'vova07\console\ConsoleRunner',
			'file' => '../vendor/yiisoft/yii2/yii' // or an absolute path to console file
		],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_n6lQGZDNHlJgmT4zrXP0znB4iuVaUYL',
            'parsers' => [
                'application/json' => JsonParser::class
            ],
			'enableCookieValidation' => false,
        	'enableCsrfValidation'   => false
        ],
		'response' => [
			'formatters' => [
				\yii\web\Response::FORMAT_JSON => [
					'class' => 'yii\web\JsonResponseFormatter',
					'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
					'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
					// ...
				],
			],
		],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
			'enableSession' => false
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
			'enableSwiftMailerLogging' => true,
			'transport' => $params['transport']
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
				[
					'class'=>\yii\rest\UrlRule::class,
					'controller'=>['profile'],
					'prefix' => 'api/v1',
					'except' => ['delete']
				],
                [
					'class'=>\yii\rest\UrlRule::class,
                    'controller' => 'user',
					'prefix' => 'api/v1',
					'except' => ['delete']
                ],
                [
					'class'=>UrlRule::class,
                    'controller' => 'agregator',
					'prefix' => 'api/v1',
					'except' => ['delete']
                ],
                [
					'class'=>UrlRule::class,
                    'controller' => 'user-agregator',
					'prefix' => 'api/v1',
					'pluralize' =>false,
					'except' => ['delete']
                ],
                [
					'class'=>UrlRule::class,
                    'controller' => 'car',
					'prefix' => 'api/v1',
					'except' => ['delete']
                ],

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
