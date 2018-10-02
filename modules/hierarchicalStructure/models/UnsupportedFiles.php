<?php

namespace modules\hierarchicalStructure\models;


use yii\db\ActiveRecord;

class UnsupportedFiles extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%unsupported_files}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['old_file', 'reference_code'], 'required'],
            [['old_file', 'reference_code', 'new_file'], 'string'],
        ];
    }
}
