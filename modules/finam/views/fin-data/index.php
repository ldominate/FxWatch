<?php

use app\modules\news\models\News;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\finam\models\FinDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fin Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fin-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Fin Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
	        [
		        'attribute' => 'sourcecode_code',
		        'label' => 'Инструмент',
		        'filter' => true
	        ],
	        [
		        'attribute' => 'datetime',
		        'contentOptions' =>['class' => 'text-left'],
		        'label' => 'Дата время',
		        'format' => ['datetime', News::DATETIME_FORMAT],
		        'filter' => true
	        ],
            'open',
            'max',
            'min',
            'close',
            'vol',

            [
            	'class' => 'yii\grid\ActionColumn',
	            'header' => 'Действия',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
