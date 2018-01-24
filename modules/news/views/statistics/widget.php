<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 20.01.2018
 * Time: 13:50
 * @var $this yii\web\View
 */

$this->title = 'Статистика новостей';

$this->registerJsFile('/js/vendor.js',['position' => yii\web\View::POS_END]);
$this->registerJsFile('/js/statistics.js?v='.rand(),['position' => yii\web\View::POS_END]);
//$this->registerJsFile('/js/statistics.js',['position' => yii\web\View::POS_END]);

$this->registerCssFile('/js/vendor.css');
$this->registerCssFile('/js/statistics.css');

?>

<div id="widget"></div>
