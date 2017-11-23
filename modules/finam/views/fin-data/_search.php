<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\finam\models\FinDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fin-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sourcecode_code') ?>

    <?= $form->field($model, 'datetime') ?>

    <?= $form->field($model, 'open') ?>

    <?= $form->field($model, 'max') ?>

    <?php // echo $form->field($model, 'min') ?>

    <?php // echo $form->field($model, 'close') ?>

    <?php // echo $form->field($model, 'vol') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
