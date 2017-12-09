<?php

namespace app\modules\finam\controllers;

use app\modules\catalog\models\SourceCode;
use app\modules\catalog\models\SourceType;
use app\modules\finam\models\FinData;
use Yii;
use yii\db\Query;
use yii\web\Controller;

/**
 * Default controller for the `finam` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionWidget()
    {
    	$current_date = strtotime('06.12.2017 11:23:34');

    	$current_str_date = Yii::$app->formatter->asDate($current_date, FinData::DATE_FORMAT_DB);
    	$current_start_date = $current_str_date.' 00:00:00';
		$current_end_date = $current_str_date.' 23:59:59';

    	//$query = SourceCode::find();

    	$finDataMinDay = FinData::find()
		    ->select('MIN(datetime)')
		    ->andWhere(['between', 'datetime',
			    $current_start_date, $current_end_date])
		    ->andWhere('sourcecode_code = `sourcecode`.`code`');

	    $finDataMaxDay = FinData::find()
		    ->select('MAX(datetime)')
		    ->andWhere(['between', 'datetime',
			    $current_start_date, $current_end_date])
		    ->andWhere('sourcecode_code = `sourcecode`.`code`');

    	$query = (new Query())
		    ->select('sourcecode.*, findata.*, UNIX_TIMESTAMP(findata.datetime) AS stamp')
		    ->from(SourceCode::tableName())
		    //->with('sourceType')
		    ->innerJoin('sourcetype', '`sourcetype`.`id` = `sourcecode`.`sourcetype_id`')
		    ->leftJoin('findata', '`findata`.`sourcecode_code` = `sourcecode`.`code`')
		    ->andWhere(['=', '`findata`.`datetime`', $finDataMinDay])
		    ->orWhere(['=', '`findata`.`datetime`', $finDataMaxDay]);
	        //->limit(10);

    	$datas = $query->all();

	    $result = [];

		$result['strtotime'] = $current_date;
		$result['date'] = date('c', $current_date);
	    $result['current_start_date'] = $current_start_date;
		$result['datas'] = $datas;

    	return $this->render('widget', [
		    'result' => $result
	    ]);
	}
}
