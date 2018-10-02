<?php

use yii\db\Migration;

class m160313_102555_i18n_content_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'link_name' => $this->string(100)->defaultValue(null),
            'title' => $this->string(100)->defaultValue(null),
            'meta_keywords' => $this->string(100)->defaultValue(null),
            'meta_description' => $this->string(100)->defaultValue(null),
            'header' => $this->string(100)->defaultValue(null),
            'content' => $this->text()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%menu_item_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'link_name' => $this->string(100)->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%page_category_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(100)->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_page_i18n_id_language', '{{%page_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_page_i18n_page', '{{%page_i18n}}', 'id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_page_i18n_i18n_language', '{{%page_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');

        $this->addPrimaryKey('pk_menu_item_i18n_id_language', '{{%menu_item_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_menu_item_i18n_page', '{{%menu_item_i18n}}', 'id', '{{%menu_item}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_menu_item_i18n_i18n_language', '{{%menu_item_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');

        $this->addPrimaryKey('pk_page_category_i18n_id_language', '{{%page_category_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_page_category_i18n_page_category', '{{%page_category_i18n}}', 'id', '{{%page_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_page_category_i18n_i18n_language', '{{%page_category_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_page_i18n_page', '{{%page_i18n}}');
        $this->dropForeignKey('fk_page_i18n_i18n_language', '{{%page_i18n}}');

        $this->dropForeignKey('fk_menu_item_i18n_page', '{{%menu_item_i18n}}');
        $this->dropForeignKey('fk_menu_item_i18n_i18n_language', '{{%menu_item_i18n}}');

        $this->dropForeignKey('fk_page_category_i18n_page_category', '{{%page_category_i18n}}');
        $this->dropForeignKey('fk_page_category_i18n_i18n_language', '{{%page_category_i18n}}');

        $this->dropTable('{{%page_category_i18n}}');
        $this->dropTable('{{%menu_item_i18n}}');
        $this->dropTable('{{%page_i18n}}');
    }
}
