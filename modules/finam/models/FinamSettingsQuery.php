<?php

namespace app\modules\finam\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[FinamSettings]].
 *
 * @see FinamSettings
 */
class FinamSettingsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FinamSettings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FinamSettings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
