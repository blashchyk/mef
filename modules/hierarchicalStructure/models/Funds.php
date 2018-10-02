<?php

namespace modules\hierarchicalStructure\models;


use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class Funds extends ActiveRecord
{

    const LIMIT = 100000;
    const TEXT_LIMIT = 255;
    const DELIMETER = ',';
    const LIMIT_HISTORY = 100000;
    /**
     * @var array
     */
    public static $formats = [
        'pdf' => 'PDF',
        'xml' => 'XML',
        'xlsx' => 'XLSX',
        'odt' => 'ODT',
        'csv' => 'CSV',
    ];
    protected $_hsTree;
    public $format;

    /**
     * @return string
     */
    public function beforeSave($insert)
    {
        $date = explode('-', $this->date);
        if (count($date) == 1) {
            $this->date = $date[0] . Records::DATA;
        }
        if (!empty($this->final_date)) {
            $finat_date = explode('-', $this->final_date);
            if (count($finat_date) == 1) {
                $this->final_date = $finat_date[0] . Records::FINAL_DATA;
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%funds}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'code',
                    'title',
                    'date',
                    'level_description',
                    'extent_description',
                    'creator',
                    'formHsTree',
                    'keyHsTree'
                ],
                'required'
            ],
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
                    'date_descriptions'
                ],
                'string',
                'max' => self::TEXT_LIMIT
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
                'max' => self::LIMIT
            ],
            [
                'administrative_history',
                'string',
                'max' => self::LIMIT_HISTORY
            ],
            [
                'hs_id',
                'integer'
            ],
            [
                'code',
                'unique',
                'targetAttribute' => 'code'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
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
            'formHsTree' => Yii::t('app', 'HS'),
            'keyHsTree' => Yii::t('app', 'Associated HS'),
            'dateFormat' => Yii::t('app', 'Initial date'),
            'final_date' => Yii::t('app', 'Final date'),
            'nameHsTree' => Yii::t('app', 'Associated HS'),
            'public_fund' => Yii::t('app', 'Public'),
            'format' => Yii::t('app', 'Format'),
        ];
    }
    /**
     * @return false|int
     */
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
        $this->checkDate($this->final_date, 'final_date');
        if (strtotime($this->final_date) < strtotime($this->date)) {
            $this->addError('final_date', 'The final date can not be less than the date of initialization.');
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHsTree()
    {
        return $this->hasMany(HsTree::className(), ['id' => 'hs_id'])
            ->viaTable('{{%connection_funds_structure}}', ['fund_id' => 'id']);
    }

    /**
     * @param $value
     */
    public function setFormHsTree($value)
    {
        $this->_hsTree = $value;
    }

    public function getFormHsTree()
    {
        if (empty($this->_hsTree)) {
            return ArrayHelper::getColumn($this->hsTree, 'id');
        }
        return $this->_hsTree;
    }

    public function getKeyHsTree()
    {
        if (empty($this->_hsTree)) {
            $code = '';
            for ($i = 0; $i < count(ArrayHelper::getColumn($this->hsTree, 'key')); $i++) {
                $code .= ArrayHelper::getColumn($this->hsTree, 'key')[$i] . self::DELIMETER;
            }
            return substr($code, 0, -1);
        }
        return $this->_hsTree;
    }

    /**
     * @return bool|string
     */
    public function getNameHsTree()
    {
        $code = [];
        for ($i = 0; $i < count(ArrayHelper::getColumn($this->hsTree, 'key')); $i++) {
            $code[] = ArrayHelper::getColumn($this->hsTree, 'name')[$i];
        }
        return implode(self::DELIMETER, $code);
    }

    public static function viewDate($date)
    {
        $result = explode('-', $date);
        if ($result[1] == '01' && $result[2] == '01' || $result[1] == '12' && $result[2] == '31') {
            return $result[0];
        } else {
            return $date;
        }
    }

    /**
     * @return false|string
     */
    public function getDateFormat()
    {
        $dateView = $this->date;
        $date = explode('-', $this->date);
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
        $dateView = $this->final_date;
        $date = explode('-', $this->final_date);
        if ($date[1] = '12' && $date[2] == '31') {
            return $date[0];
        }
        return $dateView;
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $funds = self::find()->all();
        return ArrayHelper::map($funds, 'id', 'title');
    }

    /**
     * @return array
     */
    public static function getCode()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'code');
    }

    /**
     * @return array
     */
    public static function getPublicList()
    {
        $funds = self::find()->where(['public_fund' => 1])->all();
        return ArrayHelper::map($funds, 'id', 'title');
    }
}
