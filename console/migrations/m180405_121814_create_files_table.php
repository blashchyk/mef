<?php

use yii\db\Migration;

/**
 * Handles the creation of table `files`.
 */
class m180405_121814_create_files_table extends Migration
{
    public $record_id = 'record_id';
    public $version = 'version';
    public $path = 'path';
    public $type = 'type';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('files', [
            'id' => $this->primaryKey(),
            $this->record_id => $this->integer(),
            $this->path => $this->string(255)->defaultValue(null),
            $this->version => $this->integer(11)->defaultValue(0),
            $this->type => $this->string(100)->defaultValue(null),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('files');
    }
}
