<?php
use yii\helpers\Html;
?>

<?php if (!empty($page)) : ?>
    <h1 class="title-lg first-child"><span><?= Html::encode($page->header) ?></span></h1>
    <?= $page->formattedContent ?>
<?php endif; ?>