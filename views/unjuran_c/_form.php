<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Unjuran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unjuran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_jabatan')->textInput() ?>

    <?= $form->field($model, 'id_unit')->textInput() ?>

    <?= $form->field($model, 'butiran')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kuantiti')->textInput() ?>

    <?= $form->field($model, 'kod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah_unjuran')->textInput() ?>

    <?= $form->field($model, 'kongsi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'public')->textInput() ?>

    <?= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'sah')->textInput() ?>

    <?= $form->field($model, 'tarikh_jadi')->textInput() ?>

    <?= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
