<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%offer_category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%offer}}`
 * - `{{%category}}`
 */
class m221129_131810_create_junction_table_for_offer_and_category_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%offer_category}}', [
            'offer_id' => $this->integer(),
            'category_id' => $this->integer(),
            'PRIMARY KEY(offer_id, category_id)',
        ]);

        // creates index for column `offer_id`
        $this->createIndex(
            '{{%idx-offer_category-offer_id}}',
            '{{%offer_category}}',
            'offer_id'
        );

        // add foreign key for table `{{%offer}}`
        $this->addForeignKey(
            '{{%fk-offer_category-offer_id}}',
            '{{%offer_category}}',
            'offer_id',
            '{{%offer}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-offer_category-category_id}}',
            '{{%offer_category}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-offer_category-category_id}}',
            '{{%offer_category}}',
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
        // drops foreign key for table `{{%offer}}`
        $this->dropForeignKey(
            '{{%fk-offer_category-offer_id}}',
            '{{%offer_category}}'
        );

        // drops index for column `offer_id`
        $this->dropIndex(
            '{{%idx-offer_category-offer_id}}',
            '{{%offer_category}}'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-offer_category-category_id}}',
            '{{%offer_category}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-offer_category-category_id}}',
            '{{%offer_category}}'
        );

        $this->dropTable('{{%offer_category}}');
    }
}
