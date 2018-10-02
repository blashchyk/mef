<?php
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
?>

<?php Modal::begin([
    'id' => 'add-item-modal',
    'header' => '<h3>' . Yii::t('app', 'Add New Menu Item') . '</h3>',
    /*'toggleButton' => [
		'label' => 'Add Item',
		'class' => 'btn btn-success pull-right'
	],*/
]);?>

<?= Tabs::widget([
    'id' => 'menu-item-tabs',
    'items' => [
        [
            'label' => Yii::t('app', 'Pages'),
            'options' => ['id' => 'page'],
            'content' => $this->render('_add_page')
        ],
        [
            'label' => Yii::t('app', 'Custom Link'),
            'options' => ['id' => 'link'],
            'content' => $this->render('_add_link')
        ],
        [
            'label' => Yii::t('app', 'Text Item'),
            'options' => ['id' => 'text'],
            'content' => $this->render('_add_text')
        ],
    ],
]);?>

<?php Modal::end(); ?>

<div class="clear"></div>