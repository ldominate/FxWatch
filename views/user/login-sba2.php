<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\Login */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация пользователя';
$this->params['logboxttl'] = 'Авторизация пользователя';
?>

<?php $form = ActiveForm::begin([
	'id' => 'login-form',
	//'layout' => 'horizontal',
	'fieldConfig' => [
		'template' => "{label}\n<div class=\"form-group has-feedback\">{input}{error}</div>",
		//'labelOptions' => ['class' => 'col-lg-1 control-label'],
	],
]); ?>
<fieldset>
<?= $form->field($model, 'username', ['enableLabel' => false])->textInput(['placeholder' => $model->getAttributeLabel('username'), 'autofocus' => true]) ?>

<?= $form->field($model, 'password', ['enableLabel' => false])->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

<?= $form->field($model, 'rememberMe')->checkbox() ?>

<div class="form-group">
	<div class="col-lg-offset-1 col-lg-11">
		<?= Html::submitButton('Войти в систему', ['class' => 'btn btn-lg btn-success btn-block', 'name' => 'login-button']) ?>
	</div>
</div>
</fieldset>
<?php ActiveForm::end(); ?>