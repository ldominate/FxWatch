<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $model app\models\form\SetUser
 */
?>
<div class="row">
	<div class="col-lg-5">
<div class="panel panel-default">
	<div class="panel-heading">Данные пользователя</div>
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
		<?= $form->field($model, 'isNewRecord')->hiddenInput()->label(false) ?>

		<?= $form->field($model, 'username')->textInput(['readonly' => !$model->isNewRecord, 'maxlength' => true]) ?>

		<?= $form->field($model, 'email')->input('email', ['maxlength' => true]) ?>

		<?= $form->field($model, 'password')->passwordInput()->hint('Длинна пароля не меньше 6 символов.') ?>

		<?= $form->field($model, 'retypePassword')->passwordInput() ?>

		<?php if(!$model->isNewRecord): ?>
			<?= $form->field($model, 'updated_at')->textInput(['readonly' => true, 'value' => Yii::$app->formatter->asDate($model->updated_at, 'dd.MM.Y')]) ?>
		<?php endif;?>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
	</div>
</div>
