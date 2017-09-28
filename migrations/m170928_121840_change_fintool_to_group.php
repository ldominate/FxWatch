<?php

use yii\db\Migration;

class m170928_121840_change_fintool_to_group extends Migration
{
    public function safeUp()
    {
	    $this->update('fintool',
		    ['fintoolgroup_id' => 1],
		    ['name' => ['EURUSD', 'GBPUSD', 'USDCHF', 'USDJPY', 'USDCAD', 'AUDUSD', 'NZDUSD']]
	    );

	    $this->update('fintool',
		    ['fintoolgroup_id' => 2],
		    ['name' => ['AUDJPY', 'EURCHF', 'EURGBP', 'EURJPY', 'GBPCHF', 'GBPJPY', 'NZDJPY']]
	    );
    }

    public function safeDown()
    {
	    $this->update('fintool',
		    ['fintoolgroup_id' => 1],
		    ['name' => ['EURUSD', 'GBPUSD', 'USDJPY', 'EURGBP', 'EURJPY', 'EURCHF']]
	    );

	    $this->update('fintool',
		    ['fintoolgroup_id' => 2],
		    ['name' => ['AUDJPY', 'NZDJPY', 'AUDUSD', 'NZDUSD', 'GBPJPY', 'GBPCHF', 'USDCAD', 'USDCHF']]
	    );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170928_121840_change_fintool_to_group cannot be reverted.\n";

        return false;
    }
    */
}
