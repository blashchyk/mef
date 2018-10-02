<?php

use yii\db\Migration;

/**
 * Class m180426_140043_chenge_files_table
 */
class m180426_140043_chenge_files_table extends Migration
{
    private $version = 'version';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn(
            '{{%files}}',
            $this->version
        );
        $this->addColumn(
            '{{%files}}',
            $this->version,
            $this->string(5)->defaultValue(1)
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
