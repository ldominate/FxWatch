<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
	<div class="col-lg-5">
		<div class="panel panel-default country-form">
			<div class="panel-body">

			    <?php $form = ActiveForm::begin(); ?>

			    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

			    <?= $form->field($model, 'lcode')->textInput(['maxlength' => true]) ?>

			    <?= $form->field($model, 'currency_id')->textInput(['maxlength' => true]) ?>

			    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			    <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>

			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			    </div>

			    <?php ActiveForm::end(); ?>

			</div>
		</div>
	</div>
</div>