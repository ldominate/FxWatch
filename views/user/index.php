<?php
use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<p><?= yii\bootstrap\Html::a('Добавить', Url::to('user\add'), ['class' => 'btn btn-success']); ?></p>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'layout' => "{items}\n{summary}\n{pager}",
	'columns' => [
		['class' => 'yii\grid\SerialColumn'],
		'username',
		'email:email',
		[
			'attribute' => 'updated_at',
			'contentOptions' =>['class' => 'text-center'],
			'format' => 'date',
			//'format' => ['date', 'dd.MM.Y']
		],
		[
			'attribute' => 'created_at',
			'contentOptions' =>['class' => 'text-center'],
			'format' => 'date'
		],
		[
			'attribute' => 'status',
			'contentOptions' =>['class' => 'text-center'],
			'value' => function($model) {
				return $model->status == User::STATUS_INACTIVE ? 'Блокированный' : 'Активный';
			},
			'filter' => [
				User::STATUS_INACTIVE => 'Блокированный',
				User::STATUS_ACTIVE => 'Активный'
			]
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{update} {delete} {link}',
			'buttons' => [
				'activate' => function($url, $model) {
					if ($model->status == User::STATUS_ACTIVE) {
						return '';
					}
					$options = [
						'title' => 'Активировать',
						'aria-label' => 'Активировать',
						'data-confirm' => 'Вы уверены что хотите активировать пользователя?',
						'data-method' => 'post',
						'data-pjax' => '0',
					];
					return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
				}
			],
			'visibleButtons' => [
				'delete' => function ($model) {
					return Yii::$app->getUser()->getId() != $model->id;
				}
			]
		],
	],
]);
?>

