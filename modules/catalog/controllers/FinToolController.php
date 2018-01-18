<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 18.01.2018
 * Time: 21:42
 */

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\FinTool;
use Yii;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\web\Controller;

class FinToolController extends Controller
{
	/**
	 * List of allowed domains.
	 * Note: Restriction works only for AJAX (using CORS, is not secure).
	 *
	 * @return array List of domains, that can access to this API
	 */
	public static function allowedDomains(){
		return Yii::$app->params['allowedDomains'];
	}

	public function behaviors(){
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['fin-tools'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['fin-tools'],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => ['fin-tools'],
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

	public function actionFinTools(){

		$finTool = FinTool::find()->all();

		return $this->asJson($finTool);
	}
}