<?php

use yii\db\Migration;

/**
 * Class m180420_101205_change_records_table
 */
class m180420_101205_change_records_table extends Migration
{
    private $node_id = 'node_id';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%records}}',
            $this->node_id,
            $this->integer(11)
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
