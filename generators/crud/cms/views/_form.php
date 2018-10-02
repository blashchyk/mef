<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form col-lg-8 alert alert-info">

    <?= '<?php ' ?>$form = ActiveForm::begin(); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?php echo "<?= Yii::t('app', '" . Inflector::camel2words(StringHelper::basename($generator->modelClass)) . "') ?>"; ?></b></div>

        <div class="panel-body">

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo '            <?= ' . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
        </div>

    </div>

    <div class="pull-right">
        <?= '<?= ' ?>Html::a(<?= $generator->generateString('Cancel') ?>, ['index'], ['class' => 'btn btn-primary']) ?>
        <?= '<?= ' ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => 'btn btn-success']) ?>
    </div>

    <?= '<?php ' ?>ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>