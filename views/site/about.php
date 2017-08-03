<?php

/* @var $this yii\web\View */

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

$fintoolgroups = \app\modules\catalog\models\FinToolGroup::find()->all();

?>
<div class="site-about">
    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

	<?= "PHP: " . PHP_VERSION . "\n";?>
	<?= "ICU: " . INTL_ICU_VERSION . "\n";?>
    <code><?= __FILE__ ?></code>
	<p>
	<?php foreach ($fintoolgroups as $finToolGroup):?>
		<?= "{$finToolGroup->id}: {$finToolGroup->name}"?><br/>
	<?php endforeach;?>
	</p>
</div>
