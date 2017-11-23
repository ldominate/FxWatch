<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\finam\models\FinData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fin-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sourcecode_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datetime')->textInput() ?>

    <?= $form->field($model, 'open')->textInput() ?>

    <?= $form->field($model, 'max')->textInput() ?>

    <?= $form->field($model, 'min')->textInput() ?>

    <?= $form->field($model, 'close')->textInput() ?>

    <?= $form->field($model, 'vol')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
