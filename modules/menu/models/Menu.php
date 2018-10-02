<?php

namespace modules\menu\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\ReadOnlyBehavior;
use modules\page\models\Page;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $code
 * @property string $name
 *
 * @property MenuItem[] $menuItems
 * @property Page[] $pages
 */
class Menu extends ActiveRecord
{
    const TYPE_CUSTOM = 0;
    const TYPE_SYSTEM = 1;

    public static function getTypes()
    {
        return [
            self::TYPE_CUSTOM => Yii::t('app', 'Custom'),
            self::TYPE_SYSTEM => Yii::t('app', 'System'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ReadOnlyBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['code', 'name'], 'required'],
            [['code', 'name'], 'trim'],
            [['code', 'name'], 'string', 'max' => 100],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Menu Name'),
            'typeName' => Yii::t('app', 'Type Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id']);
    }

    /**
     * @return MenuItem[]
     */
    public function getRootItems()
    {
        return MenuItem::find()
            ->where(['menu_id' => $this->id, 'parent_id' => null])
            ->orderBy('sorting')
            ->all();
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return self::getTypes()[$this->type];
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        MenuItem::updateItems($this->id);
    }
}
