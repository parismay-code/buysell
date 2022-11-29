<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m221129_132440_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'publication_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'creation_date' => $this->timestamp(),
        ]);

        $this->createIndex('idx_comment_author_id', 'comment', 'author_id');
        $this->addForeignKey('fk_comment_author_id', 'comment', 'author_id', 'user', 'id');

        $this->createIndex('idx_comment_publication_id', 'comment', 'publication_id');
        $this->addForeignKey('fk_comment_publication_id', 'comment', 'publication_id', 'publication', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_comment_author_id', 'comment');
        $this->dropIndex('idx_comment_author_id', 'comment');
        $this->dropForeignKey('fk_comment_publication_id', 'comment');
        $this->dropIndex('idx_comment_publication_id', 'comment');
        $this->dropTable('{{%comment}}');
    }
}
