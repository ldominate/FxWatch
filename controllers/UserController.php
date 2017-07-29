<?php

namespace app\controllers;

use app\models\form\SetUser;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;
use app\models\form\Login;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\searchs\User as UserSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class UserController extends Controller
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
                    'logout' => ['post'],
	                'delete' => ['post']
                ],
            ]
        ];
    }

	/**
	 * Lists all User models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new UserSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Login
	 * @return string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->getUser()->isGuest) {
			return $this->goHome();
		}

		$model = new Login();
		if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
			return $this->goBack();
		} else {
			$this->layout = 'sba2-login';
			return $this->render('login-sba2', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Logout
	 * @return string
	 */
	public function actionLogout()
	{
		Yii::$app->getUser()->logout();

		return $this->goHome();
	}

	public function actionAdd(){

		$model = new SetUser(new User(), ['scenario' => SetUser::SCENARIO_ADD]);

		if($model->load(Yii::$app->getRequest()->post()) && $model->set()) {
			return $this->redirect(Url::to(['user/index']));
		}else{
			return $this->render('add', ['model' => $model]);
		}
	}

	public function actionUpdate($id){

		$user =$this->findModel($id);

		$model = new SetUser($user);

		if($model->load(Yii::$app->getRequest()->post()) && $model->set()){
			return $this->redirect(Url::to(['user/index']));
		}

		return $this->render('update', ['model' => $model]);
	}

	public function actionDelete($id){

		if(Yii::$app->getUser()->getId() == $id){
			throw new ForbiddenHttpException('Невозможно удалить пользователя текущей сессии.');
		}
		$this->findModel($id)->delete();

		return $this->redirect(Url::to(['user/index']));
	}

	/**
	 * Finds the User model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return User the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = User::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}