<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use modules\setting\models\Setting;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-lg-3 list-view">
                <div class="widget post-grid">
                    <h3 class="title"><?= Yii::t('app', 'contact us') ?></h3>
                    <div class="widget-body">
                        <ul class="contact-list-icon">
                            <li><i class="fa fa-map-marker"></i><?= Setting::getValue('contact_address') ?></li>
                            <li><i class="fa fa-phone"></i> <?= Setting::getValue('contact_phone') ?></li>
                            <li><i class="fa fa-envelope"></i><a href="<?= Setting::getValue('contact_mail') ?>"><?= Setting::getValue('contact_mail') ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-body">
                        <a href="<?= Url::to(['/contact']) ?>" class="btn btn-primary-magnet btn-block"><i class="fa fa-comment"></i><span class="text-red"><?= Yii::t('app', 'Online') ?></span> <?= Yii::t('app', 'Support') ?></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_item',
                ]); ?>
            </div>
        </div>
    </div>

</div>