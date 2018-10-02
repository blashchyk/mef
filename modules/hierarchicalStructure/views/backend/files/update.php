<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'action' => '/admin/hierarchicalStructure/files/update?fileId=' . $fileId,
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal',
    ]
]); ?>
<?= $form->field($file, 'record_id')->hiddenInput(['value' => $record->id])->label(false) ?>
<?= $form->field($file, 'path')->fileInput() ?>
    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary update_button']) ?>
        <?= Html::submitButton( Yii::t('app', 'Rewrite'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>