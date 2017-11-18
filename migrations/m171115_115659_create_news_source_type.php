<?php

use app\modules\catalog\models\SourceType;
use yii\db\Migration;

class m171115_115659_create_news_source_type extends Migration
{
    public function safeUp()
    {
		$this->createTable('sourcetype', [
			'id' => $this->primaryKey(),
			'type' => $this->integer(2)->unsigned()->notNull(),
			'name' => $this->string(50)->notNull()->defaultValue('')
		], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

		$this->batchInsert('sourcetype', ['type', 'name'],
			[
				[SourceType::CURRENCY_PAIRS, 'Валютные пары'],
				[SourceType::FINANCIAL_INSTRUMENTS, 'Финансовые инструменты']
			]);
    }

    public function safeDown()
    {
        $this->dropTable('sourcetype');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171115_115659_create_news_source_type cannot be reverted.\n";

        return false;
    }
    */
}
