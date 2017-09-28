<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\Period;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\web\Controller;

class PeriodController extends Controller
{
	/**
	 * List of allowed domains.
	 * Note: Restriction works only for AJAX (using CORS, is not secure).
	 *
	 * @return array List of domains, that can access to this API
	 */
	public static function allowedDomains()
	{
		return [
			// '*',                        // star allows all domains
			'http://fxwatch',
			'http://fx-chart.foshan.tours',
			'http://vladbat.ru',
			'http://widget.fxwatch.ru'
		];
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['periods'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['periods'],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => ['periods'],
						'roles' => ['@'],
					],
				],
			],
			'corsFilter'  => [
				'class' => Cors::className(),
				'cors'  => [
					// restrict access to domains:
					'Origin'                           => static::allowedDomains(),
					'Access-Control-Request-Method'    => ['GET'],
					'Access-Control-Allow-Credentials' => true,
					'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
				],
			]
		];
	}

    public function actionPeriods()
    {
    	$periods = Period::find()->all();

        return $this->asJson($periods);
    }

}
