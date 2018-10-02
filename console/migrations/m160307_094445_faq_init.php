<?php

use yii\db\Migration;

class m160307_094445_faq_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%faq_category}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'keywords' => $this->string(),
            'visible' => $this->boolean()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);
        
        $this->createTable('{{%faq_item}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'description' => $this->text()->defaultValue(null),
            'visible' => $this->boolean()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->addForeignKey('fk_faq_item_faq_category', '{{%faq_item}}', 'parent_id', '{{%faq_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_faq_item_user', '{{%faq_item}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');

        $this->addForeignKey('fk_faq_category_user', '{{%faq_category}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_faq_category_user', '{{%faq_category}}');
        $this->dropForeignKey('fk_faq_item_user', '{{%faq_item}}');
        $this->dropForeignKey('fk_faq_item_faq_category', '{{%faq_item}}');

        $this->dropTable('{{%faq_item}}');
        $this->dropTable('{{%faq_category}}');
    }
}
