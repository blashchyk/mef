<?php
use yii\helpers\Html;
?>

<?php if (!empty($page)) : ?>
    <div class="section bg-primary" <?php if (empty($page->content)) : ?> style="background-image: url(<?= $this->theme->getUrl('image-banner-2.jpg') ?>)" <?php endif ?>>
        <div class="container">
            <h1 class="block-title" <?php if (empty($page->content)) : ?> style="margin-bottom: 0" <?php endif ?>><span><?= Html::encode($page->header) ?></span></h1>
            <?= $page->formattedContent ?>
        </div>
    </div>
<?php endif; ?>
