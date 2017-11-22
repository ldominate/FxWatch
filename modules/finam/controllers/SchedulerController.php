<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 22.11.2017
 * Time: 21:30
 */

namespace app\modules\finam\controllers;

use yii\web\Controller;

class SchedulerController extends Controller
{
	public function actions()
	{
		return [
			'index' => [
				'class' => 'webtoolsnz\scheduler\actions\IndexAction',
				'view' => '@scheduler/views/index',
			],
			'update' => [
				'class' => 'webtoolsnz\scheduler\actions\UpdateAction',
				'view' => '@scheduler/views/update',
			],
			'view-log' => [
				'class' => 'webtoolsnz\scheduler\actions\ViewLogAction',
				'view' => '@scheduler/views/view-log',
			],
		];
	}
}