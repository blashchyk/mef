<?php

use yii\db\Migration;

/**
 * Class m180116_103858_delete_creation_fields_from_hs_tree_node
 */
class m180116_103858_delete_creation_fields_from_hs_tree_node extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%hs_tree_node}}', 'created_at');
        $this->dropColumn('{{%hs_tree_node}}', 'updated_at');
        $this->dropColumn('{{%hs_tree_node}}', 'creation_date');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->addColumn('{{%hs_tree_node}}', 'created_at', $this->integer());
        $this->addColumn('{{%hs_tree_node}}', 'updated_at', $this->integer());
        $this->addColumn('{{%hs_tree_node}}', 'creation_date', $this->integer());
    }
}
