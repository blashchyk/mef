<?php

use yii\db\Migration;

/**
 * Class m180614_103243_chenge_access_requests_table
 */
class m180614_103243_chenge_access_requests_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%access_requests}}', 'finality');
        $this->addColumn(
            '{{%access_requests}}',
            'finality',
            $this->string()->defaultValue(null)
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
