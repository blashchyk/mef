<?php

use yii\db\Migration;

class m171129_144221_hs_tree_node_add_term_of_administrative_conservation_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%hs_tree_node}}', 'conservation_term', $this->integer()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%hs_tree_node}}', 'conservation_term');
    }

}