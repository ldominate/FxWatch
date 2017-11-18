<?php

namespace app\modules\catalog\models;

/**
 * This is the ActiveQuery class for [[SourceCode]].
 *
 * @see SourceCode
 */
class SourceCodeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SourceCode[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SourceCode|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
