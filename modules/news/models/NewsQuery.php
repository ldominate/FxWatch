<?php

namespace app\modules\news\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class NewsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return News[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return News|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

	/**
	 * @param $id integer
	 * @param $published string
	 * @return $this News|array|null
	 */
	public function associated($id, $published){

		return $this->where(['<>', 'id', $id])
			->andWhere([
			'between',
			'published',
			Yii::$app->formatter->asDatetime(strtotime('-'.News::DELTA_ASSOCIATED_NEWS.' second '.$published), News::DATETIME_FORMAT_DB),
			Yii::$app->formatter->asDatetime(strtotime('+'.News::DELTA_ASSOCIATED_NEWS.' second '.$published), News::DATETIME_FORMAT_DB)])
			->orderBy(['published' => SORT_DESC]);
	}
}
