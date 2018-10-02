<?php

use yii\db\Migration;

/**
 * Class m180927_073539_update_setting_table
 */
class m180927_073539_update_setting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->batchInsert('{{%setting}}', [ 'type', 'title', 'key', 'value'], [
            [1, 'Send From', 'email_sent_from', 'admin@mef.webphpdev.site'],

        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return false;
    }
}
