<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 06.08.2017
 * Time: 19:47
 * @var $this yii\web\View
 * @var $news News
 * @var $fintool \app\modules\catalog\models\FinTool
 * @var $period \app\modules\catalog\models\Period
 * @var $dataProvider ActiveDataProvider
 * @var $model \app\modules\news\models\NewsData
 * @var $form yii\widgets\ActiveForm
 */

use app\modules\news\models\News;
use nkovacs\datetimepicker\DateTimePicker;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Данные по '.$fintool->name.' периодичность '.$period->name.' от '.Yii::$app->formatter->asDatetime($news->published, News::DATETIME_FORMAT);

?>
<div class="news-index">

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{items}\n{summary}\n{pager}",
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'datetime',
				'contentOptions' =>['class' => 'text-left'],
				'format' => ['datetime', News::DATETIME_FORMAT],
				'filter' => false
			],
			'min',
			'max',
			'open',
			'close',

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{newsdatadel}',
				'buttons' => [
					'urlCreator'=>function($action, $model, $key, $index){
						return ($action == 'delete')
							? ['/news/default/newsdatadel', 'id' => $model['id']]
							: [$action,'id'=>$model['id'],'hvost'=>$index.$key];
					},
					'newsdatadel' => function($url, $model) {
						$options = [
							'title' => 'Удалить',
							'aria-label' => 'Удалить данные',
							'data-confirm' => 'Вы уверены что хотите удалить данные?',
							'data-method' => 'post',
							'data-pjax' => '0',
						];
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
					}
				]
			]
		]
	]); ?>

</div>

<div class="newsdata-form">
	<?php $form = ActiveForm::begin(); ?>

	<?= Html::hiddenInput('news_id', $news->id) ?>
	<?= Html::hiddenInput('fintool_id', $fintool->id) ?>
	<?= Html::hiddenInput('period_id', $period->id) ?>

	<div class="row">
		<div class="col-md-3">
			<?= $form->field($model, 'datetime')->widget(DateTimePicker::className(), [
				'format' => News::DATETIME_FORMAT
			]) ?>
			<?= $form->field($model, 'news_id')->hiddenInput()->label(false) ?>
			<?= $form->field($model, 'fintool_id')->hiddenInput()->label(false) ?>
			<?= $form->field($model, 'period_id')->hiddenInput()->label(false) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'min')->textInput(['class' => 'form-control text-right', 'maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'max')->textInput(['class' => 'form-control text-right', 'maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'open')->textInput(['class' => 'form-control text-right', 'maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'close')->textInput(['class' => 'form-control text-right', 'maxlength' => true]) ?>
		</div>
	</div>

	<div class="form-group">
		<?= Html::a(Html::icon('glyphicon glyphicon-chevron-left').' Назад', Url::to(['/news/update', 'id' => $news->id]), ['class' => 'btn btn-default']) ?>
		<?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>
