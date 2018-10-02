<?php

use yii\db\Migration;

/**
 * Class m171228_144613_change_kartik_tree_node_collapsed_default_value
 */
class m171228_144613_change_kartik_tree_node_collapsed_default_value extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('{{%kartik_tree_node}}', 'collapsed', $this->getDb()->getSchema()->createColumnSchemaBuilder('tinyint', 1)->defaultValue(1));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->alterColumn('{{%kartik_tree_node}}', 'collapsed', $this->getDb()->getSchema()->createColumnSchemaBuilder('tinyint', 1)->defaultValue(0));
    }
}
