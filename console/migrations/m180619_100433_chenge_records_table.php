<?php

use yii\db\Migration;

/**
 * Class m180619_100433_chenge_records_table
 */
class m180619_100433_chenge_records_table extends Migration
{
    private $report = 'report';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%records}}',
            $this->report,
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
