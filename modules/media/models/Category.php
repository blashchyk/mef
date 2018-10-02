<?php

namespace modules\media\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\TimestampBehavior;
use common\behaviors\CreatorBehavior;
use common\behaviors\SortingBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\models\User;

/**
 * This is the model class for table "{{%media_category}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $visible
 * @property string $sorting
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Media[] $media
 * @property User $user
 */
class Category extends ActiveRecord
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
        return '{{%media_category}}';
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['user_id', 'sorting', 'created_at', 'updated_at'], 'integer'],
            [['visible'], 'boolean'],
            [['description'], 'string'],
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
            'user_id' => Yii::t('app', 'Owner'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'description' => Yii::t('app', 'Description'),
            'visible' => Yii::t('app', 'Visible'),
            'sorting' => Yii::t('app', 'Sorting'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }
}
