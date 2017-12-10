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

	    $subGroup = (new Query())
		    ->select([
		    	'sourcecode.code',
			    'MIN(`findata`.`datetime`) AS minFin',
			    'MAX(`findata`.`datetime`) AS maxFin'
		    ])
		    ->from(SourceCode::tableName())
		    ->leftJoin('findata', '`findata`.`sourcecode_code` = `sourcecode`.`code`')
		    ->andWhere(['between', '`findata`.`datetime`', $current_start_date, $current_end_date])
		    ->groupBy('`sourcecode`.code');

    	$query = (new Query())
		    ->select([
			        'sourcetype.type',
		    	    'sourcecode.code',
			        'sourcecode.name',
				    'findata.id',
				    'DATE_FORMAT(findata.datetime, \'%Y-%m-%dT%TZ\') AS datetime',
				    'findata.open',
				    'findata.max',
				    'findata.min',
				    'findata.close',
				    'findata.vol',
			        'UNIX_TIMESTAMP(findata.datetime) AS stamp'])
		    ->from(SourceCode::tableName())
		    ->innerJoin('sourcetype', '`sourcetype`.`id` = `sourcecode`.`sourcetype_id`')
		    ->leftJoin('findata', '`findata`.`sourcecode_code` = `sourcecode`.`code` AND `findata`.`datetime` between \''.$current_start_date.'\' AND \''.$current_end_date.'\'')
		    ->leftJoin(['gFin' => $subGroup], '`gFin`.`code` = `sourcecode`.`code`')
		    ->andWhere('`gFin`.`minFin` = `findata`.`datetime`')
		    ->orWhere('`gFin`.`maxFin` = `findata`.`datetime`')
		    ->orWhere(['and', 'ISNULL(`gFin`.`maxFin`)', 'ISNULL(`gFin`.`minFin`)'])
	        ->orderBy(['`sourcecode`.`code`' => SORT_ASC, 'stamp' => SORT_ASC]);

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
