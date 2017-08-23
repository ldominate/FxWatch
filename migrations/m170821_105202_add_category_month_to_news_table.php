<?php

use yii\db\Migration;

class m170821_105202_add_category_month_to_news_table extends Migration
{
    public function safeUp()
    {
		$this->addColumn('news', 'сategory_month', $this->string(10));
	    $this->addColumn('categorynews', 'is_month', $this->boolean());

		$this->execute("UPDATE categorynews c set c.name = REPLACE(c.name, '(месяц)', '([месяц])'), c.is_month = 1 WHERE c.name LIKE '%(месяц)%'");
    }

    public function safeDown()
    {
	    $this->execute("UPDATE categorynews c set c.name = REPLACE(c.name, '([месяц])', '(месяц)') WHERE c.name LIKE '%([месяц])%'");

	    $this->dropColumn('categorynews', 'is_month');
        $this->dropColumn('news', 'сategory_month');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170821_105202_add_category_month_to_news_table cannot be reverted.\n";

        return false;
    }
    */
}
