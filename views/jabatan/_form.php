<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Jabatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jabatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true])->label('Bahagian') ?>

    <?= $form->field($model, 'ringkasan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
