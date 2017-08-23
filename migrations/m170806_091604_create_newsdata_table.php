<?php

use yii\db\Migration;

/**
 * Handles the creation of table `newsdata`.
 */
class m170806_091604_create_newsdata_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('newsdata', [
            'id' => $this->primaryKey(),
	        'news_id' => $this->integer()->notNull(),
	        'fintool_id' => $this->integer()->notNull(),
	        'period_id' => $this->integer()->notNull(),
	        'datetime' => $this->timestamp()->notNull(),
	        'open' => $this->float()->notNull()->defaultValue(0.0),
	        'close' => $this->float()->notNull()->defaultValue(0.0),
	        'min' => $this->float()->notNull()->defaultValue(0.0),
	        'max' => $this->float()->notNull()->defaultValue(0.0)
        ]);

	    $this->createIndex('idx-newsdata-news_id', 'newsdata', 'news_id');
	    $this->addForeignKey('fk-newsdata-news_id', 'newsdata', 'news_id', 'news', 'id', 'NO ACTION');

	    $this->createIndex('idx-newsdata-fintool_id', 'newsdata', 'fintool_id');
	    $this->addForeignKey('fk-newsdata-fintool_id', 'newsdata', 'fintool_id', 'fintool', 'id', 'NO ACTION');

	    $this->createIndex('idx-newsdata-period_id', 'newsdata', 'period_id');
	    $this->addForeignKey('fk-newsdata-period_id', 'newsdata', 'period_id', 'period', 'id', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
	    $this->dropForeignKey('fk-newsdata-news_id', 'newsdata');
	    $this->dropIndex('idx-newsdata-news_id', 'newsdata');

	    $this->dropForeignKey('fk-newsdata-fintool_id', 'newsdata');
	    $this->dropIndex('idx-newsdata-fintool_id', 'newsdata');

	    $this->dropForeignKey('fk-newsdata-period_id', 'newsdata');
	    $this->dropIndex('idx-newsdata-period_id', 'newsdata');

        $this->dropTable('newsdata');
    }
}
