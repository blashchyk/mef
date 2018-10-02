<?php

use yii\db\Migration;

/**
 * Class m180518_135446_change_hstree_table
 */
class m180518_135446_change_hstree_table extends Migration
{
    private $type = 'type';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%hs_tree}}',
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
