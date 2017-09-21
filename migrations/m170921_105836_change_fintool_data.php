<?php

use yii\db\Migration;

class m170921_105836_change_fintool_data extends Migration
{
    public function safeUp()
    {
		$this->delete('fintool', 'id IN(5,6,9,10,12,14,15,16,17,18,19,20,21,22,24,25,28,29,30)');

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
				['AUDUSD'],
				['NZDUSD'],
				['GBPJPY'],
				['GBPCHF'],
				['USDCAD'],
				['AUDNZD'],
				['AUDCAD'],
				['CHFJPY'],
				['EURAUD'],
				['EURCAD'],
				['CADJPY'],
				['EURNZD'],
				['GBPAUD'],
				['GBPCAD'],
				['AUDCHF'],
				['CADCHF'],
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
