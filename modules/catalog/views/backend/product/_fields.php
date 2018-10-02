<?php
use yii\helpers\Html;
?>

<?php if (count($model->additionalFields)) : ?>
    <hr />
    <h3><?= Yii::t('app', 'Additional Fields') ?></h3>
    <br />

    <?php foreach ($model->additionalFields as $key => $field) : ?>
        <?= Html::activeHiddenInput($field, "[{$key}]id") ?>
        <?= Html::activeHiddenInput($field, "[{$key}]field_id") ?>
        <?= $form->field($field, '[' . $key . ']value')->textInput(['maxlength' => true])->label(Yii::t('app', $field->field->name)) ?>
    <?php endforeach; ?>

    <hr />
<?php endif; ?>