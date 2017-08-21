<?php

use app\modules\catalog\models\CategoryNews;
use app\modules\catalog\models\Country;
use app\modules\news\models\News;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список новостей';
$this->params['breadcrumbs'][] = $this->title;

$categoriesNews = CategoryNews::find()->select(['name', 'is_month', 'id'])->indexBy('id')->orderBy(['name' => SORT_ASC])->all();
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
		        'content' => function($model) use($categoriesNews) {
			        $categoryNews = $categoriesNews[$model->categorynews_id];
			        return Html::a(isset($categoryNews)
				        ? ($categoryNews->is_month)
					        ? str_replace(CategoryNews::PLACEHOLDER_MONTH,
						        empty($model->сategory_month)
							        ? Yii::$app->formatter->asDate($model->published, 'MMMM')
							        : $model->category_month,
						        $categoryNews->name)
					        : $categoryNews->name
				        : $model->categorynews_id, \yii\helpers\Url::to(['update', 'id' => $model->id]));
		        },
		        'filter' => \yii\helpers\ArrayHelper::getColumn($categoriesNews, 'name')
	        ],
	        [
		        'attribute' => 'country_code',
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
		<?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
</div>
