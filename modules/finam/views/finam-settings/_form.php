<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\finam\models\FinamSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finam-settings-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'url')->textInput() ?>

    <?= $form->field($model, 'market')->textInput() ?>

    <?= $form->field($model, 'em')->textInput() ?>

    <?= $form->field($model, 'sourcecode_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apply')->textInput() ?>

    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'p')->textInput() ?>

    <?= $form->field($model, 'f')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'e')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dtf')->textInput() ?>

    <?= $form->field($model, 'tmf')->textInput() ?>

    <?= $form->field($model, 'MSOR')->textInput() ?>

    <?= $form->field($model, 'mstimever')->textInput() ?>

    <?= $form->field($model, 'sep')->textInput() ?>

    <?= $form->field($model, 'sep2')->textInput() ?>

    <?= $form->field($model, 'datf')->textInput() ?>

    <?= $form->field($model, 'at')->textInput() ?>

    <?= $form->field($model, 'fsp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
