<?php

use yii\db\Migration;

/**
 * Class m180912_104010_chenge_funds_table
 */
class m180912_104010_chenge_funds_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn(
            '{{%funds}}',
            'final_date'
        );
        $this->addColumn(
            '{{%funds}}',
            'final_date',
            $this->string(100)->after('date')
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
