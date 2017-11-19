<?php

use yii\db\Migration;

class m171119_075654_create_fin_data extends Migration
{
    public function safeUp()
    {
		$this->createTable('findata', [
			'id' => $this->primaryKey(),
			'sourcecode_code' => $this->string(20)->notNull()->comment('Связь с справочником фин. инструментов и валютных пар. Инструмент'),
			'datetime' => $this->timestamp()->notNull()->comment('Дата время данных торгов'),
			'open' => $this->float()->notNull()->defaultValue(0.0)->comment('Открытие'),
			'max' =>  $this->float()->notNull()->defaultValue(0.0)->comment('Максимальное'),
			'min' =>  $this->float()->notNull()->defaultValue(0.0)->comment('Минимальное'),
			'close' =>  $this->float()->notNull()->defaultValue(0.0)->comment('Закрытие'),
			'vol' =>  $this->float()->notNull()->defaultValue(0.0)->comment('Объём'),
		], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

	    $this->createIndex(
		    'idx-findata-sourcecode_code',
		    'findata',
		    'sourcecode_code'
	    );

	    $this->addForeignKey(
		    'fx-findata-sourcecode_code',
		    'findata',
		    'sourcecode_code',
		    'sourcecode',
		    'code',
		    'NO ACTION'
	    );
    }

    public function safeDown()
    {
	    $this->dropForeignKey(
		    'fx-findata-sourcecode_code',
		    'findata'
	    );

	    $this->dropIndex(
		    'idx-findata-sourcecode_code',
		    'findata'
	    );

		$this->dropTable('findata');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171119_075654_create_fin_data cannot be reverted.\n";

        return false;
    }
    */
}
