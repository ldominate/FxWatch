<?php

namespace app\modules\catalog\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "currency".
 *
 * @property string $code Код буквенный
 * @property integer $number Код числовой
 * @property string $mark Знак валюты
 * @property string $name Валюта
 * @property boolean $active Активна
 */
class Currency extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'number', 'name'], 'required'],
            [['number'], 'integer'],
            [['code'], 'string', 'max' => 3],
            [['mark'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 40],
	        ['active', 'boolean'],
	        ['active', 'default', 'value' => false],
            [['number'], 'unique'],
            [['number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код буквенный',
            'number' => 'Код числовой',
            'mark' => 'Знак валюты',
            'name' => 'Валюта',
	        'active' => 'Активна'
        ];
    }

	/**
	 * @inheritdoc
	 * @return CurrencyQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new CurrencyQuery(get_called_class());
	}
}
