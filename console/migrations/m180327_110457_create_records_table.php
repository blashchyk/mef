<?php

use yii\db\Migration;

/**
 * Handles the creation of table `records`.
 */
class m180327_110457_create_records_table extends Migration
{
    private $code = 'code';
    private $title = 'title';
    private $date = 'date';
    private $level_description = 'level_description';
    private $extent_description = 'extent_description';
    private $creator = 'creator';
    private $administrative_history = 'administrative_history';
    private $archival_history = 'archival_history';
    private $trans = 'trans';
    private $content = 'content';
    private $information = 'information';
    private $accruals = 'accruals';
    private $arrangement = 'arrangement';
    private $access = 'access';
    private $reproduction = 'reproduction';
    private $language = 'language';
    private $characteristics = 'characteristics';
    private $aids = 'aids';
    private $location_originals = 'location_originals';
    private $location_copies = 'location_copies';
    private $related_units = 'related_units';
    private $publication_note = 'publication_note';
    private $note = 'note';
    private $archivist_note = 'archivist_note';
    private $rules = 'rules';
    private $date_descriptions = 'date_descriptions';
    private $fond_id = 'fond_id';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('records', [
            'id' => $this->primaryKey(),
            $this->code => $this->string(255),
            $this->title => $this->string(255),
            $this->date => $this->date(),
            $this->level_description => $this->string(),
            $this->extent_description => $this->text(),
            $this->creator => $this->string(255),
            $this->administrative_history => $this->text()->defaultValue(null),
            $this->archival_history => $this->text()->defaultValue(null),
            $this->trans => $this->string(255)->defaultValue(null),
            $this->content => $this->text()->defaultValue(null),
            $this->information => $this->text()->defaultValue(null),
            $this->accruals => $this->string(255)->defaultValue(null),
            $this->arrangement => $this->string(255)->defaultValue(null),
            $this->access => $this->string(255)->defaultValue(null),
            $this->reproduction => $this->string(255)->defaultValue(null),
            $this->language => $this->string(255)->defaultValue(null),
            $this->characteristics => $this->text()->defaultValue(null),
            $this->aids => $this->text()->defaultValue(null),
            $this->location_originals => $this->string(255)->defaultValue(null),
            $this->location_copies => $this->string(255)->defaultValue(null),
            $this->related_units => $this->string(255)->defaultValue(null),
            $this->publication_note => $this->text()->defaultValue(null),
            $this->note => $this->text()->defaultValue(null),
            $this->archivist_note => $this->text()->defaultValue(null),
            $this->rules => $this->string(255)->defaultValue(null),
            $this->date_descriptions => $this->string(255)->defaultValue(null),
            $this->fond_id => $this->integer()->defaultValue(null),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('records');
    }
}
