<?php

use app\modules\catalog\models\CategoryNews;
use app\modules\catalog\models\Country;
use app\modules\news\models\News;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список новостей';
$this->params['breadcrumbs'][] = $this->title;

$categoriesNews = CategoryNews::find()->select(['name', 'id'])->indexBy('id')->orderBy(['name' => SORT_ASC])->column();
$countries = Country::find()->active()->select(['name', 'code'])->indexBy('code')->orderBy(['name' => SORT_ASC])->column();

?>
<div class="news-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
	    'layout' => "{items}\n{summary}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

	        [
		        'attribute' => 'categorynews_id',
//		        'contentOptions' =>['class' => 'text-left'],
//		        'format' => 'text',
//		        'content' => function($data){
//    	            return $data->categorynews->name;
//		        },
		        'value' => function($model) use($categoriesNews) {
			        $categoryNews = $categoriesNews[$model->categorynews_id];
			        return isset($categoryNews) ? $categoryNews : $model->categorynews_id;
		        },
		        'filter' => $categoriesNews
	        ],
	        [
		        'attribute' => 'country_code',
//		        'contentOptions' =>['class' => 'text-left'],
//		        'format' => 'text',
//		        'content' => function($data){
//			        return $data->countryCode->name;
//		        },
		        'value' => function($model) use($countries) {
			        $country = $countries[$model->country_code];
			        return isset($country) ? $country : $model->country_code;
		        },
		        'filter' => $countries
	        ],
	        [
		        'attribute' => 'published',
		        'contentOptions' =>['class' => 'text-left'],
		        'format' => ['datetime', News::DATETIME_FORMAT],
		        //'filter' =>  \nkovacs\datetimepicker\DateTimePicker::widget(['name' => 'NewsSearch[published]', 'format' => News::DATETIME_FORMAT])
		        'filter' => false
	        ],
            'currency_code',
            // 'release',
            // 'percent_value',
            // 'influence_id',
            // 'fact',
            // 'forecast',
            // 'deviation',
            // 'previous',

            [
            	'class' => 'yii\grid\ActionColumn',
	            'header' => 'Действия',
	            'template' => '{update} {delete} {link}',
            ],
        ],
    ]); ?>
	<p>
		<?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
</div>
