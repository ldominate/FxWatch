<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 26.07.2017
 * Time: 19:58
 * @var $content string
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use app\assets\SBAdmin2Asset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

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
	<title><?= Html::encode($this->title.' - '.Yii::$app->name) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">

	<?php
	NavBar::begin([
		'brandLabel' => 'SB Admin 2',
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar-default navbar-static-top',
			'style' => 'margin-bottom: 0'
		],
		'innerContainerOptions' => [
			'class' => 'container-fluid'
		]
	]);?>
	<ul class="nav navbar-top-links navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<?= yii\bootstrap\Html::icon('glyphicon glyphicon-user') ?> <?= Yii::$app->user->identity->username?> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li>
					<?= Html::a(yii\bootstrap\Html::icon('glyphicon glyphicon-file').' Профиль', Url::to(['user/update/'.Yii::$app->getUser()->getId()]))?>
				</li>
				<li><a href="#"><i class="fa fa-gear fa-fw"></i> Настройки</a>
				</li>
				<li class="divider"></li>
				<li>
					<?=
						Html::beginForm(['/user/logout'], 'post').
						Html::submitButton(yii\bootstrap\Html::icon('glyphicon glyphicon-log-out').' Выйти',
							['class' => 'btn btn-link logout']
						).
						Html::endForm()
					?>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
	<!-- /.navbar-top-links -->

	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<?= Nav::widget([
				'options' => ['class' => 'nav', 'id' => 'side-menu'],
				'items' => [
					['label' => yii\bootstrap\Html::icon('glyphicon glyphicon-user').' Пользователи', 'url' => Url::to(['/user/index'])],
					['label' => 'Home', 'url' => ['/site/index']],
					['label' => 'About', 'url' => ['/site/about']],
					['label' => 'Contact', 'url' => ['/site/contact']],
				],
				'encodeLabels' => false,
			]) ?>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
	<!-- /.navbar-static-side -->
	<?php
	NavBar::end();
	?>

	<!-- Page Content -->
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header"><?= Html::encode($this->title) ?></h1>
					<?= $content ?>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
