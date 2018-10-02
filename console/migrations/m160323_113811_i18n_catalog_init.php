<?php

use yii\db\Migration;

class m160323_113811_i18n_catalog_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ctlg_category_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(100)->defaultValue(null),
            'description' => $this->text()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%ctlg_product_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(100)->defaultValue(null),
            'description' => $this->text()->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_ctlg_category_i18n_id_language', '{{%ctlg_category_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_ctlg_category_i18n_ctlg_category', '{{%ctlg_category_i18n}}', 'id', '{{%ctlg_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_ctlg_category_i18n_i18n_language', '{{%ctlg_category_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');

        $this->addPrimaryKey('pk_ctlg_product_i18n_id_language', '{{%ctlg_product_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_ctlg_product_i18n_ctlg_product', '{{%ctlg_product_i18n}}', 'id', '{{%ctlg_product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_ctlg_product_i18n_i18n_language', '{{%ctlg_product_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_ctlg_category_i18n_ctlg_category', '{{%ctlg_category_i18n}}');
        $this->dropForeignKey('fk_ctlg_category_i18n_i18n_language', '{{%ctlg_category_i18n}}');

        $this->dropForeignKey('fk_ctlg_product_i18n_ctlg_product', '{{%ctlg_product_i18n}}');
        $this->dropForeignKey('fk_ctlg_product_i18n_i18n_language', '{{%ctlg_product_i18n}}');

        $this->dropTable('{{%ctlg_product_i18n}}');
        $this->dropTable('{{%ctlg_category_i18n}}');
    }
}
