<?php

use yii\db\Migration;

class m170904_094055_profile extends Migration
{

    // Implement migration
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->defaultValue(null),
            'city' => $this->string(100)->defaultValue(null),
            'address' => $this->string(100)->defaultValue(null),
            'phone' => $this->string(50)->defaultValue(null),
            'zip' => $this->string(10)->defaultValue(null),
            'birthday' => $this->integer()->defaultValue(null),
            'gender' => $this->boolean()->notNull()->defaultValue(false),
        ], $tableOptions);

        $this->addForeignKey('fk_profile_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_profile_country', '{{%user_profile}}', 'country_id', '{{%country}}', 'id', 'SET NULL', 'CASCADE');
    }

    // Revert migration
    public function down()
    {
        $this->dropForeignKey('fk_profile_user', '{{%user_profile}}');
        $this->dropForeignKey('fk_profile_country', '{{%user_profile}}');

        $this->dropTable('{{%user_profile}}');
    }

}
