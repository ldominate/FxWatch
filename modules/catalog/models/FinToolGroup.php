<?php

namespace app\modules\catalog\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "fintoolgroup".
 *
 * @property integer $id
 * @property string $name
 */
class FinToolGroup extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fintoolgroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'name' => 'Наименование',
        ];
    }

    /**
     * @inheritdoc
     * @return FinToolGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FinToolGroupQuery(get_called_class());
    }
}
