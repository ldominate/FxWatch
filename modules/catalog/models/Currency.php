<?php

namespace app\modules\catalog\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "currency".
 *
 * @property string $code
 * @property integer $number
 * @property string $mark
 * @property string $name
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
        ];
    }
}
