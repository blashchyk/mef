<div class="post-grid">
    <h3 class="title"><?= $model->name ?></h3>
    <div class="panel-group-magnet" id="accordion<?= $model->id ?>" role="tablist" aria-multiselectable="true">
        <?php if (count($model->getItems()) > 0) : ?>
            <?php $isFirstItem = true; ?>
            <?php foreach ($model->getItems() as $item) : ?>
                <?php if ($item->visible) : ?>
                    <div class="panel panel-magnet">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion<?= $model->id ?>" href="#collapse<?= $item->id ?>" class="<?= $isFirstItem && !$index ? '' : 'collapsed' ?>" <?= $isFirstItem && !$index ? 'aria-expanded="true"' : '' ?>>
                                    <?= $item->name ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?= $item->id ?>" class="panel-collapse collapse <?= $isFirstItem && !$index ?  'in' : '' ?>" role="tabpanel">
                            <div class="panel-body">
                                <p><?= $item->description ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php $isFirstItem = false; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <?= Yii::t('app', 'Category does not contain any items.'); ?>
        <?php endif; ?>
    </div>
</div>