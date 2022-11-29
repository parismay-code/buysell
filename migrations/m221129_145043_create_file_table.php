<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m221129_145043_create_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'type' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%file}}');
    }
}
