<?php

namespace modules\hierarchicalStructure\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;

/**
 * This is the model class for table "{{%hs_tree_node}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $code
 * @property string $description
 * @property string $notes_application
 * @property string $notes_exclusion
 * @property int $final_destination_id
 * @property int $active
 * @property int $conservation_term
 *
 * @property HsFinalDestination $finalDestination
 * @property KartikTreeNode $kartikTreeNode
 * @property User $user
 */
class HsTreeNode extends ActiveRecord
{
    const NOTES_MAX_LENGTH = 8000;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hs_tree_node}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'final_destination_id', 'active', 'conservation_term'], 'integer'],
            [['code'], 'safe'],
            [['description', 'notes_application', 'notes_exclusion'], 'string', 'max' => self::NOTES_MAX_LENGTH ],
            [['final_destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => HsFinalDestination::className(), 'targetAttribute' => ['final_destination_id' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => KartikTreeNode::className(), 'targetAttribute' => ['id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'code' => Yii::t('app', 'Code'),
            'description' => Yii::t('app', 'Description'),
            'notes_application' => Yii::t('app', 'Notes Application'),
            'notes_exclusion' => Yii::t('app', 'Notes Exclusion'),
            'final_destination_id' => Yii::t('app', 'Final Destination'),
            'active' => Yii::t('app', 'Active'),
            'conservation_term' => Yii::t('app', 'Conservation term')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinalDestination()
    {
        return $this->hasOne(HsFinalDestination::className(), ['id' => 'final_destination_id']);
    }

    /**
     * @return string
     */
    public function getDestinationAbbreviation()
    {
        return $this->finalDestination->abbreviation;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKartikTreeNode()
    {
        return $this->hasOne(KartikTreeNode::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->kartikTreeNode->name;
    }
    public function getRecord()
    {
        return $this->hasOne(Records::className(), ['node_id' => 'id']);
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'codigo' => 'code',
            'titulo' => 'title',
            'prazoconservacaoadministrativa' => function() {
                return $this->conservation_term !== null ? $this->conservation_term : '';
            },
            'destinofinal' => function() {
                return $this->finalDestination->abbreviation !== null ? $this->finalDestination->abbreviation : '';
            },
            'descricao' => function() {
                return str_replace(["\n\r", '\n\r', "\n", '\n', "\r", '\r'], '',  strip_tags($this->description));
            },
            'notasaplicacao' => function() {
                return str_replace(["\n\r", '\n\r', "\n", '\n', "\r", '\r'], '',  strip_tags($this->notes_application));
            },
            'notasexclusao' => function() {
                return str_replace(["\n\r", '\n\r', "\n", '\n', "\r", '\r'], '',  strip_tags($this->notes_exclusion));
            },
        ];
    }

}
