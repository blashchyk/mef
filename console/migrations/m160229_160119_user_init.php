<?php

use yii\db\Migration;

class m160229_160119_user_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'access_token' => $this->string()->unique()->defaultValue(null),
            'email' => $this->string()->defaultValue(null),

            'first_name' => $this->string(100)->defaultValue(null),
            'last_name' => $this->string(100)->defaultValue(null),
            'avatar' => $this->string()->defaultValue(null),
            'verified' => $this->boolean()->notNull()->defaultValue(false),
            'active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),

            'last_login_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%user_auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
            'screen_name' => $this->string()->defaultValue(null),
        ], $tableOptions);

        $this->batchInsert('{{%user}}', ['id', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'access_token', 'email', 'first_name', 'last_name', 'avatar', 'verified', 'active', 'created_at', 'updated_at', 'last_login_at'], [
            [1, 'admin', 'rqCWisc52mDl44St5u8wtbgKFy_WY7mB', '$2y$13$tzZOnOzfajkeyJgGkgVxP.6BpT6acIgzkgwpCMuMLV5m/aWxXfDEW', 'pZzT7l-F5IxXEPwZodB3EPTfVmrorT2r_1452986682', null, 'admin@admin.com', 'Admin', 'Admin', null, 1, 1, 1450874841, 1452987623, 1452988429],
            [2, 'user1', 'vlrTzbhrwHQSsYIYE2N3PrFjqULGHdxQ', '$2y$13$OKfNrfLS.As/88bEt2wMledK5U8A3LHBNiVWmeBgDS80hF5K9y5K.', null, null, 'alex@gmail.com', 'Alex', 'Kotlyar', null, 1, 1, 1452969958, 1452969958, null],
            [3, 'user2', 'h564ys8a3GBmUQmB0i45jOkASeFzqmQ1', '$2y$13$oKzNEIZhmPIWh.7oO5QmB.nV/KR0mPN7uPS0wrb3l4BGvLlQ1TpFS', null, null, 'nadia@gmail.com', 'Nadia', 'Bezhan', null, 1, 1, 1452970230, 1452970230, null],
            [4, 'demo', 'rhCbK0fGb3D_gUBe6lOtYT6ESzjM9_UW', '$2y$13$j9ptu97LepvafcH572tbhOHZrc.EvvTI9VC878guh/vrCyXnRcOOa', null, null, 'demo@gmail.com', 'Demo', 'Demo', null, 1, 1, 1460381778, 1460448744, 1460448755],
        ]);

        $this->batchInsert('{{%user_auth}}', ['id', 'user_id', 'source', 'source_id', 'screen_name'], [
            [1, 2, 'vkontakte', '20206317', 'tanya_nazarchyk'],
            [2, 3, 'facebook', '879252018862360', null],
            [3, 4, 'twitter', '4792584983', 'TNazarchyk'],
            [4, 1, 'google', '110765284483580761046', null],
        ]);

        $this->addForeignKey('fk_user_auth_user', '{{%user_auth}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_auth_user', '{{%user_auth}}');

        $this->dropTable('{{%user}}');
        $this->dropTable('{{%user_auth}}');
    }
}
