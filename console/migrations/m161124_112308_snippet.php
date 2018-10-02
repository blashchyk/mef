<?php

use yii\db\Migration;

class m161124_112308_snippet extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%snippet}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'content' => $this->text()->notNull(),
            'visible' => $this->integer(1)->unsigned()->notNull()->defaultValue(1),
            'location' => $this->integer(1)->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createTable('{{%snippet_page}}', [
           'id' => $this->primaryKey(),
           'snippet_id' => $this->integer()->notNull(),
           'page_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_snippet_page_snippet', '{{%snippet_page}}', 'snippet_id', '{{%snippet}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_snippet_page_page', '{{%snippet_page}}', 'page_id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_snippet_page_page', '{{%snippet_page}}');
        $this->dropForeignKey('fk_snippet_page_snippet', '{{%snippet_page}}');

        $this->dropTable('{{%snippet_page}}');
        $this->dropTable('{{%snippet}}');
    }
}
