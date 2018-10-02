<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reports_files`.
 */
class m180618_094326_create_reports_files_table extends Migration
{
    private $date = 'date';
    private $data_file = 'data_file';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('reports_files', [
            'id' => $this->primaryKey(),
            $this->date => $this->string(255),
            $this->data_file => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('reports_files');
    }
}
