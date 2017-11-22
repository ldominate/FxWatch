<?php

namespace app\tasks;

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
		echo 'Data';
	}
}