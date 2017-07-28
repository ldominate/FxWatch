<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\models\form\Login;
use yii\web\Controller;
use app\models\searchs\User as UserSearch;

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
}