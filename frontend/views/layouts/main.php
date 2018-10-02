<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use frontend\assets\BasicAsset;
use common\widgets\Navigator;
use common\widgets\Alert;
use common\widgets\LanguageChoice;
use modules\i18n\models\Language;
use modules\snippet\models\Snippet;

BasicAsset::register($this);

$page = !empty($this->params['page']) ? $this->params['page'] : null;
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
    <?= $this->render('@frontend/views/layouts/_counters', [
        'location' => Snippet::LOCATION_HEADER,
        'page' => $page
    ]); ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => \Yii::t('app', 'Mef Application'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-fixed-top main-menu',
        ],
    ]);

    echo LanguageChoice::widget([
        'languages' => Language::getList(true),
        'currentLanguage' => Yii::$app->session->get('language', 'pt'),
    ]);

    echo Navigator::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'isDropdown' => true,
        'menuCode' => 'main',
        'items' => [
            [
                'label' => Yii::t('app', 'Dashboard'),
                'url' => ['/admin'] ,
                'visible' => !Yii::$app->user->isGuest
            ]
        ]
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?php /*if (!empty($page)) {
            echo $this->render('@frontend/views/layouts/_content', [
                'page' => $page
            ]);
        } */?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; IT-Master <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::t('app', 'Created by') ?> <a href="http://itmaster-soft.com/" rel="external" target="_blank">IT-Master</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
<?= $this->render('@frontend/views/layouts/_counters', [
    'location' => Snippet::LOCATION_FOOTER,
    'page' => $page
]); ?>
</body>
</html>
<?php $this->endPage() ?>