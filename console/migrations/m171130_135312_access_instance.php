<?php

use yii\db\Migration;

class m171130_135312_access_instance extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%access_instance}}', [
            'instance_id' => $this->string(64),
            'access_type' => "ENUM('1', '2')",
            'access_id' => $this->string(64),
            'permission' => $this->integer()->defaultValue(null),
            'PRIMARY KEY(instance_id, access_type, access_id)',
        ], $tableOptions);

    }

    public function safeDown()
    {

        $this->dropTable('{{%access_instance}}');

    }
}
