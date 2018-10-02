<?php

use yii\db\Migration;

/**
 * Class m180417_095544_change_files_table
 */
class m180417_095544_change_files_table extends Migration
{
    private $version = 'version';
    private $support = 'support';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%files}}', $this->version);
        $this->addColumn(
            '{{%files}}',
            $this->version,
            $this->float()->defaultValue(1)
        );
        $this->addColumn(
            '{{%files}}',
            $this->support,
            $this->integer(1)->defaultValue(1)
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
