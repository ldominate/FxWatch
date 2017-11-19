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
            [['datetime'], 'safe'],
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
}
