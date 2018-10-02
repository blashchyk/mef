<?php

use yii\db\Migration;

class m160229_160301_setting_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%setting}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(1)->unsigned()->notNull()->defaultValue(0),
            'value_type' => $this->integer(1)->unsigned()->notNull()->defaultValue(0),
            'title' => $this->string(100)->notNull(),
            'key' => $this->string(100)->notNull(),
            'value' => $this->string(100)->notNull(),
        ], $tableOptions);

        $this->batchInsert('{{%setting}}', ['id', 'type', 'title', 'key', 'value'], [
            [1, 1, 'Default Site Title', 'site_title', 'Company Site'],
            [2, 1, 'Default Meta Keywords', 'site_meta_keywords', 'Company Site'],
            [3, 1, 'Default Meta Description', 'site_meta_description', 'Company Site'],
            [4, 1, 'Administrator Email', 'admin_email', 'tanya.v.nazarchuk@gmail.com'],
            [5, 1, 'Administrator Name', 'admin_name', 'Admin Name'],
            [6, 0, 'Organization Address', 'contact_address', 'Sobornyi Ave, 218А, Zaporizhia, Zaporizka oblast, 69000'],
            [7, 0, 'Organization Phone', 'contact_phone', '+380(612) 584 1256'],
            [8, 0, 'Organization Mail', 'contact_mail', 'info@itmaster-soft.com'],
            [9, 0, 'Organization Fax', 'contact_fax', '+1-212-9876543'],
            [10, 0, 'Organization Twitter', 'contact_twitter', 'https://twitter.com/?lang=en'],
            [11, 0, 'Organization Web-Site', 'contact_site', 'http://hire.itmaster-soft.com'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%setting}}');
    }
}
