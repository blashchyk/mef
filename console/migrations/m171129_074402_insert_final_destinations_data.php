<?php

use yii\db\Migration;

class m171129_074402_insert_final_destinations_data extends Migration
{

    public function up()
    {
        $this->insert('hs_final_destination', ['abbreviation' => 'C', 'description' => 'Conservation']);
        $this->insert('hs_final_destination', ['abbreviation' => 'P', 'description' => 'Preservation']);
        $this->insert('hs_final_destination', ['abbreviation' => 'E', 'description' => 'Elimination']);
    }

    public function down()
    {
        $this->delete('hs_final_destination', ['abbreviation' => 'C', 'description' => 'Conservation']);
        $this->delete('hs_final_destination', ['abbreviation' => 'P', 'description' => 'Preservation']);
        $this->delete('hs_final_destination', ['abbreviation' => 'E', 'description' => 'Elimination']);
    }
}
