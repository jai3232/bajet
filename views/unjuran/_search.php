<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UnjuranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unjuran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kod_id') ?>

    <?= $form->field($model, 'os') ?>

    <?= $form->field($model, 'ol') ?>

    <?= $form->field($model, 'id_jabatan') ?>

    <?php // echo $form->field($model, 'id_unit') ?>

    <?php // echo $form->field($model, 'butiran') ?>

    <?php // echo $form->field($model, 'kuantiti') ?>

    <?php // echo $form->field($model, 'kod') ?>

    <?php // echo $form->field($model, 'jumlah_unjuran') ?>

    <?php // echo $form->field($model, 'kongsi') ?>

    <?php // echo $form->field($model, 'public') ?>

    <?php // echo $form->field($model, 'tahun') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sah') ?>

    <?php // echo $form->field($model, 'tarikh_jadi') ?>

    <?php // echo $form->field($model, 'tarikh_kemaskini') ?>

    <?php // echo $form->field($model, 'user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
