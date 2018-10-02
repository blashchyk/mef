<?php

use yii\db\Migration;

class m170424_083218_catalog_filter_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ctlg_filter}}', [
            'id' => $this->primaryKey(),
            'field' => $this->string(100)->notNull(),
            'type' => $this->integer(1)->unsigned()->notNull()->defaultValue(0),
            'category_id' => $this->integer()->defaultValue(null),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
        ], $tableOptions);

        $this->batchInsert('{{%ctlg_filter}}', ['id', 'field', 'type', 'category_id', 'sorting', 'visible'], [
            [1, 'name', 1, null, 1, 1],
            [2, 'price', 2, null, 2, 1],
            [3, 'user_id', 5, null, 3, 1],
            [4, 'producer', 5, null, 4, 1],
            [5, '1', 4, 2, 5, 1],
        ]);

        $this->addForeignKey('fk_ctlg_filter_ctlg_category', '{{%ctlg_filter}}', 'category_id', '{{%ctlg_category}}', 'id', 'CASCADE', 'CASCADE');
        //$this->addPrimaryKey('pk_ctlg_filter_field_category_id', '{{%ctlg_filter}}', ['field', 'category_id']);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_ctlg_filter_ctlg_category', '{{%ctlg_filter}}');

        $this->dropTable('{{%ctlg_filter}}');
    }
}
