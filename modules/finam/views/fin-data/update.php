<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\finam\models\FinData */

$this->title = 'Update Fin Data: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fin Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fin-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
