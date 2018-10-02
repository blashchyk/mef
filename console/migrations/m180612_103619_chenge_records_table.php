<?php

use yii\db\Migration;

/**
 * Class m180612_103619_chenge_records_table
 */
class m180612_103619_chenge_records_table extends Migration
{
    private $public = 'public';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%records}}',
            $this->public,
            $this->integer(1)->defaultValue(0)
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return false;
    }
}
