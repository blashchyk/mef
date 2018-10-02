<?php

use yii\db\Migration;

/**
 * Handles the creation of table `access_requests`.
 */
class m180525_062121_create_access_requests_table extends Migration
{
    private $email = 'email';
    private $code = 'code';
    private $excel = 'excel';
    private $pdf = 'pdf';
    private $xml = 'xml';
    private $confirmation = 'confirmation';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('access_requests', [
            'id' => $this->primaryKey(),
            $this->email => $this->text()->defaultValue(null),
            $this->code => $this->string()->defaultValue(null),
            $this->excel => $this->integer(1)->defaultValue(0),
            $this->pdf => $this->integer(1)->defaultValue(0),
            $this->xml => $this->integer(1)->defaultValue(0),
            $this->confirmation => $this->integer(1)->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('access_requests');
    }
}
