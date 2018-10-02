<?php

namespace modules\hierarchicalStructure\models;

use common\behaviors\AccessBehavior;
use common\library\config\AccessInterface;
use kartik\tree\models\Tree;
use modules\hierarchicalStructure\controllers\backend\FundsController;
use Yii;
use yii\db\ActiveRecordInterface;

/**
 * This is the model class for table "{{%kartik_tree_node}}".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property string $name
 * @property string $icon
 * @property integer $icon_type
 * @property integer $active
 * @property integer $selected
 * @property integer $disabled
 * @property integer $readonly
 * @property integer $visible
 * @property integer $collapsed
 * @property integer $movable_u
 * @property integer $movable_d
 * @property integer $movable_l
 * @property integer $movable_r
 * @property integer $removable
 * @property integer $removable_all
 * @property integer $hs_tree_id
 *
 * @property HsTreeNode $hsTreeNode
 * @property HsTree $hsTree
 */
class KartikTreeNode extends Tree implements AccessInterface
{
    const TITLE_MAX_LENGTH = 500;

    public $format;
    public static $formats = [
        'pdf' => 'PDF',
        'xml' => 'XML',
        'odt' => 'ODT',
        'csv' => 'CSV',
        'xlsx' => 'XLSX',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%kartik_tree_node}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            AccessBehavior::className(),
        ]);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'root',
                    'lft',
                    'rgt',
                    'lvl',
                    'icon_type',
                    'active',
                    'selected',
                    'disabled',
                    'readonly',
                    'visible',
                    'collapsed',
                    'movable_u',
                    'movable_d',
                    'movable_l',
                    'movable_r',
                    'removable',
                    'removable_all',
                    'hs_tree_id',
                    'fund_id',
                    'type'
                ],
                'integer'
            ],
            [['name', 'hs_tree_id'], 'required'],
            [['icon'], 'string'],
            [['name'], 'string', 'max' => self::TITLE_MAX_LENGTH ],
            [['hs_tree_id'], 'exist', 'skipOnError' => true, 'targetClass' => HsTree::className(), 'targetAttribute' => ['hs_tree_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'root' => Yii::t('app', 'Root'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'lvl' => Yii::t('app', 'Lvl'),
            'name' => Yii::t('app', 'Name'),
            'icon' => Yii::t('app', 'Icon'),
            'icon_type' => Yii::t('app', 'Icon Type'),
            'active' => Yii::t('app', 'Active'),
            'selected' => Yii::t('app', 'Selected'),
            'disabled' => Yii::t('app', 'Disabled'),
            'readonly' => Yii::t('app', 'Readonly'),
            'visible' => Yii::t('app', 'Visible'),
            'collapsed' => Yii::t('app', 'Collapsed'),
            'movable_u' => Yii::t('app', 'Movable U'),
            'movable_d' => Yii::t('app', 'Movable D'),
            'movable_l' => Yii::t('app', 'Movable L'),
            'movable_r' => Yii::t('app', 'Movable R'),
            'removable' => Yii::t('app', 'Removable'),
            'removable_all' => Yii::t('app', 'Removable All'),
            'hs_tree_id' => Yii::t('app', 'Hs Tree ID'),
            'format' => Yii::t('app', 'Format'),
            'fund_id' => Yii::t('app', 'Fund'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHsTreeNode()
    {
        return $this->hasOne(HsTreeNode::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHsTree()
    {
        return $this->hasOne(HsTree::className(), ['id' => 'hs_tree_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasOne(Records::className(), ['id' => 'fond_id']);
    }

    /**
     * @param integer $hsId
     * @return \yii\db\ActiveQuery
     */
    public function getNodesByHsId($hsId)
    {
        return $this::find()->where(['hs_tree_id' => $hsId])->addOrderBy('root, lft');
    }

    /**
     * @param integer $hsId
     * @return int|string
     */
    public function getNodesCountByHsId($hsId)
    {
        return $this->getNodesByHsId($hsId)->count();
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $hsTreeNode = $insert ? new HsTreeNode() : $this->hsTreeNode;
        $hsTreeNode->loadDefaultValues();
        $hsTreeNode->load(\Yii::$app->request->post());
        # Firstly, make deal with primary keys one to one.
        $this->link('hsTreeNode', $hsTreeNode);
        # Now we can link hsNodeModel to User correctly
        /** @var ActiveRecordInterface $user */
        $user = \Yii::$app->user->getIdentity();
        $hsTreeNode->link('user', $user);
    }

    /**
     * @return string
     */
    public function getCodePath()
    {
        $codePath = '';
        $parentsNodes = $this->parents()->all();
        /* @var $parentNode \modules\hierarchicalStructure\models\KartikTreeNode */
        foreach ($parentsNodes as $parentNode) {
            $codePath .= $parentNode->hsTreeNode->code . FundsController::DELIMITER;
        }
        unset($parentsNodes);
        return $codePath.$this->hsTreeNode->code;
    }

    /**
     * @return integer $parentId
     */
    public function getParentNodeId()
    {
        $parentsNodes = $this->parents()->all();
        /* @var $parent \modules\hierarchicalStructure\models\KartikTreeNode */
        if(!empty($parentsNodes)) {
            $parent = $this->parents(1)->one();
            $parentId = (integer) $parent->id;
            return $parentId;
        }
        return 0;
    }


    /**
     * @return int
     */
    public function getUId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getUType()
    {
        return null;
    }

    /**
     * @return AccessInterface|array
     */
    public function getUParent()
    {
        return $this->parents(1)->one();
    }
    public static function getNoteCode($id)
    {
        return self::findOne($id)->getCodePath();
    }
}