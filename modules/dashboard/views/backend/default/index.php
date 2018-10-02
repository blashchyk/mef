<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\models\User;
use common\widgets\RoleColumn;
use yii\helpers\ArrayHelper;
use modules\page\models\Page;
use modules\page\models\Category as PageCategory;
use modules\menu\models\Menu;
use modules\menu\models\MenuItem;
use modules\catalog\models\Product;
use modules\catalog\models\Category as CatalogCategory;
use modules\faq\models\Item as FaqItem;
use modules\faq\models\Category as FaqCategory;
use modules\quote\models\Quote;
use modules\slider\models\Slider;
use modules\media\models\Media;
use modules\media\models\Category as MediaCategory;
use modules\mail\models\Mail;
use modules\theme\models\Theme;
use modules\module\models\Module;
use modules\i18n\models\Translation;
use modules\i18n\models\Language;
use modules\setting\models\Setting;
use modules\order\models\Order;

$this->title = Yii::t('app', 'Dashboard');

\Yii::$container->set('kartik\grid\GridView', [
    'panelTemplate' => '<div class="well">{toolbar}<div class="clearfix"></div></div>{items}<div class="pull-right">{pager}</div>',
    'panel' => ['headingOptions' => ['class' => 'panel-heading no-padding']],
]);

$dashboardIcons = [
    ['link' => '/user', 'icon' => 'user', 'caption' => 'Users', 'labels' => ['users' => new User()]],
    ['link' => '/page', 'icon' => 'page', 'caption' => 'Pages', 'labels' => ['pages' => new Page(), 'categories' => new PageCategory()]],
    ['link' => '/menu', 'icon' => 'menu', 'caption' => 'Menus', 'labels' => ['menus' => new Menu(), 'items' => new MenuItem()]],
    ['link' => '/catalog/product/index', 'icon' => 'catalog', 'caption' => 'Catalog', 'labels' => ['products' => new Product(), 'categories' => new CatalogCategory()]],
    ['link' => '/faq/category/index', 'icon' => 'faq', 'caption' => 'FAQ', 'labels' => ['questions' => new FaqItem(), 'categories' => new FaqCategory()]],
    ['link' => '/quote', 'icon' => 'quote', 'caption' => 'Quotes', 'labels' => ['quotes' => new Quote()]],
    ['link' => '/slider', 'icon' => 'slider', 'caption' => 'Slider', 'labels' => ['slides' => new Slider()]],
    ['link' => '/media', 'icon' => 'media', 'caption' => 'Media', 'labels' => ['files' => new Media(), 'categories' => new MediaCategory()]],
    ['link' => '/mail', 'icon' => 'mail', 'caption' => 'Emails', 'labels' => ['emails' => new Mail()]],
    ['link' => '/theme', 'icon' => 'theme', 'caption' => 'Themes', 'labels' => ['themes' => new Theme()]],
    ['link' => '/module', 'icon' => 'module', 'caption' => 'Modules', 'labels' => ['modules' => new Module()]],
    ['link' => '/i18n', 'icon' => 'i18n', 'caption' => 'Translations', 'labels' => ['items' => new Translation(), 'languages' => new Language()]],
    ['link' => '/setting', 'icon' => 'setting', 'caption' => 'Settings', 'labels' => ['settings' => new Setting()]],
    ['link' => '/order', 'icon' => 'order', 'caption' => 'Orders', 'labels' => ['orders' => new Order()]],
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="dashboard-index container">

    <div class="row top-line dashboard-icon">
        <?php foreach ($dashboardIcons as $icon) : ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?= Url::to([$icon['link']]) ?>">
                    <div class="float-left">
                        <span class="glyphicon glyphicon-ok icon-<?= $icon['icon'] ?>"></span>
                    </div>
                    <div class="float-left">
                        <strong><?= Yii::t('app', $icon['caption']) ?></strong>
                        <p class="statistic-block">
                            <?php foreach ($icon['labels'] as $label => $number) : ?>
                                <span class="label label-info"><?= $number::find()->count() ?></span>
                                <small><?= Yii::t('app', $label) ?></small>
                            <?php endforeach; ?>
                        </p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2><?= Yii::t('app', 'Users') ?></h2>
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $userProvider,
                'filterModel' => $userModel,
                'resizeStorageKey' => 'dashboardUserGrid',
                'toolbar' => [
                    Html::tag('div', Html::tag('span', $userProvider->getTotalCount(), ['class' => 'label label-info']) . ' ' . Yii::t('app', 'users') . ' &nbsp; ', ['class' => 'pull-left']),
                    Html::tag('div', Html::a('<span class="glyphicon glyphicon-forward"></span>', Url::to(['/user'])), ['class' => 'pull-right']),
                    Html::tag('div', Html::a('<span class="glyphicon glyphicon-plus"></span>', Url::to(['/user/create'])) . ' &nbsp;', ['class' => 'pull-right']),
                ],
                'columns' => [
                    'id',
                    //'username',
                    'email:email',
                    'fullName',
                    [
                        'class' => RoleColumn::className(),
                        'filter' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'),
                        'attribute' => 'roles',
                        'value' => function ($data) {
                            return $data->roleName;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => '/user',
                        'buttons' => [
                            'activate' => function ($url, $model) {
                                $url = Url::to(['/user/activate', 'id' => $model->id]);
                                if ($model->active) {
                                    $options = ['title' => Yii::t('app', 'Block')];
                                    $iconClass = 'glyphicon-unlock';
                                } else {
                                    $options = ['title' => Yii::t('app', 'Unblock')];
                                    $iconClass = 'glyphicon-lock';
                                }
                                return Html::a('<span class="glyphicon ' . $iconClass . '"></span>', $url, $options);
                            },
                        ],
                        'template' => $this->render('@backend/views/layouts/_options', [
                            'options' => [
                                'update'   => 'user.update',
                                'activate' => 'user.update',
                                'delete'   => 'user.delete'
                            ],
                        ]),
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>

        <div class="col-md-6">
            <h2><?= Yii::t('app', 'Pages') ?></h2>
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $pageProvider,
                'filterModel' => $pageModel,
                'resizeStorageKey' => 'pageGrid',
                'toolbar' => [
                    Html::tag('div', Html::tag('span', $pageProvider->getTotalCount(), ['class' => 'label label-info']) . ' ' . Yii::t('app', 'pages') . ' &nbsp; ', ['class' => 'pull-left']),
                    Html::tag('div', Html::a('<span class="glyphicon glyphicon-forward"></span>', Url::to(['/page'])), ['class' => 'pull-right']),
                    Html::tag('div', Html::a('<span class="glyphicon glyphicon-plus"></span>', Url::to(['/page/create'])) . ' &nbsp;', ['class' => 'pull-right']),
                ],
                'columns' => [
                    'id',
                    'link_name',
                    'slug',
                    [
                        'attribute' => 'parent_id',
                        'filter' => PageCategory::getList(),
                        'value' => function ($data) {
                            return !empty($data->parent) ? $data->parent->name : null;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => '/page',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                $expandButton = Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open']);
                                return Html::a($expandButton, Url::to(['../../' . $model->slug]), [
                                    'title' => Yii::t('yii', 'View'),
                                    'aria-label' => Yii::t('yii', 'View'),
                                    'target' => '_blank'
                                ]);
                            },
                        ],
                        'template' => $this->render('@backend/views/layouts/_options', [
                            'options' => [
                                'update' => 'page.backend.default.update',
                                'view'   => 'page.backend.default.index',
                                'delete' => 'page.backend.default.delete'
                            ],
                        ]),
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-6">
            <h2><?= Yii::t('app', 'Products') ?></h2>
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $productProvider,
                'filterModel' => $productModel,
                'resizeStorageKey' => 'productGrid',
                'toolbar' => [
                    Html::tag('div', Html::tag('span', $productProvider->getTotalCount(), ['class' => 'label label-info']) . ' ' . Yii::t('app', 'products') . ' &nbsp; ', ['class' => 'pull-left']),
                    Html::tag('div', Html::a('<span class="glyphicon glyphicon-forward"></span>', Url::to(['/catalog/product/index'])), ['class' => 'pull-right']),
                    Html::tag('div', Html::a('<span class="glyphicon glyphicon-plus"></span>', Url::to(['/catalog/product/create'])) . ' &nbsp;', ['class' => 'pull-right']),
                ],
                'columns' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'options' => ['style' => 'width: 47%'],
                    ],
                    [
                        'attribute' => 'parent_id',
                        'filter' => CatalogCategory::getList(),
                        'value' => function ($data) {
                            return !empty($data->parent) ? $data->parent->name : null;
                        },
                    ],
                    [
                        'attribute' => 'price',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asCurrency($data->price);
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => '/catalog/product',
                        'buttons' => [
                            'activate' => function ($url, $model) {
                                $url = Url::to(['/catalog/product/activate', 'id' => $model->id]);
                                if ($model->visible) {
                                    $options = ['title' => Yii::t('app', 'Block')];
                                    $iconClass = 'glyphicon-unlock';
                                } else {
                                    $options = ['title' => Yii::t('app', 'Unblock')];
                                    $iconClass = 'glyphicon-lock';
                                }
                                return Html::a('<span class="glyphicon ' . $iconClass . '"></span>', $url, $options);
                            },
                        ],
                        'template' => $this->render('@backend/views/layouts/_options', [
                            'options' => [
                                'update'   => 'catalog.backend.product.update',
                                'activate' => 'catalog.backend.product.update',
                                'delete'   => 'catalog.backend.product.delete'
                            ],
                        ]),
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>

        <div class="col-md-6">
            <h2><?= Yii::t('app', 'Orders') ?></h2>
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $orderProvider,
                'filterModel' => $orderModel,
                'resizeStorageKey' => 'orderGrid',
                'toolbar' => [
                    Html::tag('div', Html::tag('span', $orderProvider->getTotalCount(), ['class' => 'label label-info']) . ' ' . Yii::t('app', 'orders') . ' &nbsp; ', ['class' => 'pull-left']),
                    Html::tag('div', Html::a('<span class="glyphicon glyphicon-forward"></span>', Url::to(['/order'])), ['class' => 'pull-right']),
                ],
                'columns' => [
                    'id',
                    'fullName',
                    'phone',
                    'totalPrice:currency',
                    [
                        'attribute' => 'created_at',
                        'filter' => false,
                        'format' => 'date',
                        'options' => ['style' => 'width: 130px'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => '/order',
                        'template' => $this->render('@backend/views/layouts/_options', [
                            'options' => [
                                'view'   => 'order.backend.index',
                                'delete' => 'order.backend.delete'
                            ],
                        ]),
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <br/>
</div>