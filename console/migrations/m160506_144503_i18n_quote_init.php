<?php

use yii\db\Migration;

class m160506_144503_i18n_quote_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%quote_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->text()->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_quote_i18n_id_language', '{{%quote_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_quote_i18n_quote', '{{%quote_i18n}}', 'id', '{{%quote}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_quote_i18n_i18n_language', '{{%quote_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_quote_i18n_i18n_language', '{{%quote_i18n}}');
        $this->dropForeignKey('fk_quote_i18n_quote', '{{%quote_i18n}}');

        $this->dropTable('{{%quote_i18n}}');
    }
}
