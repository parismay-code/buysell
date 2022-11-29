<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%publication}}`.
 */
class m221129_131409_create_publication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%publication}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'image_url' => $this->string(),
            'price' => $this->integer(),
            'creation_date' => $this->timestamp(),
        ]);

        $this->createIndex('idx_publication_author_id', 'publication', 'author_id');
        $this->addForeignKey('fk_publication_author_id', 'publication', 'author_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_publication_author_id', 'publication');
        $this->dropIndex('idx_publication_author_id', 'publication');
        $this->dropTable('{{%publication}}');
    }
}
