<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 27.08.2017
 * Time: 0:22
 * @var $this yii\web\View
 */

$this->title = 'Виджет';

//$this->registerJsFile('/js/vendor.js',['position' => yii\web\View::POS_END]);
//$this->registerJsFile('/js/widget.js?v='.rand(),['position' => yii\web\View::POS_END]);
$this->registerJsFile('/js/widget.js?v='.rand(),['position' => yii\web\View::POS_END]);

//$this->registerCssFile('/js/vendor.css');
//$this->registerCssFile('/js/widget.css');

?>

<div id="widget"></div>