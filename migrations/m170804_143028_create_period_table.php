<?php

use yii\db\Migration;

/**
 * Handles the creation of table `period`.
 */
class m170804_143028_create_period_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('period', [
            'id' => $this->primaryKey(),
	        'name' => $this->string(30)->notNull()->defaultValue('')
        ], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->batchInsert('period', ['name'],
	        [
		        ['1 мин'],
		        ['5 мин'],
		        ['15 мин'],
		        ['30 мин']
	        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('period');
    }
}
