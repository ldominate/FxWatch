<?php

namespace app\modules\catalog\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CategoryNews]].
 *
 * @see CategoryNews
 */
class CategoryNewsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CategoryNews[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CategoryNews|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
