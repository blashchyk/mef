<?php

namespace modules\hierarchicalStructure\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%hs_tree}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $key
 *
 * @property KartikTreeNode[] $kartikTreeNodes
 */
class HsTree extends ActiveRecord
{
    const NAME_MIN_LENGTH = 2;
    const NAME_MAX_LENGTH = 100;

    const KEY_MIN_LENGTH = 3;
    const KEY_MAX_LENGTH = 16;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hs_tree}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'key'], 'required'],
            ['name', 'unique', 'targetAttribute' => 'name'],
            [['key'], 'match',
                'pattern' => '/^[a-zA-Z0-9]{' . self::KEY_MIN_LENGTH . ',' . self::KEY_MAX_LENGTH . '}$/',
                'message' => Yii::t('app',
                    'Key string should contain min. ' .
                     self::KEY_MIN_LENGTH . ' and max. ' .
                     self::KEY_MAX_LENGTH . ' characters (any letters of the Latin alphabet and any numbers)')],
            ['key', 'unique', 'targetAttribute' => 'key'],
            [['name'], 'string', 'min'=> self::NAME_MIN_LENGTH, 'max' => self::NAME_MAX_LENGTH ],
            [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'key' => Yii::t('app', 'Key'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKartikTreeNodes()
    {
        return $this->hasMany(KartikTreeNode::className(), ['hs_tree_id' => 'id']);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function getNameById($id)
    {
        $hs = self::findOne((int) $id);
        return $hs->name;
    }


    /**
     * @return $this
     */
    public function getFunds()
    {
        return $this->hasMany(Funds::className(), ['id' => 'fund_id'])
            ->viaTable('{{%connection_funds_structure}}', ['hs_id' => 'id']);
    }

    /**
     * @param string $keyField
     * @param string $valueField
     * @param bool $asArray
     * @return array
     */
    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->where(['type' => 1])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

    /**
     * @return array
     */
    public function getList()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
          'name',
          'description',
          'key',
        ];
    }
}
