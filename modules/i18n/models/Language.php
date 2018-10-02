<?php

namespace modules\i18n\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\ReadOnlyBehavior;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $name
 * @property integer $visible
 *
 * @property Translation[] $translations
 * @property Message[] $ids
 */
class Language extends ActiveRecord
{
    const DEFAULT_LANGUAGE = 'en';

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
        return '{{%i18n_language}}';
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
            [['language', 'name'], 'required'],
            [['language'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 50],
            [['language'], 'unique'],
            [['visible'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'name' => Yii::t('app', 'Name'),
            'visible' => Yii::t('app', 'Visible'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['language' => 'language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds()
    {
        return $this->hasMany(Message::className(), ['id' => 'id'])->viaTable('{{%translation}}', ['language' => 'language']);
    }

    /**
     * @param boolean $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $ids = Message::getIds();
            $rows = [];
            foreach ($ids as $id) {
                $rows[] = [$id, $this->language];
            }

            Yii::$app->db->createCommand()->batchInsert(Translation::tableName(), ['id', 'language'], $rows)->execute();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @param bool $withDefault
     * @param null $visible
     * @return array
     */
    public static function getList($withDefault = true, $visible = null)
    {
        $query = self::find();
        if ($visible !== null) {
            $query->where(['visible' => $visible]);
        }
        if (!$withDefault) {
            $query->andWhere(['!=', 'language', self::DEFAULT_LANGUAGE]);
        }

        return $query->select(['name', 'language'])->indexBy('language')->column();
    }

    /**
     * @return array
     */
    public static function getIdList()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
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
