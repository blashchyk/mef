<?php

use yii\db\Migration;

class m170424_083118_catalog_field_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ctlg_field}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'type' => $this->integer(1)->unsigned()->notNull()->defaultValue(0),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
        ], $tableOptions);

        $this->createTable('{{%ctlg_product_field}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'field_id' => $this->integer()->notNull(),
            'value' => $this->string()->defaultValue(true),
        ], $tableOptions);

        $this->batchInsert('{{%ctlg_field}}', ['id', 'category_id', 'name', 'type', 'sorting', 'visible'], [
            [1, 2, 'Diagonal', 3, null, 1],
        ]);

        $this->addForeignKey('fk_ctlg_field_ctlg_category', '{{%ctlg_field}}', 'category_id', '{{%ctlg_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_ctlg_product_field_ctlg_product', '{{%ctlg_product_field}}', 'product_id', '{{%ctlg_product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_ctlg_product_field_ctlg_category', '{{%ctlg_product_field}}', 'field_id', '{{%ctlg_field}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_ctlg_product_field_ctlg_category', '{{%ctlg_product_field}}');
        $this->dropForeignKey('fk_ctlg_product_field_ctlg_product', '{{%ctlg_product_field}}');
        $this->dropForeignKey('fk_ctlg_field_ctlg_category', '{{%ctlg_field}}');

        $this->dropTable('{{%ctlg_product_field}}');
        $this->dropTable('{{%ctlg_field}}');
    }
}
