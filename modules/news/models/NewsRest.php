<?php
namespace app\modules\news\models;

use app\modules\catalog\models\CategoryNews;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Created by PhpStorm.
 * User: johny
 * Date: 28.08.2017
 * Time: 22:14
 */

class NewsRest extends News
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

	public function fields()
	{
		return [
			'id',
			'published',
			'categorynews' => function($model){
				return ($model->categorynews->is_month)
					? str_replace(CategoryNews::PLACEHOLDER_MONTH,
						isset($model['сategory_month']) && !empty($model->сategory_month)
							? $model->сategory_month
							: Yii::$app->formatter->asDate($model->published, 'MMMM'),
						$model->categorynews->name)
					: $model->categorynews->name;
			},
			'country_code',
			'countryCode' => function($model){
				return isset($model['countryCode']) ? $model->countryCode->name : $model->country_code;
			},
			'currency_code',
			'release',
			'сategory_month',
			'percent_value',
			'influence_id',
			'influence' => function($model){
				return isset($model['influence']) ? $model->influence->name : $model->influence;
			},
			'fact',
			'forecast',
			'deviation',
			'previous'
		];
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
		$query = self::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => $params['NewsRest']['limit'],  // ALL results, no pagination
			],
			'sort'=>[
				'defaultOrder'=>['published'=> SORT_DESC],
			]
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

        $query->with('categorynews')
			->with('countryCode');

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