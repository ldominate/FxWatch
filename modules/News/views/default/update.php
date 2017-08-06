<?php

use app\modules\catalog\models\FinTool;
use app\modules\catalog\models\Period;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */

$this->title = 'Редактирование новости от '. Yii::$app->formatter->asDatetime($model->published, \app\modules\news\models\News::DATETIME_FORMAT);
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';

$fintools = FinTool::find()->all();
$periods = Period::find()->all();

?>
<div class="news-update">

    <?= $this->render('_form', ['model' => $model]) ?>

	<div class="row">
		<?php foreach ($fintools as $fintool): ?>
			<div class="col-xs-8 col-sm-6 col-md-4 col-lg-3">
				<div class="thumbnail">
					<div class="caption">
						<h4><?=$fintool->name?></h4>
						<?php foreach ($periods as $period): ?>
							<div class="row bottom-buffer">
								<div class="col-xs-6 col-sm-7 col-md-6 col-lg-6 text-left"><?=$period->name?></div>
								<div class="col-xs-6 col-sm-5 col-md-6 col-lg-6 text-right">
									<?= Html::a(Html::icon('glyphicon glyphicon-pencil'), ['#'], ['class' => 'btn btn-primary btn-xs', 'title' => 'Изменить'])?>
									&nbsp;
									<?= Html::a(Html::icon('glyphicon glyphicon-trash'), ['#'], ['class' => 'btn btn-warning btn-xs', 'title' => 'Удалить'])?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endforeach;?>
	</div>
</div>
