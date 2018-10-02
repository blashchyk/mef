<?php

use yii\db\Migration;

class m161205_105232_snippet_i18n extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%snippet_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'content' => $this->text()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_snippet_i18n_id_language', '{{%snippet_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_snippet_i18n_snippet', '{{%snippet_i18n}}', 'id', '{{%snippet}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_snippet_i18n_i18n_language', '{{%snippet_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_snippet_i18n_snippet', '{{%snippet_i18n}}');
        $this->dropForeignKey('fk_snippet_i18n_i18n_language', '{{%snippet_i18n}}');

        $this->dropTable('{{%snippet_i18n}}');
    }
}
