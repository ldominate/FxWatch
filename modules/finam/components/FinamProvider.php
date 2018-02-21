<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 20.11.2017
 * Time: 20:51
 */
namespace app\modules\finam\components;

use app\modules\finam\models\FinamSettings;
use app\modules\finam\models\FinData;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\httpclient\Response;


class FinamProvider extends BaseObject
{
	/**
	 * @var FinamSettings
	 */
	private $_settings;

	/**
	 * @var Response
	 */
	private $_response;

	/**
	 * @var array
	 */
	private $_logs = [];

	/**
	 * @var FinData[]
	 */
	private $_finDatas = [];

	/**
	 * @var \DateTimeZone
	 */
	private $_timezone = null;

	public function __construct(FinamSettings $settings, array $config = [])
	{
		$this->_settings = $settings;

		$this->_timezone = new \DateTimeZone(date_default_timezone_get());

		parent::__construct($config);
	}

	public function getLogs(){
		return $this->_logs;
	}

	public function getFinDatas(){
		return $this->_finDatas;
	}

	/**
	 * @param string $date_from
	 * @param string|null $date_to
	 * @return array|bool
	 */
	public function requestSource($date_from, $date_to = null){

		if(empty($date_to)) $date_to = $date_from;

		$attributes = $this->_settings->initAttributes($date_from, $date_to);
		//$attributes = $this->_settings->initAttributes(date('d.m.Y'));

		$client = new Client();
		$request = $client->createRequest();
		$this->_response = $request
			->setMethod('get')
			->setUrl($this->_settings->url)
			->setData($attributes)
			->send();

		$this->_logs['fullUrl'] = $request->getFullUrl();

		if($this->_response->getIsOk()){
			$result = str_getcsv($this->_response->getContent(), "\n");

			if(!is_array($result) || count($result) <= 0){
				$this->_logs['result'] = 'Неверный формат полученных данных. Статус код: '.
					$this->_response->getStatusCode().
					'. Часть данных: '.substr($this->_response->getContent(), 0, 100);
				return false;
			}

			$this->_logs['input'] = 'Получено и распознано '.count($result).' строк данных';

			foreach ($result as $dataRow){

				$finData = FinData::createFinamData($dataRow);

				if($finData->hasErrors()){
					$this->_logs['errors'] = $finData->getErrors();
				} else {

					//$timeFinData = strtotime($finData->datetime);
					$timeFinData = (new \DateTime($finData->datetime.'+00:00', $this->_timezone))->getTimestamp();
					if(array_key_exists($timeFinData, $this->_finDatas)){
						$this->_logs['errors'] = 'С данной меткой времени данные уже были добавлены. Ветка: '.$finData->datetime;
					}else{
						$this->_finDatas[$timeFinData] = $finData;
					}
				}
				//$finDatas[] = $finData->getErrors();
				//$finDatas[] = $finData->getAttributes();
			}

			return count($this->_finDatas) > 0;
		} else {
			//Запрос неверный
			$this->_logs['result'] = 'Запрос не верен. Статус код: '.$this->_response->getStatusCode();
			return false;
		}

	}

	public function saveNewFinData(){

		$minFinData = $this->getMinDateTimeFinData();
		$maxFinData = $this->getMaxDateTimeFinData();

//		$finDataDb = FinData::find()
//			->select(['id',
//				'sourcecode_code',
//				'DATE_FORMAT(findata.datetime, "%Y-%m-%d %T+00:00") AS datetime',
//				'open',
//				'max',
//				'min',
//				'close',
//				'vol'])
//			->andWhere(['sourcecode_code' => $this->_settings->sourcecode_code])
//			->andWhere([
//				'between',
//				'datetime',
//				$minFinData->datetime,
//				$maxFinData->datetime
//				//Yii::$app->formatter->asDatetime($minFinData->datetime, FinData::DATETIME_FORMAT_DB),
//				//Yii::$app->formatter->asDatetime($maxFinData->datetime, FinData::DATETIME_FORMAT_DB)
//				])
//			->with('sourceCode')
//			->orderBy(['datetime' => SORT_ASC, 'id' => SORT_DESC])
//			->all();

		$query = FinData::find()
			->select(['id',
				'sourcecode_code',
				'DATE_FORMAT(findata.datetime, "%Y-%m-%d %T+00:00") AS datetime',
				'open',
				'max',
				'min',
				'close',
				'vol'])
			->andWhere(['sourcecode_code' => $this->_settings->sourcecode_code])
			->andWhere([
				'between',
				'datetime',
				$minFinData->datetime,
				$maxFinData->datetime
				//Yii::$app->formatter->asDatetime($minFinData->datetime, FinData::DATETIME_FORMAT_DB),
				//Yii::$app->formatter->asDatetime($maxFinData->datetime, FinData::DATETIME_FORMAT_DB)
			])
			->with('sourceCode')
			->orderBy(['datetime' => SORT_ASC, 'id' => SORT_DESC]);

		$finDataDb = $query->all();

		//$this->_logs['sqlExist'] = $query->createCommand()->getRawSql();

		$delDoubleIds = [];

		$finDateTimeDb = array_map(function($e){
			//return strtotime($e->datetime);
			return (new \DateTime($e->datetime, $this->_timezone))->getTimestamp();
		}, $finDataDb);

		/* @var $finDataDbi FinData[] */
		$finDataDbi = [];
		foreach ($finDataDb as $finData){
			//$tk = strtotime($finData->datetime);
			$tk = (new \DateTime($finData->datetime, $this->_timezone))->getTimestamp();
			if(array_key_exists($tk, $finDataDbi)) {
				$delDoubleIds[] = $finData->id;
			} else {
				$finDataDbi[$tk] = $finData;
			}
		}
//			ArrayHelper::map($finDataDb, 'id', 'datetime');
//			);

		$addFinDatas = [];
		/* @var $updateFinDatas FinData[] */
		$updateFinDatas = [];
		$delDateTimes = [];
		foreach ($this->_finDatas as $t => $finData){
			if(array_key_exists($t, $addFinDatas)) continue;
			if(in_array($t, $finDateTimeDb)){
				if(array_key_exists($t, $finDataDbi)){
					$db = $finDataDbi[$t];
					$is_change = false;
					$old = "dt: $db->datetime, open: $db->open, max: $db->max, min: $db->min, close: $db->close, vol: $db->vol";
					if($db->open != $finData->open) { $db->open = $finData->open; $is_change = true; }
					if($db->max != $finData->max) { $db->max = $finData->max; $is_change = true; }
					if($db->min != $finData->min) { $db->min = $finData->min; $is_change = true; }
					if($db->close != $finData->close) { $db->close = $finData->close; $is_change = true; }
					if($db->vol != $finData->vol) { $db->vol = $finData->vol; $is_change = true; }
					if($is_change) {
						//$updateFinDatas[$db->id] = $db;
						//$delDtStr = Yii::$app->formatter->asDatetime($db->datetime, FinData::DATETIME_FORMAT_DB);
						$delDtStr = substr($db->datetime, 0, 19);
						if(!in_array($delDtStr, $delDateTimes)){
							$delDateTimes[] = $delDtStr;
						}
						if(!array_key_exists($t, $addFinDatas)) $addFinDatas[$t] = $finData;
						$this->_logs['updateDetails'][] = [
							'old' => $old,
							'new' => "dt: $db->datetime, open: $db->open, max: $db->max, min: $db->min, close: $db->close, vol: $db->vol"
						];
					}
				}
				continue;
			}
			if(!in_array($finData->datetime, $delDateTimes)){
				$delDateTimes[] = $finData->datetime;
			}
			$addFinDatas[$t] = $finData;
		}

//		if(count($updateFinDatas) > 0){
//			$transaction = FinData::getDb()->beginTransaction();
//			try {
//				$rowUpdate = 0;
//				foreach ($updateFinDatas as $upFinData) {
//					//$upFinData->datetime = Yii::$app->formatter->asDatetime(strtotime($upFinData->datetime), FinData::DATETIME_FORMAT_DB);
//					//if ($upFinData->save(false, ['open', 'max', 'min', 'close', 'vol'])) $rowUpdate++;
//					//if ($upFinData->save(false)) $rowUpdate++;
//					if(FinData::updateAll([
//						'datetime' => Yii::$app->formatter->asDatetime($upFinData->datetime, FinData::DATETIME_FORMAT_DB),
//						'open' => $upFinData->open,
//						'max' => $upFinData->max,
//						'min' => $upFinData->min,
//						'close' => $upFinData->close,
//						'vol' => $upFinData->vol],
//						'id = :id', [':id' => $upFinData->id])) $rowUpdate++;
//				}
//				$transaction->commit();
//				$this->_logs['update'] = 'Обновлено ' . $rowUpdate . ' значений из '. count($updateFinDatas);
//			} catch (\Exception $e){
//				$transaction->rollBack();
//				throw $e;
//			} catch (\Throwable $e){
//				$transaction->rollBack();
//				throw $e;
//			}
//		} else {
//			$this->_logs['update'] = 'Обновлено не потребовалось';
//		}
		if(count($delDoubleIds) > 0){
			$transaction = FinData::getDb()->beginTransaction();
			try {
				$rowDel = FinData::deleteAll(['in', 'id', $delDoubleIds]);
				$transaction->commit();
				$this->_logs['del'] = 'Удалено дубликатов ' . $rowDel . ' значений из '. count($delDoubleIds);
			} catch (\Exception $e){
				$transaction->rollBack();
				throw $e;
			} catch (\Throwable $e){
				$transaction->rollBack();
				throw $e;
			}
		}
		if(count($delDateTimes) > 0){
			$transaction = FinData::getDb()->beginTransaction();
			try {
				$rowUpdate = FinData::deleteAll(['and', ['in', 'datetime', $delDateTimes], ['sourcecode_code' => $this->_settings->sourcecode_code]]);
				$transaction->commit();
				$this->_logs['update'] = 'Обновлено ' . $rowUpdate . ' значений из '. count($delDateTimes)."\n".'Удаляемые даты:'.implode(', ', $delDateTimes);
			} catch (\Exception $e){
				$transaction->rollBack();
				throw $e;
			} catch (\Throwable $e){
				$transaction->rollBack();
				throw $e;
			}
		} else {
			$this->_logs['update'] = 'Обновлено не потребовалось';
		}
		if(count($addFinDatas) > 0){

			$rows = ArrayHelper::getColumn($addFinDatas, 'attributes');
			$rowInsert = Yii::$app->db->createCommand()->batchInsert(FinData::tableName(), (new FinData())->attributes(), $rows)->execute();

			$this->_logs['add'] = 'Добавлено '.$rowInsert.' новых значений';
		} else {
			$this->_logs['add'] = 'Новых данных добавлено не было';
		}
	}

	/**
	 * @return FinData
	 */
	public function getMinDateTimeFinData(){
		return $this->_finDatas[min(array_keys($this->_finDatas))];
	}

	/**
	 * @return FinData
	 */
	public function getMaxDateTimeFinData(){
		return $this->_finDatas[max(array_keys($this->_finDatas))];
	}
}