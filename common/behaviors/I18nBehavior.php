<?php

namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use modules\i18n\models\Language;

class I18nBehavior extends Behavior
{
    public $i18nModelClass = null;

    public $language = 'en';

    /**
     * @param null $config
     */
    public function __construct($config = null)
    {
        $this->language = Yii::$app->language;

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    /**
     * @param $event
     */
    public function afterSave($event)
    {
        $i18nModelName = StringHelper::basename($this->i18nModelClass);
        $translations = Yii::$app->request->post($i18nModelName, []);
        $this->saveTranslations($translations);
    }

    /**
     * @param $translations
     */
    public function saveTranslations($translations)
    {
        $id = $this->owner->id;

        foreach ($translations as $language => $translation) {
            $modelI18n = (new $this->i18nModelClass)->findOne(['id' => $id, 'language' => $language]);
            if (empty($modelI18n)) {
                $modelI18n = $this->createI18nModel($id, $language);
                foreach ($translation as $value) {
                    if (!empty($value)) {
                        $modelI18n->attributes = $translation;
                        $modelI18n->save();
                        break;
                    }
                }
            } else {
                $modelI18n->attributes = $translation;
                $modelI18n->save();
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkedModelI18ns()
    {
        return $this->owner->hasMany($this->i18nModelClass, ['id' => 'id']);
    }

    /**
     * @return array
     */
    public function getTranslations()
    {
        $id = $this->owner->id;
        $translations = ArrayHelper::index($this->owner->linkedModelI18ns, 'language');
        $languages = Language::find()->all();

        foreach ($languages as $language) {
            if (empty($translations[$language->language]) && $language->language != Language::DEFAULT_LANGUAGE) {
                $translations[$language->language] = $this->createI18nModel($id, $language);
            }
        }

        return $translations;
    }

    /**
     * @return array
     */
    public function createI18nModel($id, $language)
    {
        $modelI18n = new $this->i18nModelClass();
        $modelI18n->loadDefaultValues();
        $modelI18n->id = $id;
        $modelI18n->language = $language;

        return $modelI18n;
    }

    /**
     * @return string
     */
    public function getAttributeValue($attribute)
    {
        if ($this->owner->language == Language::DEFAULT_LANGUAGE) {
            return $this->owner->getAttribute($attribute);
        }

        $i18nsModel = ArrayHelper::index($this->owner->linkedModelI18ns, 'language');

        if (!empty($i18nsModel[$this->owner->language])) {
            return $i18nsModel[$this->owner->language]->getAttribute($attribute);
        }

        return $this->owner->getAttribute($attribute);
    }
}
