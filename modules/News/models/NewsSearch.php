<?php

namespace app\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\news\models\News;

/**
 * NewsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categorynews_id', 'percent_value', 'influence_id'], 'integer'],
            [['published', 'country_code', 'currency_code', 'release'], 'safe'],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'published' => $this->published,
            'categorynews_id' => $this->categorynews_id,
            'percent_value' => $this->percent_value,
            'influence_id' => $this->influence_id,
            'fact' => $this->fact,
            'forecast' => $this->forecast,
            'deviation' => $this->deviation,
            'previous' => $this->previous,
        ]);

        $query->andFilterWhere(['like', 'country_code', $this->country_code])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code])
            ->andFilterWhere(['like', 'release', $this->release]);

        return $dataProvider;
    }
}
