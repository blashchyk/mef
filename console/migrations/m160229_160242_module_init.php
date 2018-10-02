<?php

use yii\db\Migration;

class m160229_160242_module_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%module}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
        ], $tableOptions);

        $this->batchInsert('{{%module}}', ['id', 'parent_id', 'name', 'slug', 'visible', 'sorting'], [
            //[1, null, 'Dashboard', 'dashboard', 1, 1],
            [1, null, 'Users', 'user', 1, 1],
            [2, 1, 'Roles', 'role', 1, 2],
            [3, null, 'Pages', 'page', 1, 3],
            [4, 3, 'Menus', 'menu', 1, 4],
            [5, 3, 'Snippets', 'snippet', 0, 5],
            [6, null, 'Settings', 'setting', 1, 6],
            [7, null, 'Modules', 'module', 1, 7],
            [8, null, 'Media', 'media', 1, 8],
            [9, null, 'Emails', 'mail', 1, 9],
            [10, null, 'Catalog', 'catalog', 1, 10],
            [11, 10, 'Orders', 'order', 1, 11],
            [12, null, 'FAQ', 'faq', 1, 12],
            [13, null, 'Quotes', 'quote', 1, 13],
            [14, null, 'Slider', 'slider', 1, 14],
            [15, null, 'Countries', 'country', 1, 15],
            [16, null, 'Themes', 'theme', 1, 16],
            [17, null, 'Translations', 'i18n', 1, 17],
        ]);

        $this->addForeignKey('fk_module_module', '{{%module}}', 'parent_id', '{{%module}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_module_module', '{{%module}}');

        $this->dropTable('{{%module}}');
    }
}
