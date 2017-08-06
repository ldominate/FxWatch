<?php

namespace app\modules\News\controllers;

use app\modules\catalog\models\FinTool;
use app\modules\catalog\models\Period;
use app\modules\news\models\NewsData;
use Yii;
use app\modules\news\models\News;
use app\modules\news\models\NewsSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Default controller for the `News` module
 */
class DefaultController extends Controller
{
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
				$model->fact = $model->forecast = $model->deviation = $model->previous = 0.0;
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

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
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

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model = new NewsData();
		}

		$model->news_id = $news_id;
		$model->fintool_id = $fintool_id;
		$model->period_id = $period_id;

		$query = NewsData::find()->thatnews($news_id, $fintool_id, $period_id);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => false
		]);

		return $this->render('newsdata', ['dataProvider' => $dataProvider, 'news' => $news, 'fintool' => $fintool, 'period' => $period, 'model' => $model]);
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
}
