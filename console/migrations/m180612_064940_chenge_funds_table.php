<?php

use yii\db\Migration;

/**
 * Class m180612_064940_chenge_funds_table
 */
class m180612_064940_chenge_funds_table extends Migration
{
    private $public_fund = 'public_fund';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%funds}}',
            $this->public_fund,
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
