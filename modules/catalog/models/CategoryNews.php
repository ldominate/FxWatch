<?php

namespace app\modules\catalog\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "categorynews".
 *
 * @property integer $id
 * @property string $name
 * @property boolean $is_month
 */
class CategoryNews extends ActiveRecord
{
	const PLACEHOLDER_MONTH = '[месяц]';

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
	        [['is_month'], 'default', 'value' => false],
	        [['is_month'], 'boolean']
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
	        'is_month' => 'В названии метка месяца'
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
