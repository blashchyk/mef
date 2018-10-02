<?php

use yii\db\Migration;

/**
 * Class m180531_063519_chenge_records_table
 */
class m180531_063519_chenge_records_table extends Migration
{
    private $full_code = 'full_code';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%records}}',
            $this->full_code,
            $this->string(255)->defaultValue(null)
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
