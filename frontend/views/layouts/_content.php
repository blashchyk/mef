<?php
use yii\helpers\Html;
?>

<?php if (!empty($page)) : ?>
    <h1><?= Html::encode($page->header) ?></h1>
    <?= $page->formattedContent ?>
<?php endif; ?>
