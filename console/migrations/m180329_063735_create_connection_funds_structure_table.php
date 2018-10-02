<?php

use yii\db\Migration;

/**
 * Handles the creation of table `connection_funds_structure`.
 */
class m180329_063735_create_connection_funds_structure_table extends Migration
{
    private $fund_id = 'fund_id';
    private $hs_id = 'hs_id';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('connection_funds_structure', [
            'id' => $this->primaryKey(),
            $this->fund_id => $this->integer(11),
            $this->hs_id => $this->integer(11),
        ]);
        $this->addForeignKey(
            'fk_connection_funds_structure_funds',
            '{{%connection_funds_structure}}',
            'fund_id',
            '{{%funds}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_connection_funds_structure_funds', '{{%connection_funds_structure}}');
        $this->dropTable('connection_funds_structure');
    }
}
