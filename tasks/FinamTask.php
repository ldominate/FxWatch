<?php

namespace app\tasks;

use app\modules\catalog\models\SourceCode;
use app\modules\finam\components\FinamProvider;
use app\modules\finam\models\FinamSettings;
use webtoolsnz\scheduler\Task;

/**
 * Created by PhpStorm.
 * User: johny
 * Date: 22.11.2017
 * Time: 21:58
 */

class FinamTask extends Task
{

	public $description = 'Периодическое получение данных с сайта finam.ru';

	public $schedule = '*/10 * * * *';

	/**
	 * The main method that gets invoked whenever a task is ran, any errors that occur
	 * inside this method will be captured by the TaskRunner and logged against the task.
	 *
	 * @return mixed
	 */
	public function run()
	{
		$sources = SourceCode::find()->select('code')->column();

		$finamSettings = FinamSettings::find()->where(['in', 'sourcecode_code', $sources])->indexBy('sourcecode_code')->all();

		shuffle($finamSettings);

		$result = [];

		$dateGet = date('d.m.Y');

		foreach ($finamSettings as $finamSetting){

			$provider = new FinamProvider($finamSetting);

			if($provider->requestSource($dateGet)) {

				$provider->saveNewFinData();

			} else {
				//$result[$finamSettingsEurUsd->sourcecode_code] = $provider->getLogs();
			}
			$result[$finamSetting->sourcecode_code] = $provider->getLogs();

			sleep(rand(10, 30));
		}

		echo 'Отчёт получения данных планировщиком'."\n";
		foreach ($result as $code => $message){
			echo $code.':*********************'."\n";

			if(key_exists('result', $message)) {
				echo 'Результат:' . $message['result']."\n";
			}
			if(key_exists('input', $message)){
				echo 'Вход:'.$message['input']."\n";
			}
			if(key_exists('errors', $message)) {
				if(is_array($message['errors'])){
					echo 'Ошибки:'."\n";
					foreach ($message['errors'] as $errors) {
						foreach ($errors as $error) {
							echo $error."\n";
						}
					}
				}else{
					echo 'Ошибки:'.$message['errors']."\n";
				}
			}
			if(key_exists('update', $message)){
				echo 'Обновлено:'.$message['update']."\n";
			}
			if(key_exists('updateDetails', $message)){
				echo 'Детально:'."\n";
				foreach ($message['updateDetails'] as $index => $data){
					echo 'old - '.$data['old']."\n";
					echo 'new - '.$data['new']."\n";
				}
			}
			if(key_exists('add', $message)){
				echo 'Добавлено:'.$message['add']."\n";
			}
		}
	}
}