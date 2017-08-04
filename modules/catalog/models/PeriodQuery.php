<?php

namespace app\modules\catalog\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Period]].
 *
 * @see Period
 */
class PeriodQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Period[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Period|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
