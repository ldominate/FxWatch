<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 09.12.2017
 * Time: 20:13
 * @var $this yii\web\View
 */

use yii\helpers\Html;

$this->title = 'Графики Финам';

?>

<div id="widget"></div>

<div>
	<?= Html::tag('h2', 'Result') ?>
	<pre class="pre-scrollable"><? var_dump($result) ?></pre>
</div>
