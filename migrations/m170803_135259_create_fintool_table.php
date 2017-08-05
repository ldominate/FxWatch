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
		    ['2','USDCHF'],
		    ['1','USDJPY'],
		    ['2','AUDUSD'],
		    ['2','NZDUSD'],
		    ['1','EURGBP'],
		    ['1','EURJPY'],
		    ['2','GBPJPY'],
		    ['2','GBPCHF'],
		    ['2','EURCHF'],
		    ['2','USDCAD'],
		    ['2','AUDJPY'],
		    ['2','AUDNZD'],
		    ['2','AUDCAD'],
		    ['2','CHFJPY'],
		    ['2','EURAUD'],
		    ['2','EURCAD'],
		    ['1','CADJPY'],
		    ['2','EURNZD'],
		    ['2','GBPAUD'],
		    ['2','GBPCAD'],
		    ['2','NZDJPY'],
		    ['2','AUDCHF'],
		    ['2','CADCHF'],
		    ['1','USDRUB'],
		    ['1','EURRUB'],
		    ['3','Золото'],
		    ['3','Серебро'],
		    ['3','Нефть (Brend)']
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
	    $this->dropForeignKey(
		    'fk-fintool-fintoolgroup_id',
		    'fintool'
	    );

	    $this->dropIndex(
		    'idx-fintool-fintoolgroup_id',
		    'fintool'
	    );

        $this->dropTable('fintool');
    }
}
