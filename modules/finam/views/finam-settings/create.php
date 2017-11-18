<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\finam\models\FinamSettings */

$this->title = 'Create Finam Settings';
$this->params['breadcrumbs'][] = ['label' => 'Finam Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finam-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
