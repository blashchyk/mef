<?php

use yii\db\Migration;

/**
 * Class m180914_111717_unsupported_files_tables
 */
class m180914_111717_unsupported_files_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%unsupported_files}}',
            [
                'id' => $this->primaryKey(),
                'old_file' => $this->string()->notNull(),
                'reference_code' => $this->string()->notNull(),
                'new_file' => $this->string()->defaultValue(null)
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%unsupported_files}}');
    }

}
