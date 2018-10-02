<?php

use yii\db\Migration;

/**
 * Class m180522_075631_chenge_kartik_tree_node
 */
class m180522_075631_change_kartik_tree_node extends Migration
{
    private $fund_id = 'fund_id';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%kartik_tree_node}}',
            $this->fund_id,
            $this->integer(11)->defaultValue(null)
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
