<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\SourceCode */

$this->title = 'Create Source Code';
$this->params['breadcrumbs'][] = ['label' => 'Source Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
