<?php
namespace common\components\Validator;

use yii\validators\Validator;
use yii\helpers\HtmlPurifier;

class PurifierValidator extends Validator
{
    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = HtmlPurifier::process($model->$attribute);
    }
}
