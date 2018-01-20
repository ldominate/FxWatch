<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 20.01.2018
 * Time: 12:08
 */

namespace app\modules\news\controllers;


use app\modules\news\models\News;
use Yii;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\Controller;

class StatisticsController extends Controller
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

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
					'newsdatadel' => ['POST']
				],
			],
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

	public function actionIndex(){
		return $this->renderContent('Data');
	}

	/**
	 * @param $country string
	 * @param $category integer
	 * @param $period integer
	 * @param $interval integer
	 * @return \yii\web\Response
	 */
	public function actionFinTools($country, $category, $period, $interval = null){

		$query = News::find();

		if(isset($country) && strlen($country) == 2){
			$query = $query->where('`news`.`country_code` = :countrycode', [':countrycode' => $country]);
		}
		if(isset($category) && is_numeric($category)){
			$query = $query->andWhere('`news`.`categorynews_id` = :categorynews_id', [':categorynews_id' => $category]);
		}
		if(isset($period) && is_numeric($period)){
			;
		}
		if(isset($interval) && is_numeric($interval)){
			$query = $query->andWhere('TO_DAYS(NOW()) - TO_DAYS(`news`.`published`) <= CAST(:interval AS UNSIGNED)', [':interval' => $interval]);
		}

		$news = $query->orderBy(['published' => SORT_DESC])
			->asArray()
			->all();

		return $this->asJson($news);
	}

}