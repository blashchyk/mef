<?php

use yii\db\Migration;

class m160510_134635_i18n_slider_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%slider_i18n}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->text()->defaultValue(null),
            'button_caption' => $this->string(100)->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_slider_i18n_id_language', '{{%slider_i18n}}', ['id', 'language']);
        $this->addForeignKey('fk_slider_i18n_slider', '{{%slider_i18n}}', 'id', '{{%slider}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_slider_i18n_i18n_language', '{{%slider_i18n}}', 'language', '{{%i18n_language}}', 'language', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_slider_i18n_i18n_language', '{{%slider_i18n}}');
        $this->dropForeignKey('fk_slider_i18n_slider', '{{%slider_i18n}}');

        $this->dropTable('{{%slider_i18n}}');
    }
}
