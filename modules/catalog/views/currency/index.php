<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\catalog\models\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Валюты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
	    'layout' => "{items}\n{summary}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'code',
            'number',
            'mark',
            'name',
            [
	            'attribute' => 'active',
	            'content' => function($model) {
		            return isset($model->active) && $model->active ? yii\bootstrap\Html::icon('glyphicon glyphicon-ok') : '';
	            },
	            'filter' => [
		            true => 'Да',
		            false => 'Нет'
	            ]
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
