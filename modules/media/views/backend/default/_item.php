<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use modules\media\models\Media;

$controller = Yii::$app->controller->id;
?>

<div class="media-item">

    <h4 class="pull-left">
        <?php $label = (!empty($model->name)) ? StringHelper::truncate(strip_tags($model->name), 20, '...') : Html::tag('span', Yii::t('app', 'Noname'), ['class' => 'transparent']); ?>
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
                'title' => Yii::t('yii', 'Copy URL'),
                'aria-label' => Yii::t('yii', 'Copy URL'),
                'class' => 'btn-clipboard',
                'data-clipboard-text'=> $model->imageUrl,
                'data-clipboard-demo'=> true,
            ];
            echo Html::a('<span class="glyphicon glyphicon-link"></span>', 'javascript:', $options);

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

    <?php if ($model->type == Media::TYPE_IMAGE) : ?>
        <a href="<?= $model->imageUrl ?>" title="<?= $model->name ?>" data-gallery>
            <?= Html::img($model->imageThumbnailUrl, ['class' => 'img-thumbnail']) ?><br />
        </a>
    <?php elseif ($model->type == Media::TYPE_VIDEO) : ?>
        <video width="160" controls src="<?= $model->imageUrl ?>">
            <?= Yii::t('app', 'Your browser does not support video') ?>
        </video>
    <?php endif; ?>

    <?php if (!empty($model->user)) : ?>
        <div class="btn-grid">
            <b><?= Yii::t('app', 'Owner') ?>:</b>
            <?= $model->user->username ?>
        </div>
    <?php endif; ?>

    <div>
        <b><?= Yii::t('app', 'Category') ?>:</b>
        <?php if (!empty($model->parent)) : ?>
            <?= $model->parent->name ?>
        <?php else : ?>
            <span class="transparent"><?= Yii::t('app', 'Uncategorised') ?></span>
        <?php endif; ?>
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