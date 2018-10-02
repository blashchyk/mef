<?php

use yii\db\Migration;

/**
 * Class m180423_141748_chenge_funds_table
 */
class m180423_141748_chenge_funds_table extends Migration
{
    private $final = 'final_date';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%funds}}',
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
