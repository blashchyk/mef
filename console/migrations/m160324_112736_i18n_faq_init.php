<?php

use yii\db\Migration;

class m160324_112736_i18n_faq_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%faq_category_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(100)->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%faq_item_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(100)->defaultValue(null),
            'description' => $this->text()->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_faq_category_i18n_id_language', '{{%faq_category_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_faq_category_i18n_faq_category', '{{%faq_category_i18n}}', 'id', '{{%faq_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_faq_category_i18n_i18n_language', '{{%faq_category_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');

        $this->addPrimaryKey('pk_faq_item_i18n_id_language', '{{%faq_item_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_faq_item_i18n_faq_item', '{{%faq_item_i18n}}', 'id', '{{%faq_item}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_faq_item_i18n_i18n_language', '{{%faq_item_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_faq_category_i18n_faq_category', '{{%faq_category_i18n}}');
        $this->dropForeignKey('fk_faq_category_i18n_i18n_language', '{{%faq_category_i18n}}');

        $this->dropForeignKey('fk_faq_item_i18n_faq_item', '{{%faq_item_i18n}}');
        $this->dropForeignKey('fk_faq_item_i18n_i18n_language', '{{%faq_item_i18n}}');

        $this->dropTable('{{%faq_item_i18n}}');
        $this->dropTable('{{%faq_category_i18n}}');
    }
}
