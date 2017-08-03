<?php

/* @var $this yii\web\View */

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

$fintoolgroups = \app\modules\catalog\models\FinToolGroup::find()->all();
$fintools = \app\modules\catalog\models\FinTool::find()->with('fintoolgroup')->all();

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
</div>
