<?php

namespace app\modules\catalog\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[FinToolGroup]].
 *
 * @see FinToolGroup
 */
class FinToolGroupQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FinToolGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FinToolGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
