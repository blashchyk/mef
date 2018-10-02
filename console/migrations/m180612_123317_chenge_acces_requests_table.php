<?php

use yii\db\Migration;

/**
 * Class m180612_123317_chenge_acces_requests_table
 */
class m180612_123317_chenge_acces_requests_table extends Migration
{
    private $name = 'name';
    private $phone = 'phone';
    private $address = 'address';
    private $finality = 'finality';
    private $date = 'date';
     /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%access_requests}}',
            $this->name,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%access_requests}}',
            $this->phone,
            $this->string(100)->defaultValue(null)
        );
        $this->addColumn(
            '{{%access_requests}}',
            $this->address,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%access_requests}}',
            $this->date,
            $this->integer(11)->defaultValue(null)
        );
        $this->addColumn(
            '{{%access_requests}}',
            $this->finality,
            $this->integer(11)->defaultValue(null)
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
