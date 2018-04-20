<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Waran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="waran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_waran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh_waran')->textInput() ?>

    <?= $form->field($model, 'status_waran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah_waran')->textInput() ?>

    <?= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tarikh')->textInput() ?>

    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
