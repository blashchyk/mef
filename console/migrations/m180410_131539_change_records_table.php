<?php

use yii\db\Migration;

/**
 * Class m180410_131539_change_records_table
 */
class m180410_131539_change_records_table extends Migration
{
    private $date = 'date';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%records}}', $this->date);
        $this->addColumn(
            '{{%records}}',
            $this->date,
            $this->string(100)->defaultValue(null)
            );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return true;
    }
}
