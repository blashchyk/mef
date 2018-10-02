<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use common\widgets\Navigator;
use common\widgets\Alert;
use common\widgets\LanguageChoice;
use modules\i18n\models\Language;
use modules\snippet\models\Snippet;
use frontend\themes\colored\assets\ThemeAsset;

ThemeAsset::register($this);

$page = !empty($this->params['page']) ? $this->params['page'] : null;
$breadcrumbs = !empty($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : null;
if (empty($breadcrumbs) && !empty($page)) {
    $breadcrumbs = [$page->header];
}
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="ico/favicon.ico">

    <title><?= Html::encode($this->title) ?></title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel="stylesheet" type="text/css">

    <?php $this->head() ?>
    <?= $this->render('@frontend/views/layouts/_counters', [
        'location' => Snippet::LOCATION_HEADER,
        'page' => $page
    ]); ?>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php $this->beginBody() ?>

<body class="home-default">

<?php
NavBar::begin([
    'brandLabel' => Html::img($this->theme->getUrl('logo-orange.png'), ['alt' => 'Logo']),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-magnet navbar-fixed-top',
        'id' => 'navbar-main-magnet'
    ],
]);?>

<div class="container">
    <?= LanguageChoice::widget([
        'languages' => Language::getList(true),
        'currentLanguage' => Yii::$app->session->get('language', 'en'),
    ]); ?>

    <div class="navbar-collapse collapse">
        <?= Navigator::widget([
            'options' => ['class' => 'nav navbar-nav navbar-right'],
            'isDropdown' => true,
            'menuCode' => 'main',
        ]); ?>
    </div>
</div>
<?php NavBar::end(); ?>

<div class="wrapper">
    <?php if (!empty($page) && $page->slug == 'index') : ?>
        <?= $this->render('_slider'); ?>
    <?php endif ?>

    <?= Alert::widget() ?>
    <?php if (!empty($page)) {
        echo $this->render('@frontend/views/layouts/_content', [
            'page' => $page
        ]);
    } ?>

    <?= $content ?>
</div>

<?= $this->render('@frontend/views/layouts/_footer') ?>

<?php $this->endBody() ?>
<?= $this->render('@frontend/views/layouts/_counters', [
    'location' => Snippet::LOCATION_FOOTER,
    'page' => $page
]); ?>
</body>
</html>
<?php $this->endPage() ?>