<?php

use yii\db\Migration;

class m160229_160600_media_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%media_category}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(null),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'description' => $this->text()->defaultValue(null),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%media_file}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'user_id' => $this->integer()->defaultValue(null),
            'name' => $this->string(100)->defaultValue(null),
            'file' => $this->string()->notNull(),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->addForeignKey('fk_media_file_media_category', '{{%media_file}}', 'parent_id', '{{%media_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_media_file_user', '{{%media_file}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');

        $this->addForeignKey('fk_media_category_user', '{{%media_category}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_media_category_user', '{{%media_category}}');
        $this->dropForeignKey('fk_media_file_user', '{{%media_file}}');
        $this->dropForeignKey('fk_media_file_media_category', '{{%media_file}}');

        $this->dropTable('{{%media_file}}');
        $this->dropTable('{{%media_category}}');
    }
}
