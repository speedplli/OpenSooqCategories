<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m220919_194319_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'sub_category_id' => $this->integer(),
            'price' => $this->integer(),
            'mobile' => $this->string(),
        ]);

        $this->createIndex(
            'idx-post-category_id',
            'post',
            'category_id'
        );
        $this->addForeignKey(
            'fk-post-category_id',
            'post',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-post-sub_category_id',
            'post',
            'sub_category_id'
        );
        $this->addForeignKey(
            'fk-post-sub_category_id',
            'post',
            'sub_category_id',
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
        $this->dropForeignKey('fk-post-category_id','post');
        $this->dropIndex('idx-post-category_id', 'post');
        $this->dropForeignKey('fk-post-sub_category_id','post');
        $this->dropIndex('idx-post-sub_category_id', 'post');
        $this->dropTable('{{%post}}');
    }
}










