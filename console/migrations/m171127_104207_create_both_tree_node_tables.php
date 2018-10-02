<?php

use yii\db\Migration;

/**
 * Handles the creation of tables `kartik_tree_node` and `hs_tree_node`.
 */
class m171127_104207_create_both_tree_node_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%hs_tree}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'description' => $this->text(),
            'key' => $this->string()->unique(),
        ], $tableOptions);

        $this->createTable('{{%kartik_tree_node}}', [
            'id' => $this->primaryKey(),
            'root' => $this->integer(),
            'lft' => $this->integer(),
            'rgt' => $this->integer(),
            'lvl' => $this->integer(),
            'name' => $this->string()->notNull(),
            'icon' => $this->text(),
            'icon_type' => $this->boolean()->defaultValue(1),
            'active' => $this->boolean()->defaultValue(1),
            'selected' => $this->boolean()->defaultValue(0),
            'disabled' => $this->boolean()->defaultValue(0),
            'readonly' => $this->boolean()->defaultValue(0),
            'visible' => $this->boolean()->defaultValue(1),
            'collapsed' => $this->boolean()->defaultValue(0),
            'movable_u' => $this->boolean()->defaultValue(1),
            'movable_d' => $this->boolean()->defaultValue(1),
            'movable_l' => $this->boolean()->defaultValue(1),
            'movable_r' => $this->boolean()->defaultValue(1),
            'removable' => $this->boolean()->defaultValue(1),
            'removable_all' => $this->boolean()->defaultValue(0),
            'hs_tree_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('index_root', '{{%kartik_tree_node}}', 'root');
        $this->createIndex('index_lft', '{{%kartik_tree_node}}', 'lft');
        $this->createIndex('index_rgt', '{{%kartik_tree_node}}', 'rgt');
        $this->createIndex('index_lvl', '{{%kartik_tree_node}}', 'lvl');
        $this->createIndex('index_active', '{{%kartik_tree_node}}', 'active');

        $this->addForeignKey('fk-hs_tree_node-kartik_tree_id', '{{%kartik_tree_node}}', 'hs_tree_id', '{{%hs_tree}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%hs_final_destination}}', [
            'id' => $this->primaryKey(),
            'abbreviation' => $this->text(),
            'description' => $this->text()
        ], $tableOptions);

        $this->createTable('{{%hs_tree_node}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'code' => $this->string(),
            'description' => $this->text(),
            'notes_application' => $this->text(),
            'notes_exclusion' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'creation_date' => $this->integer(),
            'final_destination_id' => $this->integer(),
            'active' => $this->boolean()->defaultValue(1),
        ], $tableOptions);

        $this->createIndex('index_active', '{{%hs_tree_node}}', 'active');

        $this->addForeignKey('fk-hs_tree_node-user_id', '{{%hs_tree_node}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-hs_tree_node-final_destination_id', '{{%hs_tree_node}}', 'final_destination_id', '{{%hs_final_destination}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-hs_tree_node-id', '{{%hs_tree_node}}', 'id', '{{%kartik_tree_node}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('index_active', '{{%kartik_tree_node}}');
        $this->dropIndex('index_lvl', '{{%kartik_tree_node}}');
        $this->dropIndex('index_rgt', '{{%kartik_tree_node}}');
        $this->dropIndex('index_lft', '{{%kartik_tree_node}}');
        $this->dropIndex('index_root', '{{%kartik_tree_node}}');
        $this->dropForeignKey('fk-hs_tree_node-kartik_tree_id', '{{%kartik_tree_node}}');

        $this->dropIndex('index_active', '{{%hs_tree_node}}');
        $this->dropForeignKey('fk-hs_tree_node-user_id', '{{%hs_tree_node}}');
        $this->dropForeignKey('fk-hs_tree_node-final_destination_id', '{{%hs_tree_node}}');
        $this->dropForeignKey('fk-hs_tree_node-id', '{{%hs_tree_node}}');

        $this->dropTable('{{%kartik_tree_node}}');
        $this->dropTable('{{%hs_tree_node}}');
        $this->dropTable('{{%hs_tree}}');
    }
}
