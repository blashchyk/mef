<?php

namespace common\models;

use yii\base\Model;

class FormGridIds extends Model
{
    /**
     * @var array
     */
    public $ids;

    /**
     * @inheritdocm
     */
    public function rules()
    {
        return [
            ['ids', 'required'],
            ['ids', 'each', 'rule' => ['integer']],
        ];
    }
}
