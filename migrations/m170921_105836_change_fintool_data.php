<?php

use yii\db\Migration;

class m170921_105836_change_fintool_data extends Migration
{
    public function safeUp()
    {
		$this->delete('fintool', 'name IN(
		"Золото",
		"Нефть (Brend)",
		"Серебро",
		"AUDCAD",
		"AUDCHF",
		"AUDNZD",
		"CADCHF",
		"CADJPY",
		"CHFJPY",
		"EURAUD",
		"EURCAD",
		"EURNZD",
		"GBPAUD",
		"GBPCAD",
		"EURRUB",
		"USDRUB")');

	    $this->delete('fintoolgroup', 'id = 3');
    }

    public function safeDown()
    {
	    $this->batchInsert('fintoolgroup', ['name'],
		    [
			    ['Товары']
		    ]);
	    $this->batchInsert('fintool', ['name'],
		    [
				['AUDCAD'],
				['AUDCHF'],
				['AUDNZD'],
				['CADCHF'],
				['CADJPY'],
				['CHFJPY'],
				['EURAUD'],
				['EURCAD'],
				['EURNZD'],
				['GBPAUD'],
				['GBPCAD'],
			    ['EURRUB'],
			    ['USDRUB'],
			    ['Золото'],
				['Серебро'],
                ['Нефть (Brend)'],
		    ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170921_105836_change_fintool_data cannot be reverted.\n";

        return false;
    }
    */
}
