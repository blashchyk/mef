<?php

use yii\db\Migration;

/**
 * Class m180511_111933_change_kartik_tree_node
 */
class m180511_111933_change_kartik_tree_node extends Migration
{
    private $type = 'type';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%kartik_tree_node}}',
            $this->type,
            $this->integer(1)->defaultValue(1)
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
