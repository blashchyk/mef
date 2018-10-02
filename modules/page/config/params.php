<?php
use modules\page\models\Page;
use modules\page\models\Category;
use modules\snippet\models\Snippet;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Pages'), 'url' => ['/page'], 'badge' => Page::find()->count()],
            ['label' => Yii::t('app', 'Add Page'), 'url' => ['/page/create']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/page/category/index'], 'badge' => Category::find()->count()],
            ['label' => Yii::t('app', 'Add Category'), 'url' => ['/page/category/create']],
            ['label' => Yii::t('app', 'Snippets'), 'url' => ['/snippet'], 'badge' => Snippet::find()->count()],
            ['label' => Yii::t('app', 'Add Snippet'), 'url' => ['/snippet/create']],
        ],
    ],
];
