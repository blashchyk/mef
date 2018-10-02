<?php

namespace modules\module\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\SortingBehavior;
use common\behaviors\ReadOnlyBehavior;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $slug
 * @property integer $visible
 * @property string $sorting
 */
class Module extends ActiveRecord
{
    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;

    public static function getVisibilityStatuses()
    {
        return [
            self::VISIBLE_YES => Yii::t('yii', 'Yes'),
            self::VISIBLE_NO => Yii::t('yii', 'No'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            SortingBehavior::className(),
            ReadOnlyBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sorting'], 'integer'],
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'trim'],
            [['visible'], 'boolean'],
            [['name', 'slug'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent'),
            'name' => Yii::t('app', 'Module Name'),
            'slug' => Yii::t('app', 'Slug'),
            'visible' => Yii::t('app', 'Visible'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Module::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasMany(Module::className(), ['parent_id' => 'id']);
    }

    /**
     * @param bool $visible
     * @return bool
     */
    public function setVisible($visible = true)
    {
        $this->visible = $visible;
        return $this::save(false);
    }

    /**
     * @return boolean
     */
    public function reverseVisible()
    {
        if ($this->visible) {
            return $this->setVisible(false);
        }
        return $this->setVisible();
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return self::find()->select(['name', 'id'])->where(['parent_id' => null])->indexBy('id')->column();
    }

    /**
     * @return Module[]
     */
    public static function getAvailableModules()
    {
        $user = Yii::$app->user->getIdentity();

        $activeModules = array_flip(Yii::$container->get('configManager')->allActive());
        $dbModules = self::find()
            ->where(['visible' => self::VISIBLE_YES])
            ->orderBy(['sorting' => SORT_ASC])
            ->all();

        $modules = array_filter($dbModules, function ($module) use ($user, $activeModules) {
            $modulename = strtolower($module->slug) . ".access";
            return isset($activeModules[$module->slug]) && Yii::$app->authManager->checkAccess($user->getId(), $modulename);
        });
        return $modules;
    }
}
