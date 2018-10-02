<?php

namespace modules\media\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\TimestampBehavior;
use common\behaviors\ImageBehavior;
use common\behaviors\CreatorBehavior;
use common\behaviors\SortingBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\models\User;

/**
 * This is the model class for table "{{%media_file}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $user_id
 * @property string $name
 * @property string $file
 * @property integer $visible
 * @property integer $sorting
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Media extends ActiveRecord
{
    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;

    const TYPE_IMAGE = 0;
    const TYPE_VIDEO = 1;
    const TYPE_UNKNOWN = 2;

    public static $imageExtensions = ['png', 'jpg', 'jpeg', 'gif'];
    public static $videoExtensions = ['mov', 'mp4', 'webm', 'ogv', 'avi'];

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
        return '{{%media_file}}';
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
            ReadOnlyBehavior::className(),
            [
                'class' => ImageBehavior::className(),
                'fieldName' => 'file',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'user_id', 'sorting', 'created_at', 'updated_at'], 'integer'],
            [['visible'], 'boolean'],
            [['name'], 'string', 'max' => 100],
            [['file'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => implode(',', array_merge(self::$imageExtensions, self::$videoExtensions))],
            [['file'], 'required',
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
            'parent_id' => Yii::t('app', 'Category'),
            'user_id' => Yii::t('app', 'Owner'),
            'name' => Yii::t('app', 'Name'),
            'file' => Yii::t('app', 'File'),
            'visible' => Yii::t('app', 'Visible'),
            'sorting' => Yii::t('app', 'Sorting'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'imageUrl' => Yii::t('app', 'File Url'),
            'imageThumbnailUrl' => Yii::t('app', 'Thumbnail Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getType()
    {
        $pathInfo = (object) pathinfo($this->file);

        if (empty($pathInfo) || empty($pathInfo->extension)) {
            return self::TYPE_UNKNOWN;
        } elseif (in_array($pathInfo->extension, self::$imageExtensions)) {
            return self::TYPE_IMAGE;
        } elseif (in_array($pathInfo->extension, self::$videoExtensions)) {
            return self::TYPE_VIDEO;
        }

        return self::TYPE_UNKNOWN;
    }
}
