<?php

/* @var $this yii\web\View */

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

	<?= "PHP: " . PHP_VERSION . "\n";?>
	<?= "ICU: " . INTL_ICU_VERSION . "\n";?>
    <code><?= __FILE__ ?></code>
</div>
