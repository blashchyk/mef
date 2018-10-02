<?php

namespace modules\theme\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\SortingBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\components\Storage;

/**
 * This is the model class for table "{{%theme}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class Theme extends ActiveRecord
{
    private $_coverUrl = null;
    private $_coverName = 'cover.jpg';

    const THEME_BASIC = 1;

    const DEFAULT_NO = 0;
    const DEFAULT_YES = 1;

    public function __construct()
    {
        $this->_coverUrl = Yii::getAlias('@image.theme');
    }

    public static function getDefaultStatuses()
    {
        return [
            self::DEFAULT_NO => Yii::t('yii', 'No'),
            self::DEFAULT_YES => Yii::t('yii', 'Yes'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%theme}}';
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
            [['name', 'slug'], 'required'],
            [['default'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 100],
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
            'slug' => Yii::t('app', 'Slug'),
            'default' => Yii::t('app', 'Default'),
        ];
    }

    /**
     * @return Theme
     */
    public static function getDefault()
    {
        return self::find()
            ->where(['default' => self::DEFAULT_YES])
            ->one();
    }

    /**
     * @param boolean $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if ($this->default) {
            $modules = self::find()
                ->where(['default' => self::DEFAULT_YES])
                ->all();
            foreach ($modules as $module) {
                $module->default = self::DEFAULT_NO;
                $module->save();
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @param bool $default
     * @return bool
     */
    public function setAsDefault($default = true)
    {
        $this->default = $default;
        return $this::save(false);
    }

    /**
     * @return string
     */
    public function getImageUrl($isThumbnail = false)
    {
        return $this->_coverUrl . '/'
            . $this->slug . '/'
            . ($isThumbnail ? Storage::PREFIX_THUMBNAIL : '')
            . $this->_coverName;
    }

    /**
     * @return string
     */
    public function getImageThumbnailUrl()
    {
        return $this->getImageUrl(true);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }
}
