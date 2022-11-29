<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%offer}}`.
 */
class m221129_131409_create_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%offer}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'image_url' => $this->string(),
            'price' => $this->integer(),
            'creation_date' => $this->timestamp(),
        ]);

        $this->createIndex('idx_offer_author_id', 'offer', 'author_id');
        $this->addForeignKey('fk_offer_author_id', 'offer', 'author_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_offer_author_id', 'offer');
        $this->dropIndex('idx_offer_author_id', 'offer');
        $this->dropTable('{{%offer}}');
    }
}
