<?php

namespace app\modules\finam\controllers;

use app\modules\catalog\models\SourceCode;
use app\modules\catalog\models\SourceType;
use Yii;
use app\modules\finam\models\FinData;
use app\modules\finam\models\FinDataSearch;
use yii\db\Query;
use yii\filters\Cors;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinDataController implements the CRUD actions for FinData model.
 */
class FinDataController extends Controller
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
                ],
            ],
	        'access' => [
		        'class' => yii\filters\AccessControl::className(),
		        'only' => ['tools', 'data'],
		        'rules' => [
			        [
				        'allow' => true,
				        'actions' => ['tools', 'data'],
				        'roles' => ['?'],
			        ],
			        [
				        'allow' => true,
				        'actions' => ['tools', 'data'],
				        'roles' => ['@'],
			        ],
		        ],
	        ],
	        'corsFilter'  => [
		        'class' => Cors::className(),
		        'cors'  => [
			        // restrict access to domains:
			        'Origin'                           => \app\modules\news\controllers\DefaultController::allowedDomains(),
			        'Access-Control-Request-Method'    => ['GET'],
			        'Access-Control-Allow-Credentials' => true,
			        'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
		        ],
	        ]
        ];
    }

    /**
     * Lists all FinData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinData model.
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
     * Creates a new FinData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FinData model.
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
	 * @param $s integer Time stamp
	 * @param $t integer Source type
	 * @param $c string Source code
	 * @return \yii\web\Response
	 */
    public function actionTools($s, $t, $c = null){

    	if(!isset($s) || !is_numeric($s)){
		    $s = time();
	    }

	    $current_str_date = Yii::$app->formatter->asDate($s, FinData::DATE_FORMAT_DB);
//	    $current_start_date = $current_str_date.' 00:00:00';
//	    $current_end_date = $current_str_date.' 23:59:59';

	    $subGroup = (new Query())
		    ->select([
			    'sourcecode.code',
			    'MIN(`findata`.`datetime`) AS minFin',
			    'MAX(`findata`.`datetime`) AS maxFin'
		    ])
		    ->from(SourceCode::tableName())
		    ->leftJoin('findata', '`findata`.`sourcecode_code` = `sourcecode`.`code`')
		    ->andWhere('`findata`.`datetime` between CONCAT("'.$current_str_date.'", " ", `sourcecode`.`open`) AND CONCAT("'.$current_str_date.'", " ", `sourcecode`.`close`)')
		    ->groupBy('`sourcecode`.code');

	    $query = (new Query())
		    ->select([
			    'sourcetype.type',
			    'sourcecode.code',
			    'sourcecode.name',
			    'CONCAT(DATE_FORMAT(findata.datetime, "%Y-%m-%d"), "T", sourcecode.open, "+00:00") AS code_open',
			    'CONCAT(DATE_FORMAT(findata.datetime, "%Y-%m-%d"), "T", sourcecode.close, "+00:00") AS code_close',
			    'findata.id',
			    'DATE_FORMAT(findata.datetime, "%Y-%m-%dT%T+00:00") AS datetime',
			    'findata.open',
			    'findata.max',
			    'findata.min',
			    'findata.close',
			    'findata.vol',
			    'UNIX_TIMESTAMP(findata.datetime) AS stamp'])
		    ->from(SourceCode::tableName())
		    ->innerJoin('sourcetype', '`sourcetype`.`id` = `sourcecode`.`sourcetype_id`')
		    ->leftJoin('findata', '`findata`.`sourcecode_code` = `sourcecode`.`code` AND `findata`.`datetime` between CONCAT("'.$current_str_date.'", " ", `sourcecode`.`open`) AND CONCAT("'.$current_str_date.'", " ", `sourcecode`.`close`)')
		    ->leftJoin(['gFin' => $subGroup], '`gFin`.`code` = `sourcecode`.`code`')
		    ->andWhere('`gFin`.`minFin` = `findata`.`datetime`')
		    ->orWhere('`gFin`.`maxFin` = `findata`.`datetime`')
		    ->orWhere(['and', 'ISNULL(`gFin`.`maxFin`)', 'ISNULL(`gFin`.`minFin`)'])
		    ->orderBy(['`sourcecode`.`code`' => SORT_ASC, 'stamp' => SORT_ASC]);

	    if(isset($t) && in_array($t, [SourceType::CURRENCY_PAIRS, SourceType::FINANCIAL_INSTRUMENTS])){
	    	$query->andWhere(['=', 'sourcetype.type', $t]);
	    }

	    if(isset($c) && !empty($c) && strlen($c) < 15){
	    	$query->andWhere(['=', 'sourcecode.code', $c]);
	    }

	    $finDataDb = $query->all();

	    $codes = [];

	    foreach ($finDataDb as $finData){
		    if(array_key_exists($finData['code'], $codes)){
			    $code = $codes[$finData['code']];

			    $codes[$finData['code']]['datetime'] = $finData['datetime'];
			    $codes[$finData['code']]['change'] = $finData['max'] - $code['change'];
			    $codes[$finData['code']]['percent'] = ($code['percent'] == 0.0 ? $finData['max'] : ($finData['max'] - $code['percent']) / $code['percent']) * 100.0;
			    $codes[$finData['code']]['stamp'] = $finData['stamp'];
			    $codes[$finData['code']]['max'] = floatval($finData['max']);
		    }else{
			    $codes[$finData['code']] = [
				    'code' => $finData['code'],
				    'name' => $finData['name'],
				    'datetime' => $finData['datetime'],
				    'max' => floatval($finData['max']),
				    'change' => $finData['open'],
				    'percent' => $finData['open'],
				    'stamp' => $finData['stamp'],
				    'open' => $finData['code_open'],
				    'close' => $finData['code_close']
			    ];
		    }
	    }
	    return $this->asJson(array_values($codes));
    }

	/**
	 * @param $c string Source code
	 * @param $s integer Time stamp
	 * @return \yii\web\Response
	 */
    public function actionData($c, $s){

	    if(!isset($s) || !is_numeric($s)){
		    $s = time();
	    }

	    if(!isset($c) || strlen($c) <= 0 || strlen($c) > 15){
		    return $this->asJson(null);
	    }

	    $current_str_date = Yii::$app->formatter->asDate($s, FinData::DATE_FORMAT_DB);
	    $current_start_date = $current_str_date.' 00:00:00';
	    $current_end_date = $current_str_date.' 23:59:59';

	    $query = FinData::find()
		    ->select([
		    	'findata.*',
			    'DATE_FORMAT(findata.datetime, \'%Y-%m-%dT%T+00:00\') AS datetime'
		    ])
		    ->innerJoin('sourcecode', '`sourcecode`.`code` = `findata`.`sourcecode_code`')
		    ->where(['=', 'sourcecode_code', $c])
		    ->andWhere('datetime between CONCAT("'.$current_str_date.'", " ", `sourcecode`.`open`) AND CONCAT("'.$current_str_date.'", " ", `sourcecode`.`close`)')
		    //->andWhere('datetime between DATE_SUB("'.$current_start_date.'", INTERVAL 10 DAY) AND "'.$current_end_date.'"')
		    ->orderBy(['sourcecode_code' => SORT_ASC, 'datetime' => SORT_ASC])
	        ->asArray();

	    $data = $query->all();

    	return $this->asJson($data);
    }

    /**
     * Finds the FinData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
