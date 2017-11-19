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

		$this->batchInsert(
			'finamsettings',
			['url', 'market', 'em', 'sourcecode_code', 'apply', 'from', 'to', 'p', 'f', 'e', 'dtf', 'tmf', 'MSOR', 'mstimever', 'sep', 'sep2', 'datf', 'at', 'fsp'],
		[
	        ['http://export.finam.ru/', 5, 83, 'EURUSD', 0, '01.01.0000', '01.01.0000', 4, 'EURUSD_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 5, 86, 'GBPUSD', 0, '01.01.0000', '01.01.0000', 4, 'GBPUSD_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 5, 87, 'USDJPY', 0, '01.01.0000', '01.01.0000', 4, 'USDJPY_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 5, 85, 'USDCHF', 0, '01.01.0000', '01.01.0000', 4, 'USDCHF_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 5, 66699, 'AUDUSD', 0, '01.01.0000', '01.01.0000', 4, 'AUDUSD_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 5, 181425, 'NZDUSD', 0, '01.01.0000', '01.01.0000', 4, 'NZDUSD_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 5, 66700, 'USDCAD', 0, '01.01.0000', '01.01.0000', 4, 'USDCAD_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 5, 901, 'USDRUB', 0, '01.01.0000', '01.01.0000', 4, 'USDRUB_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],

			['http://export.finam.ru/', 6, 90, 'SANDP-500', 0, '01.01.0000', '01.01.0000', 4, 'SANDP-500_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 6, 91, 'D&J-IND', 0, '01.01.0000', '01.01.0000', 4, 'D&J-IND_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 6, 82075, 'NASDAQCOMP', 0, '01.01.0000', '01.01.0000', 4, 'NASDAQCOMP_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 6, 93, 'FUTSEE-100', 0, '01.01.0000', '01.01.0000', 4, 'FUTSEE-100_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 6, 112, 'CAC40', 0, '01.01.0000', '01.01.0000', 4, 'CAC40_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 6, 19063, 'N225JAP', 0, '01.01.0000', '01.01.0000', 4, 'N225JAP_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 6, 111, 'ZHC5', 0, '01.01.0000', '01.01.0000', 4, 'ZHC5_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0],
			['http://export.finam.ru/', 6, 19101, 'SHANGHAI', 0, '01.01.0000', '01.01.0000', 4, 'SHANGHAI_01010000', '.csv', 1, 1, 0, 0, 1, 1, 1, 0, 0]
		]);

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
