<?php

use app\models\User;
use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170726_102118_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
	        'username' => $this->string(32)->notNull(),
	        'auth_key' => $this->string(32)->notNull(),
	        'password_hash' => $this->string(255)->notNull(),
	        'password_reset_token' => $this->string(255)->defaultValue(null),
	        'email' => $this->string(255)->notNull(),
	        'status' => $this->smallInteger()->notNull()->defaultValue(10),
	        'created_at' => $this->integer()->notNull(),
	        'updated_at' => $this->integer()->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->insert('user', [
        	'username' => 'admin',
	        'auth_key' => Yii::$app->security->generateRandomString(),
	        'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
			'email' => 'admin@admin.com',
	        'status' => User::STATUS_ACTIVE,
			'created_at' => time(),
	        'updated_at' => time()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
