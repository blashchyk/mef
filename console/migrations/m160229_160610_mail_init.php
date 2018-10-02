<?php

use yii\db\Migration;

class m160229_160610_mail_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mail}}', [
            'id' => $this->primaryKey(),
            'sender_email' => $this->string()->defaultValue(null),
            'sender_name' => $this->string()->defaultValue(null),
            'subject' => $this->string()->defaultValue(null),
            'body' => $this->text()->defaultValue(null),
            'opened' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%mail}}');
    }
}
