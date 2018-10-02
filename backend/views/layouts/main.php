<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\widgets\LanguageChoice;
use common\widgets\Alert;
use common\models\User;
use modules\module\models\Module;
use modules\i18n\models\Language;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div id="body-wrapper">
<?php $this->beginBody() ?>
    <?php
    if (isset($_COOKIE['statusSideMenu'])) {
        $statusSideMenu=$_COOKIE['statusSideMenu'];
    } else {
        $statusSideMenu = 'max';
    }
    ?>
    <?php NavBar::begin([
        'brandLabel' => Yii::t('app', 'Admin Panel'),
        'brandUrl' => Yii::$app->homeUrl,
        'brandOptions' => [
            'class' => 'navbar-brand text-uppercase'
        ],
        'options' => [
            'class' => 'navbar bg-info navbar-fixed-top ' . (($statusSideMenu=='min') ? 'minimised' : ''),
        ],
        'renderInnerContainer' => false,
    ]); ?>
    <?php $user = User::findOne(Yii::$app->user->id); ?>
    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => ['label' => '', 'items' => Html::tag('span', '', ['id' => 'toggle_sidemenu_l', 'class' => 'glyphicon glyphicon-menu-hamburger' ])]
    ]); ?>

<?= Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,
    'items' => [
        [
            'label' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-log-out',
            'title' => \Yii::t('app', 'Logout')]),
            'url' => ['/auth/logout'], 'linkOptions' => ['data-method' => 'post'],
            'visible' => !Yii::$app->user->isGuest
        ]
    ],
]) ?>
    <?= LanguageChoice::widget([
        'languages' => Language::getList(),
        'currentLanguage' => Yii::$app->session->get('language', 'pt'),
    ]) ?>

<?php
if (!\Yii::$app->user->isGuest) {
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            [
                'url' => ['/user/update?id=' . \Yii::$app->user->id],
                'label' => Html::img($user->imageThumbnailUrl, ['class' => 'img-thumbnail avatar']),
            ],
        ],
    ]);
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,
    'items' => [
        [
            'url' => ['/..'],
            'label' => Yii::t('app', 'Homepage'),
        ],
    ],
]);
?>
    <?php NavBar::end(); ?>
    <div class="sidebar-wrapper <?=($statusSideMenu=='min')?'minimised':''?>">
    <?php NavBar::begin([
        'options' => [
            'class' => 'sidebar-default has-scrollbar ',
            'id' => 'sidebar_left',
        ],
        'renderInnerContainer' => false,
    ]); ?>
        <div class="sidebar-left-content nano-content">
            <?php if (!Yii::$app->user->isGuest) {
                $modules = Module::getAvailableModules();
                $menuItems = [
                    [
                        'label' => '<span class="glyphicon glyphicon-ok icon-user"></span><span class="sidebar-title"> ' . Yii::t('app', 'Users') . '</span>',
                        'items' => [
                            [
                                'label' => '<span class="glyphicon glyphicon-ok icon-user"></span><span class="sidebar-title"> ' . Yii::t('app', 'Management') . '</span>',
                                'items' => [],
                                'options' => ['class' => ''],
                                'url' => ['/user/index'],
                                'visible' => $user->isAdmin()
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-ok icon-role"></span><span class="sidebar-title"> ' . Yii::t('app', 'Roles') . '</span>',
                                'items' => [],
                                'options' => ['class' => ''],
                                'url' => ['/role/index'],
                                'visible' => $user->isAdmin()
                            ]

                        ],
                        'options' => (Url::toRoute('') == '/admin/role' || Url::toRoute('') == '/admin/user') ? ['class' => 'open'] : ['class' => ''],
                        'url' => ['/user/index'],
                        'visible' => $user->isAdmin()
                    ],
                ];
                $index = 0;
                foreach ($modules as $module) {
                    $systemModule = \Yii::$app->getModule($module->slug);
                    $menu = [];
                    if (!empty($systemModule->params['admin_modules'])) {
                        $menu = $systemModule->params['admin_modules'];
                    }
                    $active = false;
                    foreach ($menu as $menuItem) {
                        if (!empty($menuItem['url'][0])) {
                            if ('/admin' . $menuItem['url'][0] == Url::toRoute('')) {
                                $active = true;
                            }
                        }
                    }

                    $menuItems[] = [
                        'label' => '<span class="glyphicon glyphicon-ok icon-' . $module->slug . '"></span><span class="sidebar-title"> ' . Yii::t('app', $module->name) . '</span>',
                        'items' => $menu,
                        'options' => ($active && $statusSideMenu!='min') ? (['class' => 'open']) : (['class' => '']),
                        'url' => ['/' . $module->slug == 'funds' ? 'hierarchicalStructure/' . $module->slug : $module->slug . '/index']
                    ];

                    $index++;
                } ?>
                <?= Nav::widget([
                    'options' => ['class' => 'nav sidebar-menu'],
                    'dropDownCaret' => '<span class="caret"></span>',
                    'items' => $menuItems,
                    'encodeLabels' => false,
                ]);
            } ?>
            <?php NavBar::end(); ?>
            <div class="sidebar-scroll">
                <div class="scroll-body">
                </div>
            </div>
        </div>
        <div id="content_wrapper" class='<?= ($statusSideMenu=='min')?'minimised':''; ?>'>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>
<div class="pust" style="display: block;width: 100%;height: 40px;"></div>
<footer class="footer <?= ($statusSideMenu=='min')?'minimised':''; ?>">
    <div class="container">
        <p class="pull-left">&copy; IT-Master <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::t('app', 'Created by') ?> <a href="https://hire.itmaster-soft.com/" rel="external" target="_blank">IT-Master</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
