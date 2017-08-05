<?php

use yii\db\Migration;

/**
 * Handles the creation of table `influence`.
 */
class m170805_025406_create_influence_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('influence', [
            'id' => $this->primaryKey(),
	        'name' => $this->string(30)->notNull()->defaultValue('')
        ], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->batchInsert('influence', ['name'],
	    [
        	['Высокое'],
		    ['Среднее'],
		    ['Низкое']
	    ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('influence');
    }
}
