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
    'bootstrap' => [
		'log', 
		\app\bootstrap\EventsSubscriber::class,
		\app\bootstrap\DependencyInjector::class,
		// \app\bootstrap\SchedulerSetup::class
	],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	'language'=> 'ru-RU',
    'defaultRoute' => '',
	'container' => [
		'singletons' => [
			\app\interfaces\ClientInterface::class => [
				'class' => \app\services\HttpClientService::class
				],
			\app\interfaces\ServiceFactoryInterface::class => [
				'class' => \app\services\ServiceFactory::class
			],
			\Symfony\Contracts\EventDispatcher\EventDispatcherInterface::class => [
				'class' => \Symfony\Component\EventDispatcher\EventDispatcher::class
			]
		]
	],
	'defaultRoute' => 'index/vue',
    'components' => [
		// 'schedule' => 'omnilight\scheduling\Schedule',
        'authManager' => [
            'class' => DbManager::class
        ],
        'auth' => ['class' => app\components\AuthComponent::class],
        'rbac' => ['class' => app\components\RbacComponent::class],
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
            'class' => 'yii\caching\MemCache',
			'useMemcached' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
			'enableSession' => false
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'notifier' => [
				'class'=>\app\components\NotificationComponent::class
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
					//'except' => ['delete']
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
					'except' => ['delete'],
					'extraPatterns' => [
							'POST batch' => 'batch',
						]
                ],
                [
					'class'=>UrlRule::class,
                    'controller' => 'car',
					'prefix' => 'api/v1',
					'except' => ['delete']
                ],
                [
					'class'=>UrlRule::class,
                    'controller' => 'balance',
					'prefix' => 'api/v1',
					'except' => ['delete', 'put', 'patch'],
					'extraPatterns' => [
							'GET citymobile' => 'citymobile',
						]
					
                ],
                [
					'class'=>UrlRule::class,
                    'controller' => 'transaction',
					'prefix' => 'api/v1',
					'except' => ['delete', 'put', 'patch'],
					'extraPatterns' => [
						]
					
                ],
                [
					'class'=>UrlRule::class,
                    'controller' => 'transfer',
					'prefix' => 'api/v1',
					'except' => ['delete'],
					'extraPatterns' => [
						'GET all' => 'alltransfers',
						'POST batch' => 'batch'
					]
					
                ],
				[
					'class' => UrlRule::class,
					'controller' => 'account',
					'prefix' => 'api/v1',
					'except' => ['delete'],
				],
				[
					'class' => UrlRule::class,
					'controller' => 'bank-transfer',
					'prefix' => 'api/v1',
					'pluralize' =>false,
					'except' => ['delete'],
					'extraPatterns' => [
						'POST do' => 'do',
					]
				]
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
