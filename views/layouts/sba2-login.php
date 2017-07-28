<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 19.07.2017
 * Time: 23:02
 */
use yii\helpers\Html;
use app\assets\SBAdmin2Asset;

SBAdmin2Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?= isset($this->params['logboxttl']) ? Html::encode($this->params['logboxttl']) : Html::encode($this->title) ?></h3>
				</div>
				<div class="panel-body">
					<?= $content ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
