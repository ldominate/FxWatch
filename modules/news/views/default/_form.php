<?php

use app\modules\catalog\models\CategoryNews;
use app\modules\catalog\models\Country;
use app\modules\catalog\models\Currency;
use app\modules\catalog\models\Influence;
use app\modules\news\models\News;
use nkovacs\datetimepicker\DateTimePicker;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $form yii\widgets\ActiveForm */

$countries = Country::find()->active()->select(['name', 'code'])->indexBy('code')->orderBy(['name' => SORT_ASC])->column();
$categoriesNews = CategoryNews::find()->select(['name', 'id'])->indexBy('id')->orderBy(['name' => SORT_ASC])->column();
$currencies = Currency::find()->active()->select(['code'])->indexBy('code')->orderBy(['code' => SORT_ASC])->column();
$influences = Influence::find()->select(['name', 'id'])->indexBy('id')->column();

$model->published = Yii::$app->formatter->asDatetime($model->published, News::DATETIME_FORMAT);

?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-md-3">
			<?= $form->field($model, 'published')->widget(DateTimePicker::className(), [
				'format' => News::DATETIME_FORMAT
			]) ?>
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'currency_code')->dropDownList($currencies, ['prompt' => '']) ?>
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'country_code')->dropDownList($countries, ['prompt' => '']) ?>
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'categorynews_id')->dropDownList($categoriesNews, ['prompt' => '']) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<?= $form->field($model, 'influence_id')->dropDownList($influences, ['prompt' => '']) ?>
		</div>
		<div class="col-md-7">
			<?= $form->field($model, 'release')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'сategory_month')->dropDownList(array_combine(News::CATEGORY_MONTH, News::CATEGORY_MONTH), ['prompt' => '']) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-1 text-right checkbox">
			<label class="control-label" for="percent_value">&nbsp;</label>
			<?= $form->field($model, 'percent_value')->checkbox() ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'fact')->textInput(['class' => 'form-control text-right', 'maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'forecast')->textInput(['class' => 'form-control text-right', 'maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'deviation')->textInput(['class' => 'form-control text-right', 'maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'previous')->textInput(['class' => 'form-control text-right', 'maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    <?php if(!$model->isNewRecord) {
	        Modal::begin([
		        'toggleButton' => [
			        'tag' => 'button',
			        'class' => 'btn btn-warning',
			        'label' => 'Создать копию',
		        ],
		        'footer' => '<a href="'.\yii\helpers\Url::to(['/news/duplicate/'.$model->id]).'" class="btn btn-primary">Да</a><button type="button" class="btn btn-default" data-dismiss="modal">Нет</button>'
	        ]);
	        echo '<h4>Вы уверены, что хотите создать дубликат?</h4>';
	        Modal::end();
        } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
