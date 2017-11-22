<?php

namespace app\controllers;

use app\modules\catalog\models\SourceCode;
use app\modules\finam\components\FinamProvider;
use app\modules\finam\models\FinamSettings;
use Yii;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                //'only' => ['logout', 'index', 'contact', 'about', 'login'],
//                'rules' => [
//                    [
//                        'actions' => ['logout', 'index', 'contact', 'about'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//	                [
//	                	'actions' => ['login'],
//		                'allow' => true,
//	                    'roles' => ['?'],
//	                ]
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ]
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
	    $sources = SourceCode::find()->select('code')->column();

	    $finamSettings = FinamSettings::find()->where(['in', 'sourcecode_code', $sources])->indexBy('sourcecode_code')->all();

	    shuffle($finamSettings);

	    $result = [];

	    $dateGet = date('d.m.Y');

//	    foreach ($finamSettings as $finamSetting){
//
//		    $provider = new FinamProvider($finamSetting);
//
//		    if($provider->requestSource($dateGet)) {
//
//			    $provider->saveNewFinData();
//
//		    } else {
//			    //$result[$finamSettingsEurUsd->sourcecode_code] = $provider->getLogs();
//		    }
//		    $result[$finamSetting->sourcecode_code] = $provider->getLogs();
//
//	    	sleep(rand(10, 30));
//	    }

//    	$finamSettingsEurUsd = FinamSettings::find()->with('sourceCode')->where(['sourcecode_code' => 'USDRUB', 'market' => 5])->limit(1)->one();
//
//    	$provider = new FinamProvider($finamSettingsEurUsd);
//
//	    if($provider->requestSource('17.11.2017 7:00:00', '17.11.2017 23:00:00')) {
//
//	    	$provider->saveNewFinData();
//
//	    } else {
//	    	//$result[$finamSettingsEurUsd->sourcecode_code] = $provider->getLogs();
//	    }
//	    $result[$finamSettingsEurUsd->sourcecode_code] = $provider->getLogs();
	    //$result['min'] = $provider->getMinDateTimeFinData()->getAttributes();
	    //$result['max'] = $provider->getMaxDateTimeFinData()->getAttributes();
		//$attributes = $finamSettingsEurUsd->initAttributes(date('d.m.Y'));
//	    $attributes = $finamSettingsEurUsd->initAttributes('17.11.2017');
//
//		$client = new Client();
//
//		/** @var $finamResponse yii\httpclient\Response */
//	    $finamResponse = $client->createRequest()
//			->setMethod('get')
//			->setUrl($finamSettingsEurUsd->url)
//			->setData($attributes)
//			->send();
//
//	    $result = [];
//	    if($finamResponse->getIsOk()){
//		    $result = str_getcsv($finamResponse->getContent(), "\n");
//	    }

        return $this->render('index', [
	        'result' => $result
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
