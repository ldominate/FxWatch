<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 26.07.2017
 * Time: 19:59
 */

namespace app\assets;

use yii\web\AssetBundle;

class SBAdmin2Asset extends AssetBundle
{
	public $sourcePath = '@app/assets';
//	public $basePath = '@webroot';
//	public $baseUrl = '@web';

	public $css = [
		'css/sb-admin-2.css',
		//'css/sba.css'
	];
	public $js = [
		'js/sba.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		'mimicreative\assets\MetisMenuAsset'
	];

	//copy Res on reload
	public $publishOptions = [
		'forceCopy' => true,
	];
}