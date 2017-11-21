<?php

namespace app\modules\finam\models;

use app\modules\catalog\models\SourceCode;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "findata".
 *
 * @property integer $id
 * @property string $sourcecode_code
 * @property string $datetime
 * @property double $open
 * @property double $max
 * @property double $min
 * @property double $close
 * @property double $vol
 *
 * @property Sourcecode $sourcecodeCode
 */
class FinData extends ActiveRecord
{
	const DATETIME_FORMAT = 'yyyyMMdd HHmmss',
		DATETIME_FORMAT_DB = 'yyyy-MM-dd HH:mm:ss';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'findata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sourcecode_code', 'datetime'], 'required'],

	        [['datetime'], 'trim'],
	        [['datetime'], 'datetime', 'format' => FinData::DATETIME_FORMAT, 'timestampAttribute' => 'datetime', 'timestampAttributeFormat' => FinData::DATETIME_FORMAT_DB],

            [['open', 'max', 'min', 'close', 'vol'], 'number'],
            [['sourcecode_code'], 'string', 'max' => 20],
            [['sourcecode_code'], 'exist', 'skipOnError' => true, 'targetClass' => SourceCode::className(), 'targetAttribute' => ['sourcecode_code' => 'code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sourcecode_code' => 'Связь с справочником фин. инструментов и валютных пар. Инструмент',
            'datetime' => 'Дата время данных торгов',
            'open' => 'Открытие',
            'max' => 'Максимальное',
            'min' => 'Минимальное',
            'close' => 'Закрытие',
            'vol' => 'Объём',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceCode()
    {
        return $this->hasOne(SourceCode::className(), ['code' => 'sourcecode_code']);
    }

    /**
     * @inheritdoc
     * @return FinDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FinDataQuery(get_called_class());
    }

	/**
	 * @param $dataString string
	 * @return FinData
	 */
    public static function createFinamData($dataString){

    	$finData = new FinData();

		if(empty($dataString)){
			$finData->addError('id', 'Входные данные пустые');
			return $finData;
		}
		$data = str_getcsv($dataString);

		if(!is_array($data)){
			$finData->addError('sourcecode_code', 'Не удалось распознать входные данные');
			return $finData;
		}

		if(count($data) <= 4){
			$finData->addError('sourcecode_code', 'Входных данные не достаточно для полной инициализации');
			return $finData;
		}

		$finData->sourcecode_code = $data[0];
	    $finData->datetime = $data[2].' '.$data[3];
	    $finData->open = $data[4];
	    $finData->max = $data[5];
	    $finData->min = $data[6];
	    $finData->close = $data[7];
	    $finData->vol = $data[8];

	    $finData->validate(['datetime', 'open', 'max', 'min', 'close', 'vol']);

    	return $finData;
    }
}
