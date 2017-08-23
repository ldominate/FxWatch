<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 05.08.2017
 * Time: 1:45
 */

namespace app\modules\catalog\models;


use yii\db\ActiveQuery;

class CurrencyQuery extends ActiveQuery
{
	/*public function active()
	{
		return $this->andWhere('[[status]]=1');
	}*/

	/**
	 * @inheritdoc
	 * @return Currency[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * @inheritdoc
	 * @return Currency|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}

	public function active($active = true){
		return $this->andWhere(['active' => $active]);
	}
}