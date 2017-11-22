<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

\yii\base\Event::on(
	\webtoolsnz\scheduler\console\SchedulerController::className(),
	\webtoolsnz\scheduler\events\SchedulerEvent::EVENT_AFTER_RUN,
	function ($event) {
		if (!$event->success) {
			foreach($event->exceptions as $exception) {
				throw $exception;
			}
		}
	}
);

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'scheduler'],
	'modules' => [
		'scheduler' => ['class' => 'webtoolsnz\scheduler\Module']
	],
    'controllerNamespace' => 'app\commands',
    'components' => [
    	'errorHandler' => [
    		'class' => 'webtoolsnz\scheduler\ErrorHandler'
	    ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
        	'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\EmailTarget',
	                'mailer' => 'mailer',
                    'levels' => ['error', 'warning'],
	                'message' => [
	                	'to' => ['lokidoma@gmail.com'],
		                'from' => [$params['adminEmail']],
		                'subject' => 'Scheduler Error - ####SERVERNAME####'
	                ],
	                'except' => [

	                ]
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
