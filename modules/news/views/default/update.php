<?php

use app\modules\catalog\models\FinTool;
use app\modules\catalog\models\Period;
use app\modules\news\models\News;
use app\modules\news\models\NewsData;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $associated News[] */

$this->title = 'Редактирование новости от '. Yii::$app->formatter->asDatetime($model->published, News::DATETIME_FORMAT);
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';

$fintools = FinTool::find()->all();
$periods = Period::find()->all();

$exists_newsdata = NewsData::find()->where(['news_id' => $model->id])->select(['fintool_id', 'period_id'])->groupBy(['fintool_id', 'period_id'])->asArray()->all();
$period_ids = array_unique(ArrayHelper::getColumn($exists_newsdata, 'fintool_id'));
$exists_period = [];
foreach ($period_ids as $p){
	foreach ($exists_newsdata as $en){
		if($en['fintool_id'] == $p){
			$exists_period[$p][] = $en['period_id'];
		}
	}
}
/**
 * @param $news News
 * @param $field string
 * @return string
 */
function formatValue($news, $field){
	return $news->percent_value
		? number_format($news[$field], 1, '.', '').'%'
		: number_format($news[$field], 2, '.', ' ');
}
?>
<div class="news-update bottom-block">

    <?= $this->render('_form', ['model' => $model]) ?>

	<div class="row">
		<?php foreach ($fintools as $fintool): ?>
			<div class="col-xs-8 col-sm-4 col-md-3 col-lg-2">
				<div class="thumbnail">
					<div class="caption">
						<h4><?=$fintool->name?></h4>
						<?php foreach ($periods as $period): ?>
							<div class="row bottom-buffer">
								<div class="col-xs-6 col-sm-7 col-md-6 col-lg-6 text-left">
									<?= Html::a(
										$period->name,
										\yii\helpers\Url::to(['/news/default/newsdata', 'news_id' => $model->id, 'fintool_id' => $fintool->id, 'period_id' => $period->id]),
										['title' => 'Изменить данные'])?>
									<?= (isset($exists_period[$fintool->id]) && ArrayHelper::isIn($period->id, $exists_period[$fintool->id]))
										? Html::icon('glyphicon glyphicon-save', ['title' => 'Данные загружены'])
										: ''?>
								</div>
								<div class="col-xs-6 col-sm-5 col-md-6 col-lg-6 text-right">
									<?= (isset($exists_period[$fintool->id]) && ArrayHelper::isIn($period->id, $exists_period[$fintool->id]))
										? Html::a(
											Html::icon('glyphicon glyphicon-trash'),
											\yii\helpers\Url::to(['/news/default/newsdatadelall', 'news_id' => $model->id, 'fintool_id' => $fintool->id, 'period_id' => $period->id]),
											['class' => '', 'title' => 'Удалить все данные'])
										: '&nbsp;'?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endforeach;?>
	</div>

	<?php if(isset($associated) && count($associated) > 0) : ?>
	<div class="associated">
		<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th><?=$model->getAttributeLabel('published')?></th>
				<th><?=$model->getAttributeLabel('currency_code')?></th>
				<th><?=$model->getAttributeLabel('release')?></th>
				<th><?=$model->getAttributeLabel('influence_id')?></th>
				<th><?=$model->getAttributeLabel('fact')?></th>
				<th><?=$model->getAttributeLabel('forecast')?></th>
				<th><?=$model->getAttributeLabel('deviation')?></th>
				<th><?=$model->getAttributeLabel('previous')?></th>
				<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($associated as $ass_news) : ?>
			<tr>
				<td><?=Yii::$app->formatter->asTime($ass_news->published, 'HH:mm')?></td>
				<td class="text-right"><?=$ass_news->currency_code ?></td>
				<td class="text-right"><?=$ass_news->release ?></td>
				<td class="text-center"><?=$ass_news->influence->name?></td>
				<td class="text-center"><?=formatValue($ass_news, 'fact')?></td>
				<td class="text-center"><?=formatValue($ass_news, 'forecast')?></td>
				<td class="text-center"><?=formatValue($ass_news, 'deviation')?></td>
				<td class="text-center"><?=formatValue($ass_news, 'previous')?></td>
				<td><?=Html::a(Html::icon('glyphicon glyphicon-pencil'), ['update', 'id' => $ass_news->id], ['title' => 'Изменить'])?></td>
			</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<?php endif; ?>
</div>
