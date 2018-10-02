<?php

namespace common\behaviors;

use yii\helpers\StringHelper;

class I18nListBehavior extends I18nBehavior
{
    /**
     * @param $event
     */
    public function afterSave($event)
    {
        $i18nModelName = StringHelper::basename($this->i18nModelClass);
        $translations = !empty($_POST[$i18nModelName]) ? $_POST[$i18nModelName] : [];

        $id = $this->owner->id;
        if (!empty($translations[$id])) {
            $translations = $translations[$id];
            $this->saveTranslations($translations);
        }
    }
}
