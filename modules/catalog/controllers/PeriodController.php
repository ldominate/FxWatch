<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\Period;
use yii\filters\AccessControl;
use yii\web\Controller;

class PeriodController extends Controller
{
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
		];
	}

    public function actionPeriods()
    {
    	$periods = Period::find()->all();

        return $this->asJson($periods);
    }

}
