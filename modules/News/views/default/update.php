<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */

$this->title = 'Редактирование новости от '. Yii::$app->formatter->asDatetime($model->published, \app\modules\news\models\News::DATETIME_FORMAT);
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
