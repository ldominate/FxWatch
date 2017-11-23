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
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\httpclient\Response;


class FinamProvider extends Object
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

	public function __construct(FinamSettings $settings, array $config = [])
	{
		$this->_settings = $settings;

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

		$this->_response = $client->createRequest()
			->setMethod('get')
			->setUrl($this->_settings->url)
			->setData($attributes)
			->send();

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

					$timeFinData = strtotime($finData->datetime);
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

		$finDataDb = FinData::find()
			->andWhere(['sourcecode_code' => $this->_settings->sourcecode_code])
			->andWhere([
				'between',
				'datetime',
				Yii::$app->formatter->asDatetime($minFinData->datetime, FinData::DATETIME_FORMAT_DB),
				Yii::$app->formatter->asDatetime($maxFinData->datetime, FinData::DATETIME_FORMAT_DB)])
			->with('sourceCode')
			->orderBy(['datetime' => SORT_ASC])
			->all();

		$finDateTimeDb = array_map(function($e){
			return strtotime($e->datetime);
		}, $finDataDb);
//			ArrayHelper::map($finDataDb, 'id', 'datetime');
//			);

		$addFinDatas = [];
		foreach ($this->_finDatas as $t => $finData){
			if(in_array($t, $finDateTimeDb)) continue;
			$addFinDatas[$t] = $finData;
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