<?php

use yii\db\Migration;

/**
 * Class m180912_135757_chenge_funds_table
 */
class m180912_135757_chenge_funds_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%funds}}',
            'tree',
            $this->boolean()->defaultValue(false)
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
