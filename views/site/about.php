<?php

/* @var $this yii\web\View */

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

$fintoolgroups = \app\modules\catalog\models\FinToolGroup::find()->all();
$fintools = \app\modules\catalog\models\FinTool::find()->with('fintoolgroup')->all();
$categoriesNews = \app\modules\catalog\models\CategoryNews::find()->all();
$currencies = \app\modules\catalog\models\Currency::find()->active()->all();
$influences = \app\modules\catalog\models\Influence::find()->all();

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
		<?php foreach ($finToolGroup->fintools as $finTool) : ?>
			<?= "{$finTool->id}: {$finTool->name}"?><br/>
		<?php endforeach;?>
	<?php endforeach;?>
	</p>
	<p>
		<?php foreach ($fintools as $finTool):?>
			<?= "{$finTool->id}: {$finTool->name} ({$finTool->fintoolgroup->name})"?><br/>
		<?php endforeach;?>
	</p>
	<p>
		<?php foreach ($categoriesNews as $categoryNews):?>
			<?= "{$categoryNews->id}: {$categoryNews->name}"?><br/>
		<?php endforeach;?>
	</p>
	<p>
		<?php foreach ($currencies as $currency):?>
			<?= "{$currency->code}: {$currency->name}"?><br/>
		<?php endforeach;?>
	</p>
	<p>
		<?php foreach ($influences as $influence):?>
			<?= "{$influence->id}: {$influence->name}"?><br/>
		<?php endforeach;?>
	</p>
</div>
