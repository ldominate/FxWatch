<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
	'name' => 'Trading Watch',
    'basePath' => dirname(__DIR__),
	'language' => 'ru-RU',
	'layout' => 'sba2',
    'bootstrap' => ['log'],
	'modules' => [
		'catalog' => [
			'class' => 'app\modules\catalog\CatalogModule',
		],
		'news' => [
			'class' => 'app\modules\news\NewsModule'
		]
	],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'XKvkaCvN3-syonh249uJ85ozdDDMEkXM',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
	        'defaultDuration' => 604800
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
	        'enableSession' => true,
	        'loginUrl' => ['login']
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
	            'login' => 'user/login',
	            'user' => 'user/index',

	            '/catalog/currency' => '/catalog/currency/index',
	            '/catalog/currency/<id:\w{3}>' => '/catalog/currency/view',
	            '/catalog/currency/<action:(view|update)>/<id:\w{3}>' => '/catalog/currency/<action>',

	            '/catalog/country' => '/catalog/country/index',
	            '/catalog/country/<id:\w{2}>' => '/catalog/country/view',
	            '/catalog/country/<action:(view|update)>/<id:\w{2}>' => '/catalog/country/<action>',

	            '/news' => '/news/default/index',

	            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
	            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
	            '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\w+>' => '<module>/<controller>/<action>',
	            '<module:\w+>/<action:\w+>' => '<module>/<action>',
            ],
        ],
    ],
	'as beforeRequest' => [
		'class' => 'yii\filters\AccessControl',
		'rules' => [
			[
				'allow' => true,
				'actions' => ['login'],
				'roles' => ['?']
			],
			[
				'allow' => true,
				'roles' => ['@'],
			],
		],
		'denyCallback' => function () {
			return Yii::$app->response->redirect(['user/login']);
		},
	],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
