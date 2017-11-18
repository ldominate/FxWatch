<?php

use yii\db\Migration;

class m171118_031454_create_source_code extends Migration
{
    public function safeUp()
    {
		$this->createTable('sourcecode', [
			'code' => $this->string(20)->notNull(),
			'sourcetype_id' => $this->integer(),
			'name' => $this->string(50)->notNull()->defaultValue('')
		], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

		$this->batchInsert('sourcecode', ['code', 'sourcetype_id', 'name'],
		[
			['EURUSD', 1, 'EURUSD'],
			['GBPUSD', 1, 'GBPUSD'],
			['USDJPY', 1, 'USDJPY'],
			['USDCHF', 1, 'USDCHF'],
			['AUDUSD', 1, 'AUDUSD'],
			['NZDUSD', 1, 'NZDUSD'],
			['USDCAD', 1, 'USDCAD'],
			['USDRUB', 1, 'USDRUB'],
			['SANDP-500', 2, 'S&P 500'],
			['D&J-IND', 2, 'Dow Jones'],
			['NASDAQCOMP', 2, 'NASDAQ'],
			['FUTSEE-100', 2, 'FTSE 100'],
			['CAC40', 2, 'CAC 40'],
			['N225JAP', 2, 'Nikkei 225'],
			['ZHC5', 2, 'Hang Seng'],
			['SHANGHAI', 2, 'Shanghai'],
		]);

		$this->addPrimaryKey('code', 'sourcecode', 'code');

		$this->createIndex(
		'idx-sourcecode-sourcetype_id',
		'sourcecode',
		'sourcetype_id'
		);

		$this->addForeignKey(
		'fx-sourcecode-sourcetype_id',
		'sourcecode',
		'sourcetype_id',
		'sourcetype',
		'id',
		'NO ACTION'
		);
    }

    public function safeDown()
    {
    	$this->dropForeignKey(
    	'fx-sourcecode-sourcetype_id',
		'sourcecode'
	    );

    	$this->dropIndex(
    	'idx-sourcecode-sourcetype_id',
	    'sourcecode'
	    );

        $this->dropTable('sourcecode');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171118_031454_create_source_code cannot be reverted.\n";

        return false;
    }
    */
}
