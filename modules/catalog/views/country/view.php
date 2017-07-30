<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\Country */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-lg-5">
		<div class="panel panel-default country-view">
			<div class="panel-body">

			    <?= DetailView::widget([
			        'model' => $model,
			        'attributes' => [
			            'code',
			            'lcode',
				        [
					        'attribute' => 'currency_id',
					        'value' => function($model) {
						        $currency = $model->currency;
						        return isset($currency) ? $currency->name.' ('.$currency->code.')' : $model->currency_id;
					        },
					        'encode' => false
				        ],
			            //'currency_id',
			            'name',
			            'timezone',
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
		</div>
	</div>
</div>