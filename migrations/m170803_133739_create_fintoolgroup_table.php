<?php

use yii\db\Migration;

/**
 * Handles the creation of table `fintoolgroup`.
 */
class m170803_133739_create_fintoolgroup_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('fintoolgroup', [
            'id' => $this->primaryKey(),
	        'name' => $this->string(50)->notNull()->defaultValue('')
        ],'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

	    $this->batchInsert('fintoolgroup', ['name'],
		 [
		 	['Основные валюты'],
			['Вспомогательные валюты'],
			['Товары']
		 ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('fintoolgroup');
    }
}
