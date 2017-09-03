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
	'defaultRoute' => '/news',
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
//	        'parsers' => [
//		        'application/json' => 'yii\web\JsonParser',
//	        ]
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
	        //'enableStrictParsing' => true,
            'rules' => [
	            //['class' => 'yii\rest\UrlRule', 'controller' => 'news/news'],

	            'login' => 'user/login',
	            'user' => 'user/index',

	            '/catalog/currency' => '/catalog/currency/index',
	            '/catalog/currency/<id:\w{3}>' => '/catalog/currency/view',
	            '/catalog/currency/<action:(view|update)>/<id:\w{3}>' => '/catalog/currency/<action>',

	            '/catalog/country' => '/catalog/country/index',
	            '/catalog/country/<id:\w{2}>' => '/catalog/country/view',
	            '/catalog/country/<action:(view|update)>/<id:\w{2}>' => '/catalog/country/<action>',

	            '/catalog/periods' => '/catalog/period/periods',
	            '/catalog/fintoolgroups' => '/catalog/fin-tool-group/fin-tool-groups',

	            '/news/widget/news/data/<nid:\d+>/<fid:\d+>/<pid:\d+>' => '/news/default/news-data-json',
	            '/news/widget' => '/news/default/widget',
	            '/news/widget/news' => '/news/news',
	            '/news/widget/newsweek/<t:\d+>/<s:\d+>' => '/news/default/news-week',
	            //'PUT,PATCH /news/widget/news/<id:\d+>' => '/news/news/update',
	            '/news/widget/news/<id:\d+>' => '/news/news/view',


	            '/news' => '/news/default/index',
	            '/news/create' => '/news/default/create',
	            '/news/data/<news_id:\d+>/<fintool_id:\d+>/<period_id:\d+>' => '/news/default/newsdata',
	            '/news/data/del/<id:\d+>' => '/news/default/newsdatadel',
	            '/news/data/delall/<news_id:\d+>/<fintool_id:\d+>/<period_id:\d+>' => '/news/default/newsdatadelall',
	            '/news/<action:(view|update)>/<id:\d+>' => '/news/default/<action>',

	            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
	            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
	            '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\w+>' => '<module>/<controller>/<action>',
	            '<module:\w+>/<action:\w+>' => '<module>/<action>',
            ],
        ]
    ],
	'as beforeRequest' => [
		'class' => 'yii\filters\AccessControl',
		'rules' => [
			[
				'allow' => true,
				'actions' => ['login', 'news-week', 'periods', 'fin-tool-groups', 'news-data-json'],
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
