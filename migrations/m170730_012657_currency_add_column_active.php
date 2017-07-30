<?php

use yii\db\Migration;

class m170730_012657_currency_add_column_active extends Migration
{
    public function safeUp()
    {
		$this->addColumn('currency', 'active', $this->boolean());

		$this->update('currency', ['active' => true],
			['code' => ['RUB', 'USD', 'EUR', 'JPY', 'CNY']]
		);
    }

    public function safeDown()
    {
        $this->dropColumn('currency', 'active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170730_012657_currency_add_column_active cannot be reverted.\n";

        return false;
    }
    */
}
