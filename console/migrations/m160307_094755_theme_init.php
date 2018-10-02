<?php

use yii\db\Migration;

class m160307_094755_theme_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%theme}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'default' => $this->boolean()->notNull()->defaultValue(false),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
        ], $tableOptions);

        $this->batchInsert('{{%theme}}', ['id', 'name', 'slug', 'default', 'sorting'], [
            [1, 'Basic', 'basic', 1, 1],
            [2, 'Colored', 'colored', 0, 2],
            [3, 'White', 'white', 0, 3],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%theme}}');
    }
}
