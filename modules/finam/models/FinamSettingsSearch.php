<?php

namespace app\modules\finam\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FinamSettingsSearch represents the model behind the search form about `app\modules\finam\models\FinamSettings`.
 */
class FinamSettingsSearch extends FinamSettings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'market', 'em', 'apply', 'p', 'dtf', 'tmf', 'MSOR', 'mstimever', 'sep', 'sep2', 'datf', 'at', 'fsp'], 'integer'],
            [['sourcecode_code', 'from', 'to', 'f', 'e'], 'safe'],
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
        $query = FinamSettings::find();

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
            'market' => $this->market,
            'em' => $this->em,
            'apply' => $this->apply,
            'p' => $this->p,
            'dtf' => $this->dtf,
            'tmf' => $this->tmf,
            'MSOR' => $this->MSOR,
            'mstimever' => $this->mstimever,
            'sep' => $this->sep,
            'sep2' => $this->sep2,
            'datf' => $this->datf,
            'at' => $this->at,
            'fsp' => $this->fsp,
        ]);

        $query->andFilterWhere(['like', 'sourcecode_code', $this->sourcecode_code])
            ->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'to', $this->to])
            ->andFilterWhere(['like', 'f', $this->f])
            ->andFilterWhere(['like', 'e', $this->e]);

        return $dataProvider;
    }
}
