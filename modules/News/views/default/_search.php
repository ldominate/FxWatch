<?php

use app\modules\news\models\News;
use nkovacs\datetimepicker\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(<<<JS
$(function () {
$("#newssearch-published_from").closest(".input-group.date").on("dp.change", function (e) {
	$('#newssearch-published_to').closest(".input-group.date").data("DateTimePicker").minDate(e.date);
});
$("#newssearch-published_to").closest(".input-group.date").on("dp.change", function (e) {
	$('#newssearch-published_from').closest(".input-group.date").data("DateTimePicker").maxDate(e.date);
});
$("#clearFilter").on('click', function(e) {
	$("#filterForm").find("input").val("").submit();
});
});
JS
, \yii\web\View::POS_READY);
?>

<div class="news-search">

    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get', 'options' => ['id' => 'filterForm', 'class' => 'form-inline'] ]); ?>

	<div class="row">
		<div class="col-md-3">
			<?= $form->field($model, 'published_from')->widget(DateTimePicker::className(), [
				'format' => News::DATETIME_FORMAT,
				'clientOptions' => [
					'extraFormats' => [News::DATETIME_FORMAT],
				]
			]) ?>
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'published_to')->widget(DateTimePicker::className(), [
				'format' => News::DATETIME_FORMAT,
				'clientOptions' => [
					'extraFormats' => [News::DATETIME_FORMAT],
					'useCurrent' => false
				],
			]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<?= Html::submitButton('Поиск', ['class' => 'btn btn-primary btn-block']) ?>
		</div>
		<div class="col-md-2">
			<?= Html::button('Очистить', ['id' => 'clearFilter', 'class' => 'btn btn-default btn-block']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div><br/>
