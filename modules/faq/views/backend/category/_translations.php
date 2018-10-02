<?php
use yii\helpers\Html;
use yii\jui\Accordion;

$items = [];

foreach ($languages as $languageId => $languageName) {
    $translation = $model->translations[$languageId];

    $header = Html::tag('div', '', ['class' => 'pull-left flag flag-' . $languageId]) . '&nbsp; ' . $languageName;
    $content = $form->field($translation, '[' . $languageId . ']name')->textInput(['maxlength' => true]);

    $items[] = [
        'header' => $header,
        'content' => $content,
    ];
}
?>

<h3><?= Yii::t('app', 'Translation List') ?></h3>

<?= Accordion::widget([
    'items' => $items,
    'clientOptions' => [
        'heightStyle' => 'content',
        'animate' => ['duration' => 300],
        'collapsible' => count($languages) > 1,
        'active' => false,
    ],
]); ?>

<br />