<?php

namespace app\modules\catalog\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[SourceType]].
 *
 * @see SourceType
 */
class SourceTypeQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SourceType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SourceType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
