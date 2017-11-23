<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\finam\models\FinData */

$this->title = 'Create Fin Data';
$this->params['breadcrumbs'][] = ['label' => 'Fin Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fin-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
