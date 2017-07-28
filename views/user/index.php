<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?=
	GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'username',
			'email:email',
			'created_at:date',
			[
				'attribute' => 'status',
				'value' => function($model) {
					return $model->status == 0 ? 'Inactive' : 'Active';
				},
				'filter' => [
					0 => 'Inactive',
					10 => 'Active'
				]
			],
			[
				'class' => 'yii\grid\ActionColumn',
				//'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
				'buttons' => [
					'activate' => function($url, $model) {
						if ($model->status == 10) {
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
				]
			],
		],
	]);
	?>
</div>
