<?php

namespace modules\hierarchicalStructure\models;


use modules\hierarchicalStructure\controllers\backend\FundsController;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class Records
 * @package modules\hierarchicalStructure\models
 */
class Records extends ActiveRecord
{
    const DATA = '-01-01';
    const FINAL_DATA = '-12-31';
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%records}}';
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $date = explode('-', $this->date);
        if (count($date) == 1) {
            $this->date = $date[0] . self::DATA;
        }
        $this->date = strtotime($this->date);
        if (!empty($this->final_date)) {
            $finat_date = explode('-', $this->final_date);
            if (count($finat_date) == 1) {
                $this->final_date = $finat_date[0] . self::FINAL_DATA;
            }
        }
        $this->final_date = strtotime($this->final_date);
        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['code', 'title', 'date','level_description', 'extent_description', 'creator'], 'required'],
            [
                [
                    'code',
                    'title',
                    'level_description',
                    'creator',
                    'trans',
                    'accruals',
                    'arrangement',
                    'access',
                    'reproduction',
                    'language',
                    'location_originals',
                    'location_copies',
                    'related_units',
                    'rules',
                    'date_descriptions',
                    'full_code',
                ],
                'string',
                'max' => Funds::TEXT_LIMIT
            ],
            ['date', 'validateDate'],
            ['final_date', 'validateFinalDate'],
            [
                [
                    'extent_description',
                    'archival_history',
                    'content',
                    'information',
                    'characteristics',
                    'aids',
                    'publication_note',
                    'note',
                    'archivist_note'
                ],
                'string',
                'max' => Funds::LIMIT
            ],
            [
                'administrative_history',
                'string',
                'max' => Funds::LIMIT_HISTORY
            ],
            [
                [
                    'fond_id',
                    'eliminate',
                ],
                'integer'
            ],
        ];
    }

    public function validateDate()
    {
        $this->checkDate($this->date);
    }

    /**
     * @param $date
     * @param string $attr
     */
    public function checkDate($date, $attr = 'date')
    {
        $date = explode('-', $date);
        if (count($date) === 3) {
            foreach ($date as $k => $item) {
                if ((int)$item == 0) {
                    $this->addError($attr, 'The date value is not correct');
                } elseif ($k == 1 && $item >= 13 || $item == 0) {
                    $this->addError($attr, 'The month is not entered correctly');
                } elseif ($k == 2 && ((int)$date[0]) % 4 == 0 && (int)$date[1] == 2 && $item >= 30) {
                    $this->addError($attr, 'Days can not be more than 29');
                } elseif ($k == 2 && (int)$date[1] == 2 && (int)$date[0] % 4 != 0 && $date[1] == 2 && $item > 28) {
                    $this->addError($attr, 'Days can not be more than 28');
                } elseif ($date[2] > 31) {
                    $this->addError($attr, 'Days can not be more than 31');
                }
            }
        } else {
            $this->checkYear($attr);

        }
    }

    private function checkYear($attr)
    {
        $time = \DateTime::createFromFormat("Y", $this->$attr, new \DateTimeZone("UTC"));
        $errors = \DateTime::getLastErrors();
        if (!$time || $errors['warning_count'] > 0 || $errors['error_count'] > 0) {
            $this->addError($attr, 'You have entered invalid date');
        }
    }

    /**
     * @return false|int
     */
    public function validateFinalDate()
    {
        $date_init = $this->date;
        $date_final = $this->final_date;
        $this->checkDate($this->final_date, 'final_date');
        $date = explode('-', $this->date);
        $final_date = explode('-', $this->final_date);
        if (count($date) == 1) {
            $date_init = $date[0] . self::DATA;
        }
        if (count($final_date) == 1) {
            $date_final = $final_date[0] . self::FINAL_DATA;
        }
        if (strtotime($date_final) < strtotime($date_init)) {
            $this->addError('final_date', 'The final date can not be less than the date of initialization.');
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'code' => Yii::t('app', 'Reference code'),
            'title' => Yii::t('app', 'Title'),
            'date' => Yii::t('app', 'Initial date'),
            'level_description' => Yii::t('app', 'Level of description'),
            'extent_description' => Yii::t(
                'app',
                'Extent and medium of the unit of description (quantity, bulk, or size)'
            ),
            'creator' => Yii::t('app', 'Name of creator'),
            'administrative_history' => Yii::t('app', 'Administrative / Biographical history'),
            'archival_history' => Yii::t('app', 'Archival history'),
            'trans' => Yii::t('app', 'Immediate source of acquisition or trans'),
            'content' => Yii::t('app', 'Scope and content'),
            'information' => Yii::t('app', 'Appraisal, destruction and scheduling information'),
            'accruals' => Yii::t('app', 'Accruals'),
            'arrangement' => Yii::t('app', 'System of arrangement'),
            'access' => Yii::t('app', 'Conditions governing access'),
            'reproduction' => Yii::t('app', 'Conditions governing reproduction'),
            'language' => Yii::t('app', 'Language / scripts of material'),
            'characteristics' => Yii::t('app', 'Physical characteristics and technical requirements'),
            'aids' => Yii::t('app', 'Finding aids'),
            'location_originals' => Yii::t('app', 'Existence and location of originals'),
            'location_copies' => Yii::t('app', 'Existence and location of copies'),
            'related_units' => Yii::t('app', 'Related units of description'),
            'publication_note' => Yii::t('app', 'Publication note'),
            'note' => Yii::t('app', 'Note'),
            'archivist_note' => Yii::t('app', 'Archivist\'s Note'),
            'rules' => Yii::t('app', 'Rules or Conventions'),
            'date_descriptions' => Yii::t('app', 'Date of descriptions'),
            'node' => Yii::t('app', 'Node Code'),
            'consTerm' => Yii::t('app', 'Conservation term'),
            'dateFormat' => Yii::t('app', 'Initial date'),
            'final_date' => Yii::t('app', 'Final date'),
            'full_code' => Yii::t('app', 'Full code'),
            'allCode' => Yii::t('app', 'All Code'),
            'eliminate' => Yii::t('app', 'Eliminate'),
            'allDate' => Yii::t('app', 'Date'),
            'completeRecordCode' => Yii::t('app', 'Complete Record Code'),
        ];
    }

    /**
     * @return string
     */
    public function getCompleteRecordCode()
    {
        $node_code = KartikTreeNode::getNoteCode($this->node_id);
        $fund_code = Funds::findOne($this->fond_id);
        return $fund_code->code .
            FundsController::DELIMITER .
            trim(
                $node_code,
                FundsController::DELIMITER
            ) .
            FundsController::DELIMITER_RECORDS .
            $this->code;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['record_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(HsTreeNode::className(), ['id' => 'node_id']);
    }

    /**
     * @return mixed
     */
    public function getConsTerm()
    {
         return $this->term->conservation_term;
    }

    /**
     * @return false|string
     */
    public function getDateFormat()
    {
        $dateView = date("Y-m-d", $this->date);
        $date = explode('-', date("Y-m-d", $this->date));
        if ($date[1] == '01' && $date[2] == '01') {
            return $date[0];
        }
        return $dateView;
    }

    /**
     * @return false|string
     */
    public function getFinalDate()
    {
        if (empty($this->final_date)) {
            return false;
        }
        $dateView = date("Y-m-d", $this->final_date);
        $date = explode('-', date("Y-m-d", $this->final_date));
        if ($date[1] = '12' && $date[2] == '31') {
            return $date[0];
        }
        return $dateView;
    }

    /**
     * @return string
     */
    public function getAllCode()
    {
        if (empty($this->node_id)) {
            return $this->code;
        }
        $node_code = KartikTreeNode::getNoteCode($this->node_id);
        $parent_record_code = FundsController::getCodeRecordParent($this->node_id);
        $fund_code = Funds::findOne($this->fond_id);
        return $fund_code->code
            . (!empty(str_replace('.', '', $node_code))
                ? (FundsController::DELIMITER_RECORDS . trim($node_code, FundsController::DELIMITER))
                : '')
            . (isset($parent_record_code)
                ? FundsController::DELIMITER_RECORDS . $parent_record_code
                : '')
            . FundsController::DELIMITER_RECORDS
            . $this->code;
    }

    public function getFundPublic()
    {
        return Funds::findOne($this->fond_id)->public_fund;
    }

    /**
     * @return false|string
     */
    public function getAllDate()
    {
        return $this->getDateFormat();
    }
}
