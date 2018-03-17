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

	const CORRECT_TIMEZONE = 36000;
	
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

	    //$current_date_time = new \DateTime('12.03.2018');
	    $current_date_time = new \DateTime('midnight');
	    $current_u_time = $current_date_time->getTimestamp() - self::CORRECT_TIMEZONE;
	    $current_str_date = $current_date_time->format('Y-m-d');
	    //$yesterday_date_time = new \DateTime('11.03.2018');
	    $yesterday_date_time = new \DateTime('yesterday');
	    $yesterday_u_time = $yesterday_date_time->getTimestamp() - self::CORRECT_TIMEZONE;
	    $yesterday_str_date = $yesterday_date_time->format('Y-m-d');

	    $sourceSql = (new Query())
		    ->select(['code', '`sourcecode`.`name`', 'open', 'close',
			    'CONCAT(IF(open >= close, "'.$yesterday_str_date.'", "'.$current_str_date.'"), "T", open, "+00:00") AS code_open',
			    'CONCAT("'.$current_str_date.'", "T", close, "+00:00") AS code_close',
			    'TIME_TO_SEC(open) AS uOpen',
			    'TIME_TO_SEC(close) AS uClose'
		    ])
		    ->innerJoin('sourcetype', '`sourcetype`.`id` = `sourcecode`.`sourcetype_id`')
		    ->from(SourceCode::tableName())
	        ->indexBy('code')
		    ->orderBy(['code' => SORT_ASC]);

	    if(isset($t) && in_array($t, [SourceType::CURRENCY_PAIRS, SourceType::FINANCIAL_INSTRUMENTS])){
		    $sourceSql->andWhere(['=', 'sourcetype.type', $t]);
	    }

    	$sources = $sourceSql->all();

    	$sourcesCode = array_keys($sources);

    	$findataSql = (new Query())
		    ->select(['id', 'sourcecode_code',
			    'DATE_FORMAT(findata.datetime, "%Y-%m-%dT%T+00:00") AS datetime',
			    'open', 'max', 'min', 'close', 'vol',
				'EXTRACT(HOUR_SECOND FROM datetime) AS sTime',
			    'UNIX_TIMESTAMP(datetime) AS uTime'
		    ])
		    ->from(FinData::tableName())
		    ->where(['in', 'sourcecode_code', $sourcesCode])
		    ->andWhere('datetime between DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')
		    //->andWhere('datetime between DATE_SUB("'.$current_str_date.' 23:59:59", INTERVAL 7 DAY) AND "'.$current_str_date.' 23:59:59"')
		    ->orderBy(['sourcecode_code' => SORT_ASC, 'datetime' => SORT_DESC]);

    	$findatas = $findataSql->all();

	    $codes = [];

	    foreach ($sources as $code => $source){
		    $codes[$code] = [
			    'code' => $source['code'],
			    'name' => $source['name'],
			    'datetime' => null,
			    'max' => null,
			    'change' => null,
			    'percent' => null,
			    'stamp' => null,
			    'open' => $source['code_open'],
			    'open_stamp' => $source['uOpen'] >= $source['uClose']
				    ? $yesterday_u_time + $source['uOpen']
				    : $current_u_time + $source['uOpen'],
			    'close' => $source['code_close'],
			    'close_stamp' => $yesterday_u_time + $source['uClose'],
			    'ids' => ''
		    ];
	    }
	    $cur_code = null;
	    $search_close = false;
	    $next_code = false;
	    foreach ($findatas as $findata){
	    	if($cur_code != $findata['sourcecode_code']){
	    		if($findata['uTime'] <= $codes[$findata['sourcecode_code']]['open_stamp']){
	    			$next_code = true;
	    			continue;
			    }
			    if($search_close){
	    			$codes[$cur_code]['datetime'] = null;
				    $codes[$cur_code]['percent'] = null;
				    $codes[$cur_code]['max'] = null;
				    $codes[$cur_code]['stamp'] = null;
			    }
			    $cur_code = $findata['sourcecode_code'];
			    $codes[$cur_code]['datetime'] = $findata['datetime'];
			    $codes[$cur_code]['max'] = floatval($findata['close']);
			    $codes[$cur_code]['change'] = $findata['close'];
			    $codes[$cur_code]['percent'] = $findata['close'];
			    $codes[$cur_code]['stamp'] = $findata['uTime'];
			    $codes[$cur_code]['open'] = $sources[$findata['sourcecode_code']]['code_open'];
			    $codes[$cur_code]['close'] = $sources[$findata['sourcecode_code']]['code_close'];
			    $codes[$cur_code]['ids'] = $findata['id'].',';

	    		$next_code = false;
			    $search_close = true;
		    }else{
				if($next_code) continue;
				if($findata['uTime'] <= $codes[$cur_code]['close_stamp']){

					$codes[$cur_code]['change'] = $codes[$cur_code]['change'] - $findata['close'];
					$codes[$cur_code]['percent'] = ($findata['close'] == 0.0 ? $codes[$cur_code]['percent'] : ($codes[$cur_code]['percent'] - $findata['close']) / $findata['close']) * 100.0;
					$codes[$cur_code]['ids'] .= $findata['id'];
					//$codes[$cur_code]['uTime'] = $findata['uTime'];

					$search_close = false;
					$next_code = true;
				}
		    }
	    }
	    return $this->asJson(array_values($codes));
    }

	/**
	 * @param $t integer
	 * @param null $d string
	 * @return \yii\web\Response
	 */
    public function actionToolsV2($t, $d = null){

	    $current_date_time = new \DateTime(empty($d) ? 'midnight' : $d);
	    //$current_date_time = new \DateTime('midnight');
	    $current_u_time = $current_date_time->getTimestamp() - self::CORRECT_TIMEZONE;
	    $current_str_date = $current_date_time->format('Y-m-d');
	    $yesterday_date_time = $current_date_time->add(\DateInterval::createFromDateString('yesterday'));
	    //$yesterday_date_time = new \DateTime('yesterday');
	    $yesterday_u_time = $yesterday_date_time->getTimestamp() - self::CORRECT_TIMEZONE;
	    $yesterday_str_date = $yesterday_date_time->format('Y-m-d');

	    $sourceSql = (new Query())
		    ->select(['code', '`sourcecode`.`name`', 'open', 'close',
			    'CONCAT(IF(open >= close, "'.$yesterday_str_date.'", "'.$current_str_date.'"), "T", open, "+00:00") AS code_open',
			    'CONCAT("'.$current_str_date.'", "T", close, "+00:00") AS code_close',
			    'TIME_TO_SEC(open) AS uOpen',
			    'TIME_TO_SEC(close) AS uClose'
		    ])
		    ->innerJoin('sourcetype', '`sourcetype`.`id` = `sourcecode`.`sourcetype_id`')
		    ->from(SourceCode::tableName())
		    ->indexBy('code')
		    ->orderBy(['code' => SORT_ASC]);

	    if(isset($t) && in_array($t, [SourceType::CURRENCY_PAIRS, SourceType::FINANCIAL_INSTRUMENTS])){
		    $sourceSql->andWhere(['=', 'sourcetype.type', $t]);
	    }

	    $sources = $sourceSql->all();

	    $sourcesCode = array_keys($sources);

	    $findataSql = (new Query())
		    ->select(['id', 'sourcecode_code',
			    'DATE_FORMAT(findata.datetime, "%Y-%m-%dT%T+00:00") AS datetime',
			    'open', 'max', 'min', 'close', 'vol',
			    'EXTRACT(HOUR_SECOND FROM datetime) AS sTime',
			    'UNIX_TIMESTAMP(datetime) AS uTime'
		    ])
		    ->from(FinData::tableName())
		    ->where(['in', 'sourcecode_code', $sourcesCode])
		    //->andWhere('datetime between DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')
		    ->andWhere('datetime between DATE_SUB("'.$current_str_date.' 23:59:59", INTERVAL 7 DAY) AND "'.$current_str_date.' 23:59:59"')
		    ->orderBy(['sourcecode_code' => SORT_ASC, 'datetime' => SORT_DESC]);

	    $findatas = $findataSql->all();

	    //return $this->asJson($findatas);

	    $codes = [];

	    foreach ($sources as $code => $source){
		    $codes[$code] = [
			    'code' => $source['code'],
			    'name' => $source['name'],
			    'datetime' => null,
			    'max' => 0,
			    'change' => null,
			    'percent' => null,
			    'stamp' => null,
			    'open' => $source['code_open'],
			    'open_stamp' => $source['uOpen'] >= $source['uClose']
				    ? $yesterday_u_time + $source['uOpen']
				    : $current_u_time + $source['uOpen'],
			    'close' => $source['code_close'],
			    'close_stamp' => $yesterday_u_time + $source['uClose'],
			    'ids' => ''
		    ];
	    }
	    $cur_code = null;
	    $search_close = false;
	    $next_code = false;
	    foreach ($findatas as $findata){
		    if($cur_code != $findata['sourcecode_code']){
			    if($findata['uTime'] <= $codes[$findata['sourcecode_code']]['open_stamp']){
				    $next_code = true;
				    continue;
			    }
			    if($search_close){
				    $codes[$cur_code]['datetime'] = null;
				    $codes[$cur_code]['percent'] = null;
				    $codes[$cur_code]['max'] = null;
				    $codes[$cur_code]['stamp'] = null;
			    }
			    $cur_code = $findata['sourcecode_code'];
			    $codes[$cur_code]['datetime'] = $findata['datetime'];
			    $codes[$cur_code]['max'] = floatval($findata['close']);
			    $codes[$cur_code]['change'] = $findata['close'];
			    $codes[$cur_code]['percent'] = $findata['close'];
			    $codes[$cur_code]['stamp'] = $findata['uTime'];
			    $codes[$cur_code]['open'] = $sources[$findata['sourcecode_code']]['code_open'];
			    $codes[$cur_code]['close'] = $sources[$findata['sourcecode_code']]['code_close'];
			    $codes[$cur_code]['ids'] = $findata['id'].',';

			    $next_code = false;
			    $search_close = true;
		    }else{
			    if($next_code) continue;
			    if($findata['uTime'] <= $codes[$cur_code]['close_stamp']){

				    $codes[$cur_code]['change'] = $codes[$cur_code]['change'] - $findata['close'];
				    $codes[$cur_code]['percent'] = ($findata['close'] == 0.0 ? $codes[$cur_code]['percent'] : ($codes[$cur_code]['percent'] - $findata['close']) / $findata['close']) * 100.0;
				    $codes[$cur_code]['ids'] .= $findata['id'];
				    //$codes[$cur_code]['uTime'] = $findata['uTime'];

				    $search_close = false;
				    $next_code = true;
			    }
		    }
	    }
	    return $this->asJson($codes);
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

	    //$current_str_date = Yii::$app->formatter->asDate($s, FinData::DATE_FORMAT_DB);
	    $current_str_date = Yii::$app->formatter->asDate(time(), FinData::DATE_FORMAT_DB);
	    $yesterday_str_date = Yii::$app->formatter->asDate(strtotime('yesterday'), FinData::DATE_FORMAT_DB);
//	    $current_start_date = $current_str_date.' 00:00:00';
//	    $current_end_date = $current_str_date.' 23:59:59';

	    $query = FinData::find()
		    ->select([
		    	'findata.*',
			    'DATE_FORMAT(findata.datetime, \'%Y-%m-%dT%T+00:00\') AS datetime'
		    ])
		    ->innerJoin('sourcecode', '`sourcecode`.`code` = `findata`.`sourcecode_code`')
		    ->where(['=', 'sourcecode_code', $c])
		    ->andWhere('datetime between CONCAT(IF(`sourcecode`.`open` >= `sourcecode`.`close`, "'.$yesterday_str_date.'", "'.$current_str_date.'"), " ", `sourcecode`.`open`) AND CONCAT("'.$current_str_date.'", " ", `sourcecode`.`close`)')
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
