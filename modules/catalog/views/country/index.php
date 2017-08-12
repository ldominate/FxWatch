<?php

use app\modules\catalog\models\Currency;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\catalog\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страны';
$this->params['breadcrumbs'][] = $this->title;

$currencies = Currency::find()->select(['name', 'code'])->indexBy('code')->all();

?>
<div class="country-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            'lcode',
            [
	            'label' => '',
	            'content' => function($model){
					return Html::tag('span', '', ['class' => 'flag-icon flag-icon-'.strtolower($model->code)]);
	            },
	            'filter' => false,
	            'enableSorting' => false
            ],
            'name',
	        [
		        'attribute' => 'currency_id',
		        'value' => function($model) use($currencies) {
    	            if(!isset($model->currency_id)) return '';
			        $currency = array_key_exists($model->currency_id, $currencies) ? $currencies[$model->currency_id] : null;
			        return isset($currency) ? $currency->name.' ('.$currency->code.')' : $model->currency_id;
		        },
		        'filter' => ArrayHelper::map($currencies, 'code', 'name')
	        ],
            'timezone',
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
