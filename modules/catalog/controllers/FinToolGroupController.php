<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\FinToolGroup;
use yii\filters\AccessControl;

class FinToolGroupController extends \yii\web\Controller
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
						'actions' => ['fin-tool-groups'],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => ['fin-tool-groups'],
						'roles' => ['@'],
					],
				],
			],
		];
	}

    public function actionFinToolGroups()
    {
    	$finToolGroups = FinToolGroup::find()->with('fintools')->all();

        return $this->asJson($finToolGroups);
    }

}
