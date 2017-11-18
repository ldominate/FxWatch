<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\finam\models\FinamSettings */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finam Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finam-settings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'url',
            'market',
            'em',
            'sourcecode_code',
            'apply',
            'from:date',
            'to:date',
            'p',
            'f',
            'e',
            'dtf',
            'tmf',
            'MSOR',
            'mstimever',
            'sep',
            'sep2',
            'datf',
            'at',
            'fsp',
        ],
    ]) ?>

</div>
