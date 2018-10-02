<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;

$controller = Yii::$app->controller->id;
?>

<div class="media-item">

    <h4 class="pull-left">
        <?php $label = (!empty($model->name)) ? StringHelper::truncate(strip_tags($model->name), 20, '...') : Html::tag('span', Yii::t('app', 'Noname'), ['class' => 'transparent']); ?>
        <?= Html::checkbox('selection[]', false, ['value' => $model->id, 'id' => 'selection', 'label' => $label, 'labelOptions' => ['class' => 'normal']]); ?>
    </h4>

    <div class="nowrap center btn-grid pull-right">
        <?php
            $options = [
                'title' => Yii::t('yii', 'Update'),
                'aria-label' => Yii::t('yii', 'Update'),
                'data-pjax' => '0',
            ];
            $action = 'update';
            if (Yii::$app->user->can($action)) :
                echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', [$action, 'id' => $model->id], $options);
            endif;

            $options = [
                'title' => Yii::t('yii', 'Delete'),
                'aria-label' => Yii::t('yii', 'Delete'),
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'data-pjax' => '0',
            ];
            $action = 'delete';
            if (Yii::$app->user->can($action)) :
                echo Html::a('<span class="glyphicon glyphicon-trash"></span>', [$action, 'id' => $model->id], $options);
            endif;

            $action = 'update';
            if (Yii::$app->user->can($action)) :
                $icon = 'unlock';
                $options = [
                    'title' => Yii::t('yii', 'Block'),
                    'aria-label' => Yii::t('yii', 'Block'),
                    'class' => 'btn-clipboard',
                    'data-pjax' => '0',
                ];
                if (!$model->visible) :
                    $icon = 'lock';
                    $options = [
                        'title' => Yii::t('yii', 'Unblock'),
                        'aria-label' => Yii::t('yii', 'Unblock'),
                        'class' => 'btn-clipboard',
                        'data-pjax' => '0',
                    ];
                endif;
                echo Html::a('<span class="glyphicon glyphicon-' . $icon . '"></span>', ['activate', 'id' => $model->id], $options);
            endif;
        ?>
    </div>

    <div class="clear"></div>
    <a href="<?= $model->imageUrl ?>" title="<?= $model->name ?>" data-gallery>
        <?= Html::img($model->imageThumbnailUrl, ['class'=>'img-thumbnail']) ?><br />
    </a>

    <?php if (!empty($model->user)) : ?>
        <div class="btn-grid">
            <b><?= Yii::t('app', 'Owner') ?>:</b>
            <?= $model->user->username ?>
        </div>
    <?php endif; ?>

    <div>
        <b><?= Yii::t('app', 'Type') ?>:</b>
        <?= $model->typeName ?>
    </div>

    <div>
        <b><?= Yii::t('app', 'Theme') ?>:</b>
        <?= $model->theme->name ?>
    </div>

    <div>
        <small>
            <b><?= Yii::t('app', 'Created') ?>:</b>
            <?= $model->created ?>
        </small>
    </div>

    <div>
        <small>
            <b><?= Yii::t('app', 'Updated') ?>:</b>
            <?= $model->updated ?>
        </small>
    </div>

</div>
