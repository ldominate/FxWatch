<?php

namespace app\modules\news\controllers;

use app\modules\catalog\models\FinTool;
use app\modules\catalog\models\Period;
use app\modules\news\models\form\NewsDataUpload;
use app\modules\news\models\NewsData;
use app\modules\news\models\NewsRest;
use Yii;
use app\modules\news\models\News;
use app\modules\news\models\NewsSearch;
use yii\data\ActiveDataProvider;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * Default controller for the `News` module
 */
class DefaultController extends Controller
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
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
					'newsdatadel' => ['POST']
				],
			],
			'access' => [
				'class' => yii\filters\AccessControl::className(),
				'only' => ['news-week'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['news-week'],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => ['news-week'],
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

	/**
	 * Lists all News models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new NewsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * @return \yii\web\Response
	 */
	public function actionNewsWeek($t, $s){
		//$monday_this_week_date = Yii::$app->formatter->asDatetime(strtotime('Monday next week T00:00:00'), News::DATETIME_FORMAT_DB);
		//$sunday_this_week_date = Yii::$app->formatter->asDatetime(strtotime('Sunday next week T23:59:59'), News::DATETIME_FORMAT_DB);

		$headers = Yii::$app->response->headers;

		$query = NewsRest::find()
			->andWhere([
				'between',
				'published',
				Yii::$app->formatter->asDatetime(strtotime('Monday this week T00:00:00'), News::DATETIME_FORMAT_DB),
				Yii::$app->formatter->asDatetime(strtotime('Sunday this week T23:59:59'), News::DATETIME_FORMAT_DB)])
			;

		$headers->add('X-Pagination-Total-Count', $query->count());

		$query->with('categorynews')
			->with('countryCode')
			->orderBy(['published' => SORT_DESC]);

		if(isset($t) && is_numeric($t)){
			$query->limit($t);
		}
		if(isset($s) && is_numeric($s)){
			$query->offset($s);
		}

		$news_this_week = $query->all();

		return $this->asJson($news_this_week);
	}

	/**
	 * @param $id
	 * @return \yii\web\Response
	 */
	public function actionNewsAssociated($id, $t, $s){

		if(!isset($id) || !is_numeric($id)) return $this->asJson([]);

		$headers = Yii::$app->response->headers;

		$query = NewsRest::find();

		$subQuery = NewsRest::find()
			->select(['id', 'published', 'categorynews_id'])
			->where(['id' => $id]);

		$query->select('`Nw`.*')
			->from(['Bn' => $subQuery, 'Nw' => NewsRest::tableName()])
			->with('categorynews')
			->with('countryCode')
			->with('influence');

		$query//->andWhere('`Nw`.`id` <> `Bn`.`id`')
			->andWhere('`Nw`.`published` BETWEEN
			`Bn`.`published` - INTERVAL '.News::DELTA_ASSOCIATED_NEWS.' SECOND
			AND `Bn`.`published` + INTERVAL '.News::DELTA_ASSOCIATED_NEWS.' SECOND')
			->orderBy(['`Nw`.`published`' => SORT_DESC]);

		$headers->add('X-Pagination-Total-Count', $query->count());

		if(isset($t) && is_numeric($t)){
			$query->limit($t);
		}
		if(isset($s) && is_numeric($s)){
			$query->offset($s);
		}

		$news_associated = $query->all();

		return $this->asJson($news_associated);
	}

	public function actionNewsCategory($id, $t, $s){

		if(!isset($id) || !is_numeric($id)) return $this->asJson([]);

		$headers = Yii::$app->response->headers;

		$query = NewsRest::find();

		$subQuery = NewsRest::find()
			->select(['id', 'published', 'categorynews_id'])
			->where(['id' => $id]);

		$query->select('`Nw`.*')
			->from(['Bn' => $subQuery, 'Nw' => NewsRest::tableName()])
			->with('categorynews')
			->with('countryCode')
			->with('influence');

		$query->andWhere('`Nw`.`id` <> `Bn`.`id`')
			->andWhere('`Nw`.`categorynews_id` = `Bn`.`categorynews_id`')
			->andWhere('`Nw`.`published` <= `Bn`.`published`')
			->orderBy(['`Nw`.`published`' => SORT_DESC]);

		$headers->add('X-Pagination-Total-Count', $query->count());

		if(isset($t) && is_numeric($t)){
			$query->limit($t);
		}
		if(isset($s) && is_numeric($s)){
			$query->offset($s);
		}

		$news_associated = $query->all();

		return $this->asJson($news_associated);
	}

	/**
	 * @param $t integer Take
	 * @param $s integer Skip
	 * @param $c string Country code
	 * @param $sch string Search
	 * @return \yii\web\Response
	 */
	public function actionNewsList($t, $s){

		$headers = Yii::$app->response->headers;

		$query = NewsRest::find();

		$query->with('categorynews')
			->with('countryCode')
			->with('influence');

		$c = Yii::$app->request->get('c', '');
		if(strlen($c) == 2){
			$query->andWhere(['=', 'country_code', $c]);
		}

		$sch = Yii::$app->request->get('sch', '');
		if(strlen($sch) > 0){
			$query->join('LEFT JOIN', 'categorynews', 'categorynews.id = news.categorynews_id');
			$query->join('LEFT JOIN', 'country', 'country.code = news.country_code');
			$query->join('LEFT JOIN', 'currency', 'currency.code = news.currency_code');
			$query->andWhere(['like', 'categorynews.name', $sch]);
			$query->orWhere(['or like', 'country.name', $sch]);
			$query->orWhere(['or like', 'country_code', $sch]);
			$query->orWhere(['or like', 'currency_code', $sch]);
			$query->orWhere(['or like', 'currency.name', $sch]);
			$query->orWhere(['or like', 'release', $sch]);
			$query->orWhere(['or like', 'fact', $sch]);
			$query->orWhere(['or like', 'forecast', $sch]);
			$query->orWhere(['or like', 'deviation', $sch]);
			$query->orWhere(['or like', 'previous', $sch]);
		}

		$headers->add('X-Pagination-Total-Count', $query->count());

		if(isset($t) && is_numeric($t)){
			$query->limit($t);
		}
		if(isset($s) && is_numeric($s)){
			$query->offset($s);
		}
		$query->orderBy(['published' => SORT_DESC]);

		$newsList = $query->all();

		return $this->asJson($newsList);
	}

	/**
	 * Displays a single News model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new News model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new News();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['update', 'id' => $model->id]);
		} else {
			if(empty($model->published)) {
				$model->published = time();
				//$model->published = Yii::$app->formatter->asDatetime(time(),News::DATETIME_FORMAT);
				//$model->fact = $model->forecast = $model->deviation = $model->previous = 0.0;
			}

			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing News model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post())){
			$model->save();
		}
		$associated_news = News::find()->associated($model->id, $model->published)->with('influence')->all();

		return $this->render('update', [
			'model' => $model,
			'associated' => $associated_news
		]);
	}

	/**
	 * Deletes an existing News model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * @param integer $news_id
	 * @param integer $fintool_id
	 * @param integer $period_id
	 * @return mixed
	 * @throws NotFoundHttpException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function actionNewsdata($news_id, $fintool_id, $period_id){

		if (($news = News::findOne($news_id)) === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		if (($fintool = FinTool::findOne($fintool_id)) === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		if (($period = Period::findOne($period_id)) === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		$model = new NewsData();

		$upload = new NewsDataUpload();

		if (Yii::$app->request->isPost){
			if(Yii::$app->request->post('upload', 0) == 0){
				if ($model->load(Yii::$app->request->post()) && $model->save()) {
					$model = new NewsData();
				}
			}else if(Yii::$app->request->post('upload', 0) == 1){

				$upload = $this->UploadNewsData($upload, $news_id, $fintool_id, $period_id);
			}
		}
		$model->news_id = $news_id;
		$model->fintool_id = $fintool_id;
		$model->period_id = $period_id;

		$query = NewsData::find()->thatnews($news_id, $fintool_id, $period_id);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder'=>['datetime'=> SORT_ASC],
			]
		]);

		return $this->render('newsdata', ['dataProvider' => $dataProvider, 'news' => $news, 'fintool' => $fintool, 'period' => $period, 'model' => $model, 'upload' => $upload]);
	}

	/**
	 * @param $nid integer news id
	 * @param $fid integer fintool id
	 * @param $pid integer period id
	 * @return \yii\web\Response
	 */
	public function actionNewsDataJson($nid, $fid, $pid){

		$newsdatas = [];

		if(isset($nid) && is_numeric($nid) && isset($fid) && is_numeric($fid) && isset($pid) && is_numeric($pid)){
			$newsdatas = NewsData::find()->thatnews($nid, $fid, $pid)->orderBy('datetime')->all();
		}
		return $this->asJson($newsdatas);
	}

	/**
	 * @param $id
	 * @return \yii\web\Response
	 * @throws NotFoundHttpException
	 */
	public function actionNewsdatadel($id){

		if (($model = NewsData::findOne($id)) !== null) {
			$model->delete();
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		return $this->redirect(['newsdata', 'news_id' => $model->news_id, 'fintool_id' => $model->fintool_id, 'period_id' => $model->period_id]);
	}

	/**
	 * @param $news_id
	 * @param $fintool_id
	 * @param $period_id
	 * @return \yii\web\Response
	 */
	public function actionNewsdatadelall($news_id, $fintool_id, $period_id){

		NewsData::deleteAll(
			'news_id=:news_id AND fintool_id=:fintool_id AND period_id=:period_id',
			[':news_id' => $news_id, ':fintool_id' => $fintool_id, ':period_id' => $period_id]
		);

		return $this->redirect(['update', 'id' => $news_id]);
	}

	public function actionWidget(){

		return $this->render('widget');
	}

	/**
	 * Finds the News model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return News the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = News::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * @param $upload NewsDataUpload
	 * @param $news_id integer
	 * @param $fintool_id integer
	 * @param $period_id integer
	 * @return NewsDataUpload
	 * @throws \Exception
	 * @throws \Throwable
	 */
	protected function UploadNewsData($upload, $news_id, $fintool_id, $period_id): NewsDataUpload
	{
		$upload->dataFile = UploadedFile::getInstance($upload, 'dataFile');
		if ($upload->upload()) {
			$handler = fopen($upload->dataFile->tempName, 'r');
			/**
			 * @var NewsData[]
			 */
			$newsDates = [];
			$lineNumber = 1;
			while (($line = fgetcsv($handler, 0, ',')) !== false) {

				$newsData = new NewsData();
				$newsData->news_id = $news_id;
				$newsData->fintool_id = $fintool_id;
				$newsData->period_id = $period_id;

				$exp_date = explode('.', $line[0]);

				if (!is_array($exp_date) || count($exp_date) < 3) {
					$upload->addError('dataFile', 'Ошибка формата данных. Строка #:' . $lineNumber);
					$upload->addError('dataFile', 'Формат даты не верен:' . $line[0]);
					break;
				}

				$newsData->datetime = $exp_date[2] . '.' . $exp_date[1] . '.' . $exp_date[0] . ' ' . $line[1];
				$newsData->open = $line[2];
				$newsData->max = $line[3];
				$newsData->min = $line[4];
				$newsData->close = $line[5];

				if ($newsData->validate(['datetime', 'open', 'max', 'min', 'close'])) {
					$newsDates[] = $newsData;
				} else {
					$upload->addError('dataFile', 'Ошибка формата данных. Строка #:' . $lineNumber);
					foreach ($newsData->getErrors() as $error) {
						$upload->addError('dataFile', implode(';', $error));
					}
					break;
				}
				$lineNumber++;
			}
			if (!$upload->hasErrors() && count($newsDates) <= 0) {
				$upload->addError('dataFile', 'Файл не содержит данных');
			} else {

				$transaction = NewsData::getDb()->beginTransaction();
				try {
					NewsData::deleteAll(
						'news_id=:news_id AND fintool_id=:fintool_id AND period_id=:period_id',
						[':news_id' => $news_id, ':fintool_id' => $fintool_id, ':period_id' => $period_id]
					);

					$postModel = new NewsData;
					$rows = ArrayHelper::getColumn($newsDates, 'attributes');
					Yii::$app->db->createCommand()->batchInsert(NewsData::tableName(), $postModel->attributes(), $rows)->execute();

//							foreach ($newsDates as $newsData){
//								if(!$newsData->save(false)){
//									foreach ($newsData->getErrors() as $error) {
//										$upload->addError('dataFile', implode(';', $error));
//									}
//									break;
//								}
//							}
					$transaction->commit();
				} catch (\Exception $e) {
					$transaction->rollBack();
					throw $e;
				} catch (\Throwable $e) {
					$transaction->rollBack();
					throw $e;
				}
			}
			fclose($handler);
		}
		return $upload;
	}
}
