<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m221129_131242_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'label' => $this->string()->notNull(),
        ]);

        $this->batchInsert(
            'category',
            ['name', 'label'],
            [
                ['home', 'Дом'],
                ['electronics', 'Электроника'],
                ['clothes', 'Одежда'],
                ['sport', 'Спорт/отдых'],
                ['cars', 'Авто'],
                ['books', 'Книги'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
