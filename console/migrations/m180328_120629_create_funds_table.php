<?php

use yii\db\Migration;

/**
 * Handles the creation of table `funds`.
 */
class m180328_120629_create_funds_table extends Migration
{
    private $name = 'name';
    private $description = 'description';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('funds', [
            'id' => $this->primaryKey(),
            $this->name => $this->string(255),
            $this->description => $this->text()->defaultValue(null)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('funds');
    }
}
