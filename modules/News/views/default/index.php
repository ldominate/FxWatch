<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список новостей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
	    'layout' => "{items}\n{summary}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'published',
            'categorynews_id',
            'country_code',
            'currency_code',
            // 'release',
            // 'percent_value',
            // 'influence_id',
            // 'fact',
            // 'forecast',
            // 'deviation',
            // 'previous',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	<p>
		<?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
</div>
