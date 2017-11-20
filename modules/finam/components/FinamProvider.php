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
use yii\base\Object;
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

	public function __construct(FinamSettings $settings, array $config = [])
	{
		$this->_settings = $settings;

		parent::__construct($config);
	}

	public function requestSource(){

		$attributes = $this->_settings->initAttributes('17.11.2017');

		$client = new Client();

		$this->_response = $client->createRequest()
			->setMethod('get')
			->setUrl($this->_settings->url)
			->setData($attributes)
			->send();

		if($this->_response->getIsOk()){
			$result = str_getcsv($this->_response->getContent(), "\n");

			if(!is_array($result) || count($result) <= 0){
				return 'Полученный результат пуст';
			}

			$finDatas = [];

			foreach ($result as $dataRow){
				$finData = FinData::createFinamData($dataRow);

				//$finDatas[] = $finData->getErrors();
				$finDatas[] = $finData->getAttributes();
			}

			return $finDatas;
		}else{
			//Запрос не верный
			return $this->_response->getStatusCode();
		}

	}
}