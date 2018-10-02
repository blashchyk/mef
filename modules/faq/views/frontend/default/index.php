<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use modules\setting\models\Setting;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="col-sm-4 col-lg-3">
        <h3 class="title-block first-child"><?= Yii::t('app', 'Helpful Data') ?></h3>
        <div class="menu-lg">
            <div class="item">
                <i class="fa fa-users"></i>
                <div class="content">
                    <div class="title"><a href="<?= Url::to(['/contact']) ?>"><span class="text-red"><?= Yii::t('app', 'Online') ?></span> <?= Yii::t('app', 'Support') ?></a></div>
                    <div class="description">
                        <?= Yii::t('app', 'Do not hesitate to {contact_link} if you have any questions or feature requests', [
                            'contact_link' => Html::a(Yii::t('app', 'contact us'), ['/contact']),
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="item">
                <i class="fa fa-legal"></i>
                <div class="content">
                    <div class="title"><a href="<?= Url::to(['/contact']) ?>"><?= Yii::t('app', 'Our') ?> <span class="text-red"><?= Yii::t('app', 'Contacts') ?></span></a></div>
                    <div class="description">
                    <?= Yii::t('app', 'Phone') ?>:
                    <?= Setting::getValue('contact_phone') ?><br />
                    <?= Yii::t('app', 'Fax') ?>:
                    <?= Setting::getValue('contact_fax') ?><br />
                    <?= Yii::t('app', 'E-mail') ?>: <a href="<?= Setting::getValue('contact_mail') ?>"><?= Setting::getValue('contact_mail') ?></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <i class="fa fa-unlock-alt"></i>
                <div class="content">
                    <div class="title"><a href="<?= Url::to(['/contact']) ?>"><span class="text-red"><?= Yii::t('app', 'Data') ?></span> <?= Yii::t('app', 'Protection') ?></a></div>
                    <div class="description">
                        Lorem ipsum dolor sit amet, consectetur.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-8 col-lg-9">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
        ]); ?>
    </div>

</div>