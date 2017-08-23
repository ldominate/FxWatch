<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m170805_040243_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
	        'published' => $this->timestamp()->notNull(),
			'categorynews_id' => $this->integer()->notNull(),
	        'country_code' => $this->string(2)->notNull(),
	        'currency_code' => $this->string(3)->notNull(),
	        'release' => $this->string(255)->notNull()->defaultValue(''),
	        'percent_value' => $this->boolean()->notNull()->defaultValue(false),
	        'influence_id' => $this->integer()->notNull(),
	        'fact' => $this->float()->notNull()->defaultValue(0.0),
	        'forecast' => $this->float()->notNull()->defaultValue(0.0),
	        'deviation' => $this->float()->notNull()->defaultValue(0.0),
	        'previous' => $this->float()->notNull()->defaultValue(0.0)
        ], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

	    $this->createIndex(
		    'idx-news-categorynews_id',
		    'news',
		    'categorynews_id'
	    );

	    $this->addForeignKey(
		    'fk-news-categorynews_id',
		    'news',
		    'categorynews_id',
		    'categorynews',
		    'id',
		    'NO ACTION'
	    );

	    $this->createIndex(
		    'idx-news-country_code',
		    'news',
		    'country_code'
	    );

	    $this->addForeignKey(
		    'fk-news-country_code',
		    'news',
		    'country_code',
		    'country',
		    'code',
		    'NO ACTION'
	    );

	    $this->createIndex(
		    'idx-news-currency_code',
		    'news',
		    'currency_code'
	    );

	    $this->addForeignKey(
		    'fk-news-currency_code',
		    'news',
		    'currency_code',
		    'currency',
		    'code',
		    'NO ACTION'
	    );

	    $this->createIndex(
		    'idx-news-influence_id',
		    'news',
		    'influence_id'
	    );

	    $this->addForeignKey(
		    'fk-news-influence_id',
		    'news',
		    'influence_id',
		    'influence',
		    'id',
		    'NO ACTION'
	    );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
	    $this->dropForeignKey('fk-news-categorynews_id', 'news');
	    $this->dropIndex('idx-news-categorynews_id', 'news');

	    $this->dropForeignKey('fk-news-country_code', 'news');
	    $this->dropIndex('idx-news-country_code', 'news');

	    $this->dropForeignKey('fk-news-currency_code', 'news');
	    $this->dropIndex('idx-news-currency_code', 'news');

	    $this->dropForeignKey('fk-news-influence_id', 'news');
	    $this->dropIndex('idx-news-influence_id', 'news');

        $this->dropTable('news');
    }
}
