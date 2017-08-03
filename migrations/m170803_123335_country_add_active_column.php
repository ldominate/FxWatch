<?php

use yii\db\Migration;

class m170803_123335_country_add_active_column extends Migration
{
    public function safeUp()
    {
		$this->addColumn('country', 'active', $this->boolean());

		$this->update('country', ['active' => true],
			['code' => ['AU', 'CA', 'CH', 'CN', 'DE', 'JP', 'NZ', 'GB', 'US']]
		);
    }

    public function safeDown()
    {
        $this->dropColumn('country', 'active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_123335_country_add_active_column cannot be reverted.\n";

        return false;
    }
    */
}
