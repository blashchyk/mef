<?php
use modules\catalog\models\Category;
use modules\catalog\models\Product;
use modules\catalog\models\Filter;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Products'), 'url' => ['/catalog/product/index'], 'badge' => Product::find()->count()],
            ['label' => Yii::t('app', 'Add Product'), 'url' => ['/catalog/product/create']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/catalog/category/index'], 'badge' => Category::find()->count()],
            ['label' => Yii::t('app', 'Add Category'), 'url' => ['/catalog/category/create']],
            ['label' => Yii::t('app', 'Filters'), 'url' => ['/catalog/filter/index'], 'badge' => Filter::find()->count()],
            ['label' => Yii::t('app', 'Add Filter'), 'url' => ['/catalog/filter/create']],
        ],
    ],
];
