<?php

namespace app\modules\news\models;

use yii\db\ActiveRecord;
use app\modules\catalog\models\CategoryNews;
use app\modules\catalog\models\Country;
use app\modules\catalog\models\Currency;
use app\modules\catalog\models\Influence;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $published
 * @property integer $categorynews_id
 * @property string $country_code
 * @property string $currency_code
 * @property string $release
 * @property integer $percent_value
 * @property integer $influence_id
 * @property double $fact
 * @property double $forecast
 * @property double $deviation
 * @property double $previous
 *
 * @property CategoryNews $categorynews
 * @property Country $countryCode
 * @property Currency $currencyCode
 * @property Influence $influence
 * @property NewsData[] $newsdatas
 */
class News extends ActiveRecord
{
	const DATETIME_FORMAT = 'dd.MM.yyyy HH:mm',
			DATETIME_FORMAT_DB = 'yyyy-MM-dd HH:mm:ss';

	/**
	 * Смещение времени для выборки сопутствующих новостей. В секундах.
	 */
	const DELTA_ASSOCIATED_NEWS = 1800;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['published', 'categorynews_id', 'country_code', 'currency_code', 'influence_id', 'release', 'fact', 'forecast', 'deviation', 'previous'], 'required'],

	        [['published'], 'trim'],
	        [['published'], 'datetime', 'format' => News::DATETIME_FORMAT, 'timestampAttribute' => 'published', 'timestampAttributeFormat' => News::DATETIME_FORMAT_DB],

            [['categorynews_id', 'percent_value', 'influence_id'], 'integer'],

            [['fact', 'forecast', 'deviation', 'previous'], 'number'],
            [['country_code'], 'string', 'max' => 2],
            [['currency_code'], 'string', 'max' => 3],
            [['release'], 'string', 'max' => 255],
	        [['release'], 'trim'],

            [['categorynews_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorynews::className(), 'targetAttribute' => ['categorynews_id' => 'id']],
            [['country_code'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_code' => 'code']],
            [['currency_code'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_code' => 'code']],
            [['influence_id'], 'exist', 'skipOnError' => true, 'targetClass' => Influence::className(), 'targetAttribute' => ['influence_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'published' => 'Дата и время',
            'categorynews_id' => 'Категория',
            'country_code' => 'Страна',
            'currency_code' => 'Валюта',
            'release' => 'Выпуск',
            'percent_value' => '%',
            'influence_id' => 'Влияние',
            'fact' => 'Факт',
            'forecast' => 'Прогноз',
            'deviation' => 'Отклонение',
            'previous' => 'Предыдущее',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorynews()
    {
        return $this->hasOne(Categorynews::className(), ['id' => 'categorynews_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryCode()
    {
        return $this->hasOne(Country::className(), ['code' => 'country_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyCode()
    {
        return $this->hasOne(Currency::className(), ['code' => 'currency_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfluence()
    {
        return $this->hasOne(Influence::className(), ['id' => 'influence_id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getNewsdatas()
	{
		return $this->hasMany(NewsData::className(), ['news_id' => 'id'])->inverseOf('news');
	}

    /**
     * @inheritdoc
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }
}
