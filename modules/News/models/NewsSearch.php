<?php

namespace app\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\news\models\News;
use yii\helpers\ArrayHelper;

/**
 * NewsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class NewsSearch extends News
{
	public $published_from;
	public $published_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categorynews_id', 'percent_value', 'influence_id'], 'integer'],
            [['published', 'country_code', 'currency_code', 'release'], 'safe'],

	        [['published_from'], 'trim'],
	        [['published_from'], 'datetime', 'format' => News::DATETIME_FORMAT],

	        [['published_to'], 'trim'],
	        [['published_to'], 'datetime', 'format' => News::DATETIME_FORMAT],

            [['fact', 'forecast', 'deviation', 'previous'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

	public function attributeLabels()
	{
		return ArrayHelper::merge(parent::getAttributes(), [
			'published_from' => 'Дата с',
			'published_to' => 'Дата по',
		]);
	}

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = News::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->with('categorynews')
//	        ->with('countryCode');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'published' => !empty($this->published) ? Yii::$app->formatter->asDatetime($this->published, News::DATETIME_FORMAT_DB) : '',
            'categorynews_id' => $this->categorynews_id,
            'percent_value' => $this->percent_value,
            'influence_id' => $this->influence_id,
            'fact' => $this->fact,
            'forecast' => $this->forecast,
            'deviation' => $this->deviation,
            'previous' => $this->previous,
        ]);

        $query->andFilterWhere(['>=', 'published', !empty($this->published_from) ? Yii::$app->formatter->asDatetime($this->published_from, News::DATETIME_FORMAT_DB) : '']);
	    $query->andFilterWhere(['<=', 'published', !empty($this->published_to) ? Yii::$app->formatter->asDatetime($this->published_to, News::DATETIME_FORMAT_DB) : '']);

        $query->andFilterWhere(['like', 'country_code', $this->country_code])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code])
            ->andFilterWhere(['like', 'release', $this->release]);

        return $dataProvider;
    }
}
