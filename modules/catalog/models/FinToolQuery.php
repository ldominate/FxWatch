<?php

namespace app\modules\catalog\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[FinTool]].
 *
 * @see FinTool
 */
class FinToolQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FinTool[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FinTool|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
