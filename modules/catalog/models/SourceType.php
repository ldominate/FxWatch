<?php

namespace app\modules\catalog\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "sourcetype".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 */
class SourceType extends ActiveRecord
{
	const CURRENCY_PAIRS = 0,
		FINANCIAL_INSTRUMENTS = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sourcetype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'integer'],
	        [['type'], 'in', 'range' => [SourceType::CURRENCY_PAIRS, SourceType::FINANCIAL_INSTRUMENTS]],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Идентификатор типа',
            'name' => 'Наименование',
        ];
    }

    /**
     * @inheritdoc
     * @return SourceTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SourceTypeQuery(get_called_class());
    }
}
