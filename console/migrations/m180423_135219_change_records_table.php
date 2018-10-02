<?php

use yii\db\Migration;

/**
 * Class m180423_135219_change_records_table
 */
class m180423_135219_change_records_table extends Migration
{
    private $final = 'final_date';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%records}}',
            $this->final,
            $this->string(100)
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
