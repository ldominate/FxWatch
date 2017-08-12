<?php

namespace app\modules\news\models;

use app\modules\catalog\models\FinTool;
use app\modules\catalog\models\Period;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "newsdata".
 *
 * @property integer $id
 * @property integer $news_id
 * @property integer $fintool_id
 * @property integer $period_id
 * @property string $datetime
 * @property double $open
 * @property double $close
 * @property double $min
 * @property double $max
 *
 * @property Fintool $fintool
 * @property News $news
 * @property Period $period
 */
class NewsData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'newsdata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'fintool_id', 'period_id', 'datetime'], 'required'],
            [['news_id', 'fintool_id', 'period_id'], 'integer'],

	        [['datetime'], 'trim'],
	        [['datetime'], 'datetime', 'format' => News::DATETIME_FORMAT, 'timestampAttribute' => 'datetime', 'timestampAttributeFormat' => News::DATETIME_FORMAT_DB],

            [['open', 'close', 'min', 'max'], 'number'],

            [['fintool_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fintool::className(), 'targetAttribute' => ['fintool_id' => 'id']],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
            [['period_id'], 'exist', 'skipOnError' => true, 'targetClass' => Period::className(), 'targetAttribute' => ['period_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'Новость',
            'fintool_id' => 'Фин. инструмент',
            'period_id' => 'Период',
            'datetime' => 'Дата и время',
            'open' => 'Open',
            'close' => 'Close',
            'min' => 'Min',
            'max' => 'Max',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFintool()
    {
        return $this->hasOne(Fintool::className(), ['id' => 'fintool_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriod()
    {
        return $this->hasOne(Period::className(), ['id' => 'period_id']);
    }

    /**
     * @inheritdoc
     * @return NewsDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsDataQuery(get_called_class());
    }
}
