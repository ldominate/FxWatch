<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\Currency */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Currencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'code',
            'number',
            'mark',
            'name',
	        [
		        'attribute' => 'active',
		        'format'=>'raw',
		        'value' => function($model) {
			        return isset($model->active) && $model->active ? yii\bootstrap\Html::icon('glyphicon glyphicon-ok') : '';
		        },
		        'encode' => false
	        ],
        ],
    ]) ?>

	<p>
		<?= Html::a('Обновить', ['update', 'id' => $model->code], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Удалить', ['delete', 'id' => $model->code], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Вы уверены, что хотите удалить данную валюту?',
				'method' => 'post',
			],
		]) ?>
	</p>

</div>
