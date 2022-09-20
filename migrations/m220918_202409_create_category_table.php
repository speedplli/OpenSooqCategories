<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m220918_202409_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name_en' => $this->string()->notNull(),
            'name_ar' => $this->string(),
            'parent_id' => $this->integer(),
        ]);
        $this->createIndex(
            'idx-category-parent_id',
            'category',
            'parent_id'
        );
        $this->addForeignKey(
            'fk-category-parent_id',
            'category',
            'parent_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-category-parent_id','category');
        $this->dropIndex('idx-category-parent_id', 'category');
        $this->dropTable('{{%category}}');
    }
}

