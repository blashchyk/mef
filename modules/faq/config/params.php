<?php
use modules\faq\models\Category;
use modules\faq\models\Item;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/faq/category/index'], 'badge' => Category::find()->count()],
            ['label' => Yii::t('app', 'Add Category'), 'url' => ['/faq/category/create']],
            ['label' => Yii::t('app', 'Questions'), 'url' => ['/faq/item/index'], 'badge' => Item::find()->count()],
            ['label' => Yii::t('app', 'Add Question'), 'url' => ['/faq/item/create']],
        ],
    ],
];
