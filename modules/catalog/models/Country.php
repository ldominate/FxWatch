<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $code
 * @property string $lcode
 * @property string $currency_id
 * @property string $name
 * @property string $timezone
 *
 * @property Currency $currency
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 2],

            [['lcode', 'currency_id'], 'string', 'max' => 3],

            [['name'], 'string', 'max' => 64],

            [['timezone'], 'string', 'max' => 40],

            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код',
            'lcode' => 'Расширенный код',
            'currency_id' => 'Валюта',
            'name' => 'Название',
            'timezone' => 'Временная зона',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['code' => 'currency_id']);
    }

    /**
     * @inheritdoc
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}
