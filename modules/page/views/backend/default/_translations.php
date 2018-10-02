<?php
use yii\helpers\Html;
use yii\jui\Accordion;
use dosamigos\ckeditor\CKEditor;

$items = [];

foreach ($languages as $languageId => $languageName) {
    $translation = $model->translations[$languageId];

    $header = Html::tag('div', '', ['class' => 'pull-left flag flag-' . $languageId]) . '&nbsp; ' . $languageName;
    $content = $form->field($translation, '[' . $languageId . ']link_name')->textInput(['maxlength' => true])
        . $form->field($translation, '[' . $languageId . ']header')->textInput(['maxlength' => true])
        . $form->field($translation, '[' . $languageId . ']title')->textInput(['maxlength' => true])
        . $form->field($translation, '[' . $languageId . ']meta_keywords')->textInput(['maxlength' => true])
        . $form->field($translation, '[' . $languageId . ']meta_description')->textInput(['maxlength' => true])
        . $form->field($translation, '[' . $languageId . ']content', [
            'template' => "{label}\n{input}\n{hint}\n{error}",
            'labelOptions' => ['class' => '']
        ])->widget(CKEditor::className(), [
            'preset' => 'basic',
            'options' => ['rows' => 6],
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