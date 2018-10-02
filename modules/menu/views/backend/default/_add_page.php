<?php
use yii\helpers\Html;
use yii\helpers\Url;
use modules\page\models\Page;

$pages = Page::find()->all();
?>

<div class="page-list">

    <?php foreach ($pages as $page) : ?>

    <label for="page-<?= $page->id ?>">
        <input type="checkbox" name="page" id="page-<?= $page->id ?>" value="<?= $page->id ?>" class="page">
        <span class="link-name"><?= $page->link_name ?></span>
        <small class="transparent">(<?= $page->slug ?>)</small>
        <?= Html::a('<span class="glyphicon glyphicon-link"></span>', Url::to(['../' . $page->slug]), [
            'title' => Yii::t('yii', 'View'),
            'aria-label' => Yii::t('yii', 'View'),
            'target' => '_blank'
        ]) ?>
    </label><br />

    <?php endforeach; ?>

</div>

<?= Html::button(Yii::t('app', 'Add Pages'), ['class' => 'add-page-button btn btn-success pull-right', 'disabled' => 'disabled']) ?>

<label for="pages-all" class="select-all-pages pull-right">
    <input type="checkbox" name="pages-all" id="pages-all">
    <?= Yii::t('app', 'Select All') ?>
</label>

<div class="clear"></div>
