<?php

namespace app\modules\news\controllers;

use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

class NewsController extends ActiveController
{
    public $modelClass = 'app\modules\news\models\News';

	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['contentNegotiator'] = [
			'class' => ContentNegotiator::className(),
			'formats' => [
				'application/json' => Response::FORMAT_JSON,
			],
		];

		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'only' => ['create', 'update', 'delete'],
			'rules' => [
				[
					'actions' => ['create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['@'],
				],
			],
		];

//		return [
//			'access' => [
//				'class' => AccessControl::className(),
//				'rules' => [
//					[
//						'actions' => ['*'],
//						'allow' => true,
//						'roles' => ['@'],
//					]
//				],
//			]
//		];
		return $behaviors;
	}
//
//	public function checkAccess($action, $model = null, $params = [])
//	{
//		return true;
//	}
}
