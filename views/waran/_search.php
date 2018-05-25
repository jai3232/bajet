<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WaranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="waran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no_waran') ?>

    <?= $form->field($model, 'tarikh_waran') ?>

    <?= $form->field($model, 'status_waran') ?>

    <?= $form->field($model, 'tahun') ?>

    <?php // echo $form->field($model, 'os') ?>

    <?php // echo $form->field($model, 'jumlah_waran') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'tarikh') ?>

    <?php // echo $form->field($model, 'user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
