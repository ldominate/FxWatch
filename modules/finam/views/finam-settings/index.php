<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\finam\models\FinamSettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finam Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finam-settings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Finam Settings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'market',
            'em',
            'sourcecode_code',
            'apply',
            // 'from',
            // 'to',
            // 'p',
            // 'f',
            // 'e',
            // 'dtf',
            // 'tmf',
            // 'MSOR',
            // 'mstimever:datetime',
            // 'sep',
            // 'sep2',
            // 'datf',
            // 'at',
            // 'fsp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
