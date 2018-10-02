<?php

use yii\db\Migration;

class m160505_112500_quote_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%quote}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(null),
            'name' => $this->string(100)->notNull(),
            'image' => $this->string()->defaultValue(null),
            'description' => $this->text()->defaultValue(null),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->batchInsert('{{%quote}}', [ 'id', 'user_id', 'name', 'image', 'description', 'visible', 'sorting', 'created_at', 'updated_at'], [
            [1, 3, 'Jonh Harvey', null, 'It-master have been superb. Their customer service is great. The guys there respond very quickly and go above and beyond to help.', 1, 1, 1472115099, 1472116403],
            [2, 3, 'Jonh Stocco', null, 'It-masters did an amazing job and we wholeheartedly recommend them to all colleagues and associates as the \'full package deal\' -a team full of cuttong-edge talent, dedication, and passion for web design and development.', 1, 2, 1472116626, 1472116626],
            [3, 3, 'Jack Cole', null, 'I can\'t say enough about the excellent work that It-master has done on our website. They took a below-average website and transformmed it into an appealing and informative website. It was an absolute pleasure to work woth them. The designer listened to my thoughts and suggestions and far surpassed my expectations. I highly recommend that you use It-master to develop your website.', 1, 3, 1472116870, 1472116870]
        ]);

        $this->addForeignKey('fk_quote_user', '{{%quote}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_quote_user', '{{%quote}}');
        $this->dropTable('{{%quote}}');
    }
}
