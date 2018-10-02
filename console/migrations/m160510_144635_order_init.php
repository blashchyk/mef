<?php

use yii\db\Migration;

class m160510_144635_order_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'first_name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100)->notNull(),
            'country_id' => $this->integer(),
            'zip' => $this->string(10)->notNull(),
            'city' => $this->string(100)->notNull(),
            'address' => $this->string(100)->notNull(),
            'phone' => $this->string(50)->notNull(),
            'price' => $this->float()->notNull(),
            'vat_tax' => $this->integer()->defaultValue(null),
            'description' => $this->text()->defaultValue(null),
            'payment_id' => $this->string(50)->defaultValue(null),
            'transaction_id' => $this->string(50)->defaultValue(null),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'item_price' => $this->float()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_order_user', '{{%order}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_order_country', '{{%order}}', 'country_id', '{{%country}}', 'id', 'SET NULL', 'CASCADE');

        $this->addForeignKey('fk_order_item_order', '{{%order_item}}', 'order_id', '{{%order}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_item_ctlg_product', '{{%order_item}}', 'product_id', '{{%ctlg_product}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_order_item_ctlg_product', '{{%order_item}}');
        $this->dropForeignKey('fk_order_item_order', '{{%order_item}}');

        $this->dropForeignKey('fk_order_country', '{{%order}}');
        $this->dropForeignKey('fk_order_user', '{{%order}}');

        $this->dropTable('{{%order_item}}');
        $this->dropTable('{{%order}}');
    }
}
