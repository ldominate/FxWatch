<?php

use yii\db\Migration;

class m171118_044703_create_finam_settings extends Migration
{
    public function safeUp()
    {
		$this->createTable('finamsettings', [
			'id' => $this->primaryKey(),
			'url' => $this->string(255)->notNull()->comment('Ссылка на источник данных'),
			'market' => $this->integer(2)->unsigned()->comment('Мировые Индексы'),
			'em' => $this->integer()->unsigned()->comment('Инструмент'),
			'sourcecode_code' => $this->string(20)->notNull()->comment('Связь с справочником фин. инструментов и валютных пар. Инструмент'),
			'apply' => $this->integer()->comment('apply'),
			'from' => $this->string(12)->defaultValue('01.01.2000')->comment('Интервал дат. Начало'),
			'to' => $this->string(12)->defaultValue('01.01.2000')->comment('Интервал дат. Окончание'),
			'p' => $this->integer(2)->defaultValue(4)->comment('Периодичность'),
			'f' => $this->string(30)->defaultValue('ExportFileName')->comment('Имя выходного файла'),
			'e' => $this->string(10)->defaultValue('.csv')->comment('Расширение выходного файла'),
			'dtf' => $this->integer(2)->defaultValue(1)->comment('Формат даты'),
			'tmf' => $this->integer(2)->defaultValue(1)->comment('Формат времени'),
			'MSOR' => $this->integer(1)->defaultValue(1)->comment('Выдавать время. Начало/Окончание свечи'),
			'mstimever' => $this->integer(1)->defaultValue(0)->comment('Выдавать время. Московское Да/Нет'),
			'sep' => $this->integer(2)->defaultValue(1)->comment('Разделитель полей'),
			'sep2' => $this->integer(2)->defaultValue(2)->comment('Разделитель разрядов'),
			'datf' => $this->integer(2)->defaultValue(1)->comment('Формат записи в файл'),
			'at' => $this->integer(1)->defaultValue(0)->comment('Добавить заголовок в файл'),
			'fsp' => $this->integer(1)->defaultValue(0)->comment('Заполнять периоды без сделок')
		], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

//		$this->batchInsert(
//			'finamsettings',
//			['url', 'market', 'em', 'sourcecode', 'apply', 'from', 'to', 'p', 'f', 'e', 'dtf', 'tmf', 'MSOR', 'mstimever', 'sep', 'sep2', 'datf', 'at', 'fsp'],
//		[
//			['url', 'market', 'em', 'sourcecode', 'apply', 'from', 'to', 'p', 'f', 'e', 'dtf', 'tmf', 'MSOR', 'mstimever', 'sep', 'sep2', 'datf', 'at', 'fsp'],
//			['url', 'market', 'em', 'sourcecode', 'apply', 'from', 'to', 'p', 'f', 'e', 'dtf', 'tmf', 'MSOR', 'mstimever', 'sep', 'sep2', 'datf', 'at', 'fsp'],
//			['url', 'market', 'em', 'sourcecode', 'apply', 'from', 'to', 'p', 'f', 'e', 'dtf', 'tmf', 'MSOR', 'mstimever', 'sep', 'sep2', 'datf', 'at', 'fsp']
//		]);

		$this->createIndex(
			'idx-finamsettings-sourcecode_code',
			'finamsettings',
			'sourcecode_code'
		);

		$this->addForeignKey(
		'fx-finamsettings-sourcecode_code',
		'finamsettings',
		'sourcecode_code',
		'sourcecode',
		'code',
		'NO ACTION'
		);
    }

    public function safeDown()
    {
    	$this->dropForeignKey(
    		'fx-finamsettings-sourcecode_code',
		    'finamsettings'
	    );

    	$this->dropIndex(
    		'idx-finamsettings-sourcecode_code',
		    'finamsettings'
	    );

		$this->dropTable('finamsettings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171118_044703_create_finam_settings cannot be reverted.\n";

        return false;
    }
    */
}
