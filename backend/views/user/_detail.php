<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\widgets\SocialChoice;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var common\models\User $model */

?>

<?php if (!empty($model->avatar)) : ?>
    <div class="pull-left">
        <a href="<?= $model->imageUrl ?>" title="<?= $model->username ?>" data-gallery>
            <?= Html::img($model->imageThumbnailUrl, ['class'=>'img-thumbnail']) ?><br />
        </a>
    </div>
<?php endif; ?>

<div class="pull-left">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'created_at:datetime',
            'updated_at:datetime',
            'last_login_at:datetime',
        ],
    ]) ?>
</div>

<?php if ($model->auths) : ?>
    <div class="pull-left">
        <?= SocialChoice::widget([
            'baseAuthUrl' => ['site/auth'],
            'popupMode' => false,
            'isMinimized' => true,
            'auths' => $model->auths,
            'addButtonTitle' => Yii::t('app', 'Link a new Social Account'),
        ]) ?>
    </div>
<?php endif; ?>

<div class="pull-left">
    <?php $form = ActiveForm::begin([
        'id' => 'change-role-user-form',
        'action' => Url::toRoute(['update-role'])
    ]); ?>
        <?= Html::input('hidden', 'id', $model->id); ?>
        <label for="id-role-name"><?= Yii::t('app', 'Quickly edit role'); ?></label>
        <div class="input-group">

            <?= Html::dropDownList(
                'roleName',
                $model->roleName,
                ArrayHelper::map(User::getListRoles(), 'name', 'name'),
                [
                    'class' => 'form-control',
                    'id' => 'id-role-change',
                ]
            );
            ?>
          <span class="input-group-btn">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
          </span>
        </div>

    <?php ActiveForm::end();?>
</div>

<div class="clear"></div>