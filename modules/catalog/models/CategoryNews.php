<?php

namespace app\modules\catalog\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "categorynews".
 *
 * @property integer $id
 * @property string $name
 */
class CategoryNews extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorynews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 155],
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
     * @return CategoryNewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryNewsQuery(get_called_class());
    }
}
