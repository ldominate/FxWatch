<?php

namespace app\modules\news\models;

/**
 * This is the ActiveQuery class for [[NewsData]].
 *
 * @see NewsData
 */
class NewsDataQuery extends \yii\db\ActiveQuery
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
}
