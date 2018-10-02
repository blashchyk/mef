<?php

namespace modules\snippet\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\behaviors\I18nBehavior;
use modules\i18n\models\Language;

/**
 * This is the model class for table "{{%snippet}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $content
 * @property string $visible
 * @property integer $location
 *
 * @property SnippetPage[] $snippetPages
 * @property SnippetI18n[] $snippetI18ns
 * @property Language[] $languages
 */
class Snippet extends ActiveRecord
{
    /*private $i18nAttributes = [
        'content',
    ];*/

    public $page_ids;

    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;
    const VISIBLE_ON_SELECTED = 2;

    const LOCATION_NONE = 0;
    const LOCATION_HEADER = 1;
    const LOCATION_FOOTER = 2;

    public static function getVisibilityStatuses()
    {
        return [
            self::VISIBLE_YES => Yii::t('yii', 'Yes'),
            self::VISIBLE_NO => Yii::t('yii', 'No'),
            self::VISIBLE_ON_SELECTED => Yii::t('app', 'On the selected pages'),
        ];
    }

    public static function getLocations()
    {
        return [
            self::LOCATION_NONE => Yii::t('yii', 'None'),
            self::LOCATION_HEADER => Yii::t('yii', 'Header'),
            self::LOCATION_FOOTER => Yii::t('yii', 'Footer'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%snippet}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => I18nBehavior::className(),
                'i18nModelClass' => SnippetI18n::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'content'], 'required'],
            [['content'], 'string'],
            [['visible', 'location'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['slug'], 'unique'],
            [['page_ids'], 'safe']
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
            'content' => Yii::t('app', 'Content'),
            'visible' => Yii::t('app', 'Visible'),
            'location' => Yii::t('app', 'Auto Location'),
            'page_ids' => Yii::t('app', 'Pages'),
        ];
    }

    /**
     * @return null
     */
    /*public function afterFind()
    {
        foreach ($this->i18nAttributes as $attribute) {
            $value = $this->getAttributeValue($attribute);
            $cleanValue = trim(strip_tags($value));

            if (!empty($cleanValue)) {
                $this->setAttribute($attribute, $value);
            }
            if ($attribute == 'visible' && empty($value)) {
                $this->setAttribute('visible', 0);
            }
        }
        //$this->page_ids = SnippetPage::getPageList();

        parent::afterFind();
    }*/

    /**
     * @param $snippetId
     * @return array
     */
    public static function getAssignments($snippetId)
    {
        $oldAssignments = SnippetPage::findAll(['snippet_id' => $snippetId]);
        return ArrayHelper::map($oldAssignments, 'id', 'page_id');
    }

    /**
     * @param boolean $insert
     * @param mixed $changedAttributes
     * @return boolean
     */
    public function afterSave($insert, $changedAttributes)
    {
        $assignments = Yii::$app->request->post('assignment');
        SnippetPage::updateAssignments($this->id, $assignments);

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetI18ns()
    {
        return $this->hasMany(SnippetI18n::className(), ['id' => 'id']);
    }

    /**
     * @return $this
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['language' => 'language'])->viaTable('{{%snippet_i18n}}', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetPages()
    {
        return $this->hasMany(SnippetPage::className(), ['snippet_id' => 'id']);
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
        return self::find()->select(['content', 'slug'])->indexBy('slug')->column();
    }
}
