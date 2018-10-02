<?php
use yii\helpers\Html;
use yii\jui\Accordion;
use dosamigos\ckeditor\CKEditor;

$items = [];

foreach ($languages as $languageId => $languageName) {
    $translation = $model->translations[$languageId];

    $header = Html::tag('div', '', ['class' => 'pull-left flag flag-' . $languageId]) . '&nbsp; ' . $languageName;
    $content = $form->field($translation, '[' . $languageId . ']name')->textInput(['maxlength' => true])
        . $form->field($translation, '[' . $languageId . ']button_caption')->textInput(['maxlength' => true])
        . $form->field($translation, '[' . $languageId . ']description')->widget(CKEditor::classname(), [
            'preset' => 'basic',
            'options' => ['rows' => 3],
        ]);

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