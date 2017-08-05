<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <?= $form->field($model, 'categorynews_id')->textInput() ?>

    <?= $form->field($model, 'country_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'release')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'percent_value')->textInput() ?>

    <?= $form->field($model, 'influence_id')->textInput() ?>

    <?= $form->field($model, 'fact')->textInput() ?>

    <?= $form->field($model, 'forecast')->textInput() ?>

    <?= $form->field($model, 'deviation')->textInput() ?>

    <?= $form->field($model, 'previous')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
