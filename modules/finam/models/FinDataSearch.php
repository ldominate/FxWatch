<?php

namespace app\modules\finam\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\finam\models\FinData;

/**
 * FinDataSearch represents the model behind the search form about `app\modules\finam\models\FinData`.
 */
class FinDataSearch extends FinData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['sourcecode_code', 'datetime'], 'safe'],
            [['open', 'max', 'min', 'close', 'vol'], 'number'],
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
        $query = FinData::find();

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
            'datetime' => $this->datetime,
            'open' => $this->open,
            'max' => $this->max,
            'min' => $this->min,
            'close' => $this->close,
            'vol' => $this->vol,
        ]);

        $query->andFilterWhere(['like', 'sourcecode_code', $this->sourcecode_code]);

        return $dataProvider;
    }
}
