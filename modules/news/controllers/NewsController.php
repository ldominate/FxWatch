<?php

namespace app\modules\news\controllers;

use app\modules\news\models\NewsRest;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

class NewsController extends ActiveController
{
	public $modelClass = 'app\modules\news\models\NewsRest';

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
	public function actions(){

		$actions = parent::actions();

		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

		return $actions;
	}

	public function prepareDataProvider()
	{
		$searchModel = new NewsRest();

		$queryParams = ['NewsRest' => \Yii::$app->request->queryParams];

		return $searchModel->search($queryParams);
	}
}
