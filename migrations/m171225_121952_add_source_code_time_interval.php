<?php

use yii\db\Migration;

/**
 * Class m171225_121952_add_source_code_time_interval
 */
class m171225_121952_add_source_code_time_interval extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('sourcecode', 'open', $this->time());
	    $this->addColumn('sourcecode', 'close', $this->time());

	    $this->update('sourcecode', ['open' => '5:00:00', 'close' => '17:00:00'], 'code="EURUSD"');
	    $this->update('sourcecode', ['open' => '5:00:00', 'close' => '17:00:00'], 'code="GBPUSD"');
	    $this->update('sourcecode', ['open' => '5:00:00', 'close' => '17:00:00'], 'code="USDJPY"');
	    $this->update('sourcecode', ['open' => '5:00:00', 'close' => '17:00:00'], 'code="USDCHF"');
	    $this->update('sourcecode', ['open' => '5:00:00', 'close' => '17:00:00'], 'code="AUDUSD"');
	    $this->update('sourcecode', ['open' => '5:00:00', 'close' => '17:00:00'], 'code="NZDUSD"');
	    $this->update('sourcecode', ['open' => '5:00:00', 'close' => '17:00:00'], 'code="USDCAD"');
	    $this->update('sourcecode', ['open' => '5:00:00', 'close' => '17:00:00'], 'code="USDRUB"');

	    $this->update('sourcecode', ['open' => '14:30:00', 'close' => '21:00:00'], 'code="SANDP-500"');
	    $this->update('sourcecode', ['open' => '14:30:00', 'close' => '21:20:00'], 'code="D&J-IND"');
	    $this->update('sourcecode', ['open' => '14:30:00', 'close' => '21:00:00'], 'code="NASDAQCOMP"');
	    $this->update('sourcecode', ['open' => '8:00:00', 'close' => '16:30:00'], 'code="FUTSEE-100"');
	    $this->update('sourcecode', ['open' => '8:00:00', 'close' => '16:30:00'], 'code="CAC40"');
	    $this->update('sourcecode', ['open' => '0:00:00', 'close' => '6:00:00'], 'code="N225JAP"');
	    $this->update('sourcecode', ['open' => '1:20:00', 'close' => '8:00:00'], 'code="ZHC5"');
	    $this->update('sourcecode', ['open' => '1:20:00', 'close' => '8:00:00'], 'code="SHANGHAI"');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
	    $this->dropColumn('sourcecode', 'open');
	    $this->dropColumn('sourcecode', 'close');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171225_121952_add_source_code_time_interval cannot be reverted.\n";

        return false;
    }
    */
}
