<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 18.01.2018
 * Time: 22:02
 */

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\CategoryNews;
use Yii;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\web\Controller;

class CategoryNewsController extends Controller
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
				'only' => ['category-news'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['category-news'],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => ['category-news'],
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

	public function actionCategoryNews($c){

		$query = CategoryNews::find();

		if(isset($c) && strlen($c) == 2){
			$query = $query->innerJoin('news', '`news`.`categorynews_id` = `categorynews`.`id`')
				->where('`news`.`country_code` = :countrycode', [':countrycode' => $c]);
		}

		$categoryNews = $query->orderBy(['name' => SORT_ASC])
			->asArray()
			->all();

		return $this->asJson($categoryNews);
	}
}