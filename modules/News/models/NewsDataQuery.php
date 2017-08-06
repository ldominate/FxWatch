<?php

namespace app\modules\news\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[NewsData]].
 *
 * @see NewsData
 */
class NewsDataQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NewsData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

	/**
	 * @param $news_id
	 * @param $fintool_id
	 * @param $period_id
	 * @return NewsDataQuery
	 */
    public function thatnews($news_id, $fintool_id, $period_id){

    	return $this->andWhere(['news_id' => $news_id])
		    ->andWhere(['fintool_id' => $fintool_id])
		    ->andWhere(['period_id' => $period_id]);
    }
}
