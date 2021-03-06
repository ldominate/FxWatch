<?php

namespace app\modules\catalog\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "sourcecode".
 *
 * @property string $code
 * @property integer $sourcetype_id
 * @property string $name
 * @property string $open
 * @property string $close
 *
 * @property SourceType $sourceType
 */
class SourceCode extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sourcecode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['sourcetype_id'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50],
	        [['open', 'close'], 'default', 'value' => null],
	        [['open'], 'time', 'format' => 'HH:mm:ss'],
	        [['close'], 'time', 'format' => 'HH:mm:ss'],
            [['sourcetype_id'], 'exist', 'skipOnError' => true, 'targetClass' => SourceType::className(), 'targetAttribute' => ['sourcetype_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код',
            'sourcetype_id' => 'Тип',
            'name' => 'Наименование',
	        'open' => 'Начало торгов',
	        'close' => 'Окончание торгов'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceType()
    {
        return $this->hasOne(SourceType::className(), ['id' => 'sourcetype_id']);
    }

    /**
     * @inheritdoc
     * @return SourceCodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SourceCodeQuery(get_called_class());
    }
}
