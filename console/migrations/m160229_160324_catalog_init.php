<?php

use yii\db\Migration;

class m160229_160324_catalog_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ctlg_category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'user_id' => $this->integer()->defaultValue(null),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'description' => $this->text()->defaultValue(null),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%ctlg_product}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'user_id' => $this->integer()->defaultValue(null),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'producer' => $this->string(100)->defaultValue(null),
            'image' => $this->string()->defaultValue(null),
            'price' => $this->float()->defaultValue(null), // ???
            'description' => $this->text()->defaultValue(null),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->batchInsert('{{%ctlg_category}}', ['id', 'parent_id', 'user_id', 'name', 'slug', 'description', 'visible', 'sorting', 'created_at', 'updated_at'], [
            [1, null, 1, 'Smartphones', 'smartphones', '', 1, 1, 1458636576, 1458636576],
            [2, null, 1, 'Laptops', 'laptops', '', 1, 2, 1458636587, 1458636587],
            [3, null, 1, 'Tablets', 'tablets', '', 1, 3, 1458636605, 1458636605],
            [4, null, 1, 'Gadgets', 'gadgets', '', 1, 4, 1458636624, 1458636624],
            [5, null, 1, 'Headphones', 'headphones', '', 1, 5, 1458637153, 1458637153],
            [6, null, 1, 'Printers', 'printers', '', 1, 6, 1458636897, 1458636897],
            [7, null, 1, 'Camera', 'camera', '', 1, 7, 1458637307, 1458637307],
        ]);

        $this->addForeignKey('fk_ctlg_category_ctlg_category', '{{%ctlg_category}}', 'parent_id', '{{%ctlg_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_ctlg_category_user', '{{%ctlg_category}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');

        $this->addForeignKey('fk_ctlg_product_ctlg_category', '{{%ctlg_product}}', 'parent_id', '{{%ctlg_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_ctlg_product_user', '{{%ctlg_product}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_ctlg_product_user', '{{%ctlg_product}}');
        $this->dropForeignKey('fk_ctlg_product_ctlg_category', '{{%ctlg_product}}');
        $this->dropForeignKey('fk_ctlg_category_user', '{{%ctlg_category}}');
        $this->dropForeignKey('fk_ctlg_category_ctlg_category', '{{%ctlg_category}}');

        $this->dropTable('{{%ctlg_product}}');
        $this->dropTable('{{%ctlg_category}}');
    }
}
