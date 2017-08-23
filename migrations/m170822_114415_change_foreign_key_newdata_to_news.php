<?php

use yii\db\Migration;

class m170822_114415_change_foreign_key_newdata_to_news extends Migration
{
    public function safeUp()
    {
	    $this->dropForeignKey('fk-newsdata-news_id', 'newsdata');
	    $this->addForeignKey('fk-newsdata-news_id', 'newsdata', 'news_id', 'news', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
	    $this->dropForeignKey('fk-newsdata-news_id', 'newsdata');
	    $this->addForeignKey('fk-newsdata-news_id', 'newsdata', 'news_id', 'news', 'id', 'NO ACTION');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170822_114415_change_foreign_key_newdata_to_news cannot be reverted.\n";

        return false;
    }
    */
}
