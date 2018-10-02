<?php

namespace modules\slider\models;

use Yii;
use common\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\behaviors\ImageBehavior;
use common\behaviors\CreatorBehavior;
use common\behaviors\SortingBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\behaviors\I18nBehavior;
use modules\theme\models\Theme;
use common\models\User;
use modules\i18n\models\Language;

/**
 * This is the model class for table "{{%slider}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $video_url
 * @property string $forward_url
 * @property integer $type
 * @property integer $visible
 * @property integer $position
 * @property string $button_caption
 * @property integer $sorting
 * @property integer $theme_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Theme $theme
 * @property User $user
 * @property SliderI18n[] $sliderI18ns
 * @property I18nLanguage[] $languages
 */
class Slider extends ActiveRecord
{
    const TYPE_IMAGE = 0;
    const TYPE_VIDEO = 1;

    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;

    const POSITION_LEFT = 0;
    const POSITION_CENTER = 1;
    const POSITION_RIGHT = 2;

    public static function getPositions()
    {
        return [
            self::POSITION_LEFT => Yii::t('app', 'Left'),
            self::POSITION_CENTER => Yii::t('app', 'Center'),
            self::POSITION_RIGHT => Yii::t('app', 'Right'),
        ];
    }

    public static function getTypes()
    {
        return [
            self::TYPE_IMAGE => Yii::t('app', 'Image'),
            self::TYPE_VIDEO => Yii::t('app', 'Video'),
        ];
    }

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
        return '{{%slider}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            CreatorBehavior::className(),
            SortingBehavior::className(),
            ImageBehavior::className(),
            ReadOnlyBehavior::className(),
            [
                'class'=> I18nBehavior::className(),
                'i18nModelClass' => SliderI18n::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'visible', 'position', 'sorting', 'theme_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['name', 'button_caption'], 'string', 'max' => 100],
            [['image', 'video_url', 'forward_url'], 'string', 'max' => 255],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Theme::className(), 'targetAttribute' => ['theme_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['video_url', 'url', 'defaultScheme' => 'http'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['image'], 'required',
                'when' => function ($model) { return $model->isNewRecord; },
                'whenClient' => 'function (attribute, value) { return ' . $this->isNewRecord . '; }',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Owner'),
            'name' => Yii::t('app', 'Name'),
            'image' => Yii::t('app', 'Image'),
            'description' => Yii::t('app', 'Description'),
            'video_url' => Yii::t('app', 'Video Url'),
            'forward_url' => Yii::t('app', 'Forward Url'),
            'type' => Yii::t('app', 'Type'),
            'visible' => Yii::t('app', 'Visible'),
            'position' => Yii::t('app', 'Position'),
            'button_caption' => Yii::t('app', 'Button Caption'),
            'sorting' => Yii::t('app', 'Sorting'),
            'theme_id' => Yii::t('app', 'Theme'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'imageThumbnailUrl' => Yii::t('app', 'Image'),
            'imageUrl' => Yii::t('app', 'Image Url'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Theme::className(), ['id' => 'theme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderI18ns()
    {
        return $this->hasMany(SliderI18n::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['language' => 'language'])->viaTable('{{%slider_i18n}}', ['id' => 'id']);
    }

    /**
     * @param bool $active
     * @return bool
     */
    public function setActive($active = true)
    {
        $this->visible = $active;
        return $this::save(false);
    }

    /**
     * @return boolean
     */
    public function reverseActive()
    {
        if ($this->visible) {
            return $this->setActive(false);
        }
        return $this->setActive();
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return self::getTypes()[$this->type];
    }

    /**
     * @return string
     */
    public function getPositionName($case = false)
    {
        if ($case == 'lower') {
            return strtolower(self::getPositions()[$this->position]);
        }
        return self::getPositions()[$this->position];
    }
}
