<?php

use yii\db\Migration;

/**
 * Class m180612_113202_chenge_records_table
 */
class m180612_113202_chenge_records_table extends Migration
{
    private $eliminate = 'eliminate';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%records}}',
            $this->eliminate,
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
