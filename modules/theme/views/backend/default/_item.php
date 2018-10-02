<?php
use yii\helpers\Html;

$controller = Yii::$app->controller->id;
?>

<div class="media-item">

    <h4 class="pull-left">
        <?php $label = (!empty($model->name)) ? $model->name : Html::tag('span', Yii::t('app', 'Noname'), ['class' => 'transparent']); ?>
        <?= Html::checkbox('selection[]', false, ['value' => $model->id, 'label' => $label, 'labelOptions' => ['class' => 'normal']]); ?>
    </h4>

    <div class="nowrap center btn-grid pull-right">
        <?php
            $options = [
                'title' => Yii::t('yii', 'Update'),
                'aria-label' => Yii::t('yii', 'Update'),
                'data-pjax' => '0',
            ];
            $action = 'update';
            if (Yii::$app->user->can($action)) {
                echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', [$action, 'id' => $model->id], $options);
            }

            $options = [
                'title' => Yii::t('yii', 'Delete'),
                'aria-label' => Yii::t('yii', 'Delete'),
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'data-pjax' => '0',
            ];
            $action = 'delete';
            if (Yii::$app->user->can($action)) {
                echo Html::a('<span class="glyphicon glyphicon-trash"></span>', [$action, 'id' => $model->id], $options);
            }
        ?>
    </div>

    <div class="clear"></div>

    <a href="<?= $model->imageUrl ?>" title="<?= $model->name ?>" data-gallery>
        <?= Html::img($model->imageThumbnailUrl, ['class'=>'img-thumbnail']) ?><br />
    </a>

    <div class="btn-grid">
        <b><?= Yii::t('app', 'Slug') ?>:</b>
        <?= $model->slug ?>
    </div>

    <div>
        <b><?= Yii::t('app', 'Default') ?>:</b>
        <?= Yii::$app->formatter->asBoolean($model->default) ?>
    </div>

    <?php if (!$model->default) : ?>
        <div class="btn-grid">
            <?= Html::a(Yii::t('app', 'Set as Default'), ['set-default', 'id' => $model->id], [
                'class' => 'btn btn-info action-link',
                'data-confirm' => Yii::t('app', 'Are you sure you want to set the theme as default?'),
            ]) ?>
        </div>
    <?php endif; ?>

</div>