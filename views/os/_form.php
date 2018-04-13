<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Os */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="os-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'os')->textInput(['maxlength' => true])->label('OS') ?>

    <?= $form->field($model, 'butiran')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
