<?php

namespace app\modules\catalog\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "influence".
 *
 * @property integer $id Идентификатор
 * @property string $name Наименование
 */
class Influence extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'influence';
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
     * @return InfluenceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InfluenceQuery(get_called_class());
    }
}
