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

	    $current_date_time = new \DateTime('12.03.2018');
	    //$current_date_time = new \DateTime('midnight');
	    $current_u_time = $current_date_time->getTimestamp() - 36000;
	    $current_str_date = $current_date_time->format('Y-m-d');
	    $yesterday_date_time = new \DateTime('11.03.2018');
	    //$yesterday_date_time = new \DateTime('yesterday');
	    $yesterday_u_time = $yesterday_date_time->getTimestamp() - 36000;
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
	    		if($findata['uTime'] < $codes[$findata['sourcecode_code']]['open_stamp']){
	    			$next_code = true;
	    			continue;
			    }
			    if($search_close){
	    			$codes[$cur_code]['datetime'] = null;
				    $codes[$cur_code]['percent'] = null;
				    $codes[$cur_code]['max'] = 0;
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
					$codes[$cur_code]['uTime'] = $findata['uTime'];

					$search_close = false;
					$next_code = true;
				}
		    }
	    }

	    return $this->asJson($codes);


	    //$current_str_date = Yii::$app->formatter->asDate($s, FinData::DATE_FORMAT_DB);
	    $current_str_date = Yii::$app->formatter->asDate(time(), FinData::DATE_FORMAT_DB);
    	$yesterday_str_date = Yii::$app->formatter->asDate(strtotime('yesterday'), FinData::DATE_FORMAT_DB);
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
		    //->andWhere('`findata`.`datetime` between CONCAT(IF(`sourcecode`.`open` >= `sourcecode`.`close`, "'.$yesterday_str_date.'", "'.$current_str_date.'"), " ", `sourcecode`.`open`) AND CONCAT("'.$current_str_date.'", " ", `sourcecode`.`close`)')
		    ->andWhere('`findata`.`datetime` between CONCAT("'.$yesterday_str_date.'", " ", `sourcecode`.`close`) AND CONCAT("'.$current_str_date.'", " ", `sourcecode`.`close`)')
		    ->groupBy('`sourcecode`.code');

	    $superSubGroup = (new Query())
		    ->select([
		    	'subGfin.code',
			    'subGfin.minFin',
			    'IF(
					UNIX_TIMESTAMP(subGfin.maxFin) > UNIX_TIMESTAMP("'.$current_str_date.' 00:00:00"),
					subGfin.maxFin,
					NULL
					) AS maxFin'
		    ])->from(['subGfin' => $subGroup]);

	    $query = (new Query())
		    ->select([
			    'sourcetype.type',
			    'sourcecode.code',
			    'sourcecode.name',
			    'CONCAT(DATE_FORMAT(IF(`sourcecode`.`open` >= `sourcecode`.`close`, "'.$yesterday_str_date.'", "'.$current_str_date.'"), "%Y-%m-%d"), "T", `sourcecode`.`open`, "+00:00") AS code_open',
			    //'CONCAT(DATE_FORMAT("'.$yesterday_str_date.'", "%Y-%m-%d"), "T", `sourcecode`.`close`, "+00:00") AS code_open',
			    'CONCAT(DATE_FORMAT("'.$current_str_date.'", "%Y-%m-%d"), "T", `sourcecode`.`close`, "+00:00") AS code_close',
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
		    //->leftJoin('findata', '`findata`.`sourcecode_code` = `sourcecode`.`code` AND `findata`.`datetime` between CONCAT(IF(`sourcecode`.`open` >= `sourcecode`.`close`, "'.$yesterday_str_date.'", "'.$current_str_date.'"), " ", `sourcecode`.`open`) AND CONCAT("'.$current_str_date.'", " ", `sourcecode`.`close`)')
		    ->leftJoin('findata', '`findata`.`sourcecode_code` = `sourcecode`.`code` AND `findata`.`datetime` between CONCAT("'.$yesterday_str_date.'", " ", `sourcecode`.`close`) AND CONCAT("'.$current_str_date.'", " ", `sourcecode`.`close`)')
		    ->leftJoin(['gFin' => $superSubGroup], '`gFin`.`code` = `sourcecode`.`code`')
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
		$cc = [];
	    foreach ($finDataDb as $finData){
		    if(array_key_exists($finData['code'], $codes)){
			    $code = $codes[$finData['code']];
				$c = $cc[$finData['code']];
			    $codes[$finData['code']]['datetime'] = $finData['datetime'];
			    $codes[$finData['code']]['change'] = $finData['close'] - $c['change'];
			    $codes[$finData['code']]['percent'] = ($c['percent'] == 0.0 ? $finData['close'] : ($finData['close'] - $c['percent']) / $c['percent']) * 100.0;
			    $codes[$finData['code']]['stamp'] = $finData['stamp'];
			    $codes[$finData['code']]['max'] = floatval($finData['close']);
			    $codes[$finData['code']]['close'] = $finData['code_close'];
			    $codes[$finData['code']]['ids'] .= $finData['id'];
		    }else{
			    $codes[$finData['code']] = [
				    'code' => $finData['code'],
				    'name' => $finData['name'],
				    'datetime' => null,//$finData['datetime'],
				    'max' => 0,//floatval($finData['close']),
				    'change' => null,
				    'percent' => null,
				    'stamp' => $finData['stamp'],
				    'open' => $finData['code_open'],
				    'close' => $finData['code_close'],
				    'ids' => $finData['id'].','
			    ];
			    $cc[$finData['code']] = [
				    'change' => $finData['close'],
				    'percent' => $finData['close'],
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
