<?php

use yii\db\Migration;

/**
 * Handles the creation of table `fintool`.
 */
class m170803_135259_create_fintool_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('fintool', [
            'id' => $this->primaryKey(),
	        'fintoolgroup_id' => $this->integer(),
	        'name' => $this->string(30)->notNull()->defaultValue('')
        ], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

	    $this->batchInsert('fintool', ['fintoolgroup_id', 'name'],
	    [
		    ['1','EURUSD'],
		    ['1','GBPUSD'],
		    ['1','USDCHF'],
		    ['1','USDJPY'],
		    ['1','AUDUSD'],
		    ['1','NZDUSD'],
		    ['1','EURGBP'],
		    ['1','EURJPY'],
		    ['1','GBPJPY'],
		    ['1','GBPCHF'],
		    ['1','EURCHF'],
		    ['1','USDCAD'],
		    ['1','AUDJPY'],
		    ['1','AUDNZD'],
		    ['1','AUDCAD'],
		    ['1','CHFJPY'],
		    ['1','EURAUD'],
		    ['1','EURCAD'],
		    ['1','CADJPY'],
		    ['1','EURNZD'],
		    ['1','GBPAUD'],
		    ['1','GBPCAD'],
		    ['1','NZDJPY'],
		    ['1','AUDCHF'],
		    ['1','CADCHF'],
		    ['1','USDRUB'],
		    ['1','EURRUB'],
		    ['1','Золото'],
		    ['1','Серебро'],
		    ['1','Нефть (Brend)']
	    ]);

	    $this->createIndex(
		    'idx-fintool-fintoolgroup_id',
		    'fintool',
		    'fintoolgroup_id'
	    );

	    $this->addForeignKey(
		    'fk-fintool-fintoolgroup_id',
		    'fintool',
		    'fintoolgroup_id',
		    'fintoolgroup',
		    'id',
		    'NO ACTION'
	    );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('fintool');
    }
}
