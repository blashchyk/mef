<?php

use yii\db\Migration;

/**
 * Class m180220_084204_change_final_destination_data
 */
class m180220_084204_change_final_destination_data extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->update('hs_final_destination', ['abbreviation' => 'S', 'description' => 'Sample'], ['abbreviation' => 'P', 'description' => 'Preservation']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->update('hs_final_destination', ['abbreviation' => 'P', 'description' => 'Preservation'], ['abbreviation' => 'S', 'description' => 'Sample']);
    }
}
