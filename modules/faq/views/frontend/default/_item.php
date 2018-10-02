<h3 class="title-block second-child"><?= $model->name ?></h3>
<div class="panel-group" id="faqList<?= $model->id ?>">

    <?php if (count($model->getItems()) > 0) : ?>
        <?php $isFirstItem = true; ?>
        <?php foreach ($model->items as $item) : ?>
            <?php if ($item->visible) : ?>
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#faqList<?= $model->id ?>" href="#question<?= $item->id ?>" class="<?= $isFirstItem && !$index ? '' : 'collapsed' ?>" <?= $isFirstItem && !$index ? 'aria-expanded="true"' : '' ?>>
                                <?= $item->name ?>
                          </a>
                      </h4>
                  </div>
                  <div id="question<?= $item->id ?>" class="panel-collapse collapse <?= $isFirstItem && !$index ? 'in' : '' ?>">
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