<?php

namespace app\modules\catalog\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "period".
 *
 * @property integer $id
 * @property string $name
 */
class Period extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
        ];
    }

    /**
     * @inheritdoc
     * @return PeriodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeriodQuery(get_called_class());
    }
}
