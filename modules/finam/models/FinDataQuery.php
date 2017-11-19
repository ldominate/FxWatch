<?php

namespace app\modules\finam\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[FinData]].
 *
 * @see FinData
 */
class FinDataQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FinData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FinData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
