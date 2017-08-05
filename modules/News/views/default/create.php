<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */

$this->title = 'Добавить новость';
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
