<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\finam\models\FinamSettingsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finam-settings-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'market') ?>

    <?= $form->field($model, 'em') ?>

    <?= $form->field($model, 'sourcecode_code') ?>

    <?= $form->field($model, 'apply') ?>

    <?php // echo $form->field($model, 'from') ?>

    <?php // echo $form->field($model, 'to') ?>

    <?php // echo $form->field($model, 'p') ?>

    <?php // echo $form->field($model, 'f') ?>

    <?php // echo $form->field($model, 'e') ?>

    <?php // echo $form->field($model, 'dtf') ?>

    <?php // echo $form->field($model, 'tmf') ?>

    <?php // echo $form->field($model, 'MSOR') ?>

    <?php // echo $form->field($model, 'mstimever') ?>

    <?php // echo $form->field($model, 'sep') ?>

    <?php // echo $form->field($model, 'sep2') ?>

    <?php // echo $form->field($model, 'datf') ?>

    <?php // echo $form->field($model, 'at') ?>

    <?php // echo $form->field($model, 'fsp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
