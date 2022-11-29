<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m221129_130631_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->notNull(),
            'username' => $this->string()->notNull(),
            'email' => $this->string(),
            'password' => $this->string(),
            'avatar_url' => $this->string(),
            'vk_id' => $this->integer(),
            'registration_date' => $this->timestamp(),
            'access_token' => $this->string(),
            'auth_key' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
