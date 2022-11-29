<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%publication_category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%publication}}`
 * - `{{%category}}`
 */
class m221129_131810_create_junction_table_for_publication_and_category_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%publication_category}}', [
            'publication_id' => $this->integer(),
            'category_id' => $this->integer(),
            'PRIMARY KEY(publication_id, category_id)',
        ]);

        // creates index for column `publication_id`
        $this->createIndex(
            '{{%idx-publication_category-publication_id}}',
            '{{%publication_category}}',
            'publication_id'
        );

        // add foreign key for table `{{%publication}}`
        $this->addForeignKey(
            '{{%fk-publication_category-publication_id}}',
            '{{%publication_category}}',
            'publication_id',
            '{{%publication}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-publication_category-category_id}}',
            '{{%publication_category}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-publication_category-category_id}}',
            '{{%publication_category}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%publication}}`
        $this->dropForeignKey(
            '{{%fk-publication_category-publication_id}}',
            '{{%publication_category}}'
        );

        // drops index for column `publication_id`
        $this->dropIndex(
            '{{%idx-publication_category-publication_id}}',
            '{{%publication_category}}'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-publication_category-category_id}}',
            '{{%publication_category}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-publication_category-category_id}}',
            '{{%publication_category}}'
        );

        $this->dropTable('{{%publication_category}}');
    }
}
