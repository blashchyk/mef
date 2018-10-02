<div class="pull-right">
    <div class="btn-group">
        <button type="button" class="toggle-detail btn-sm btn btn-default"><?= Yii::t('app', 'Toggle') ?></button>
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" class="show-detail"><?= Yii::t('app', 'Show Details') ?></a></li>
            <li><a href="#" class="hide-detail"><?= Yii::t('app', 'Hide Details') ?></a></li>
        </ul>
    </div>

    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#add-item-modal"><?= Yii::t('app', 'Add Items') ?></button>
        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" class="open-add-page" data-toggle="modal" data-target="#add-item-modal"><?= Yii::t('app', 'Add Pages') ?></a></li>
            <li><a href="#" class="open-add-link" data-toggle="modal" data-target="#add-item-modal"><?= Yii::t('app', 'Add Link') ?></a></li>
            <li><a href="#" class="open-add-text" data-toggle="modal" data-target="#add-item-modal"><?= Yii::t('app', 'Add Text Item') ?></a></li>
        </ul>
    </div>
</div>

<div class="clear"></div>
