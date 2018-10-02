<?php

namespace modules\quote\models;

use Yii;
use common\behaviors\TimestampBehavior;
use common\behaviors\ImageBehavior;
use common\behaviors\CreatorBehavior;
use common\behaviors\I18nBehavior;
use common\behaviors\SortingBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\models\User;
use modules\i18n\models\Language;

/**
 * This is the model class for table "{{%quote}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property integer $visible
 * @property integer $sorting
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Quote extends \yii\db\ActiveRecord
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
        return '{{%quote}}';
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
                'i18nModelClass' => QuoteI18n::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'visible', 'sorting', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['name'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['image'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
//            [['image'], 'required',
//                'when' => function($model) { return $model->isNewRecord; },
//                'whenClient' => 'function (attribute, value) { return ' . $this->isNewRecord . '; }'
//            ],
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
            'visible' => Yii::t('app', 'Visible'),
            'sorting' => Yii::t('app', 'Sorting'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'imageThumbnailUrl' => Yii::t('app', 'Image'),
            'imageUrl' => Yii::t('app', 'Image Url'),
        ];
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
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['language' => 'language'])->viaTable('{{%quote_i18n}}', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteI18ns()
    {
        return $this->hasMany(QuoteI18n::className(), ['id' => 'id']);
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
}
