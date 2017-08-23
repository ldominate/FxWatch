<?php

namespace app\modules\catalog\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "fintool".
 *
 * @property integer $id
 * @property integer $fintoolgroup_id
 * @property string $name
 *
 * @property Fintoolgroup $fintoolgroup
 */
class FinTool extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fintool';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fintoolgroup_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['fintoolgroup_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fintoolgroup::className(), 'targetAttribute' => ['fintoolgroup_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fintoolgroup_id' => 'Категория финансового инструмента',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFintoolgroup()
    {
        return $this->hasOne(Fintoolgroup::className(), ['id' => 'fintoolgroup_id']);
    }

    /**
     * @inheritdoc
     * @return FinToolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FinToolQuery(get_called_class());
    }
}
