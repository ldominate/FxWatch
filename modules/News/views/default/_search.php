<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'published') ?>

    <?= $form->field($model, 'categorynews_id') ?>

    <?= $form->field($model, 'country_code') ?>

    <?= $form->field($model, 'currency_code') ?>

    <?php // echo $form->field($model, 'release') ?>

    <?php // echo $form->field($model, 'percent_value') ?>

    <?php // echo $form->field($model, 'influence_id') ?>

    <?php // echo $form->field($model, 'fact') ?>

    <?php // echo $form->field($model, 'forecast') ?>

    <?php // echo $form->field($model, 'deviation') ?>

    <?php // echo $form->field($model, 'previous') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
