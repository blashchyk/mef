<?php
use modules\media\models\Media;
use modules\media\models\Category;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Media Files'), 'url' => ['/media'], 'badge' => Media::find()->count()],
            ['label' => Yii::t('app', 'Add File'), 'url' => ['/media/create']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/media/category/index'], 'badge' => Category::find()->count()],
            ['label' => Yii::t('app', 'Add Category'), 'url' => ['/media/category/create']],
        ],
    ],
];
