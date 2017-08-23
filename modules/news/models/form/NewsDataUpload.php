<?php

namespace app\modules\News\models\form;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: johny
 * Date: 06.08.2017
 * Time: 23:57
 */
class NewsDataUpload extends Model
{
	/**
	 * @var UploadedFile
	 */
	public $dataFile;

	public function rules()
	{
		return [
			[['dataFile'], 'file', 'skipOnEmpty'  => false, 'extensions' => 'txt,csv', 'maxSize' => 5*1024*1024, 'checkExtensionByMimeType' => false]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'dataFile' => 'Загружаемый файл'
		];
	}

	public function upload(){
		if($this->validate()){
			return true;
		} else{
			return false;
		}
	}
}