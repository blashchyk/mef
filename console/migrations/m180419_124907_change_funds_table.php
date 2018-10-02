<?php

use yii\db\Migration;

/**
 * Class m180419_124907_change_funds_table
 */
class m180419_124907_change_funds_table extends Migration
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
    private $hs_id = 'hs_id';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%funds}}', 'name');
        $this->dropColumn('{{%funds}}', 'description');

        $this->addColumn(
            '{{%funds}}',
            $this->code,
            $this->string(255)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->title,
            $this->string(255)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->date,
            $this->string(100)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->level_description,
            $this->string(255)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->extent_description,
            $this->text()
        );
        $this->addColumn(
            '{{%funds}}',
            $this->creator,
            $this->string(255)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->administrative_history,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->archival_history,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->trans,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->content,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->information,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->accruals,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->arrangement,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->access,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->reproduction,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->language,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->characteristics,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->aids,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->location_originals,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->location_copies,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->related_units,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->publication_note,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->note,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->archivist_note,
            $this->text()->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->rules,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->date_descriptions,
            $this->string(255)->defaultValue(null)
        );
        $this->addColumn(
            '{{%funds}}',
            $this->hs_id,
            $this->integer()->defaultValue(null)
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
