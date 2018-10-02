<?php

use yii\db\Migration;

/**
 * Class m180620_065710_chenge_reports_files_table
 */
class m180620_065710_chenge_reports_files_table extends Migration
{
    private $file = 'file';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%reports_files}}',
            $this->file,
            $this->text()->defaultValue(null)
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
