<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SyarikatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="syarikat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kod') ?>

    <?= $form->field($model, 'nama_syarikat') ?>

    <?= $form->field($model, 'alamat') ?>

    <?= $form->field($model, 'nama_pengurus') ?>

    <?php // echo $form->field($model, 'no_telefon') ?>

    <?php // echo $form->field($model, 'no_faks') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'cawangan_bank') ?>

    <?php // echo $form->field($model, 'no_akaun') ?>

    <?php // echo $form->field($model, 'no_rujukan') ?>

    <?php // echo $form->field($model, 'tarikh_daftar') ?>

    <?php // echo $form->field($model, 'pkk') ?>

    <?php // echo $form->field($model, 'kelas_F1') ?>

    <?php // echo $form->field($model, 'kelas_F2') ?>

    <?php // echo $form->field($model, 'kelas_F3') ?>

    <?php // echo $form->field($model, 'kelas_F4') ?>

    <?php // echo $form->field($model, 'kelas_F5') ?>

    <?php // echo $form->field($model, 'kelas_F6') ?>

    <?php // echo $form->field($model, 'kelas_F7') ?>

    <?php // echo $form->field($model, 'kew') ?>

    <?php // echo $form->field($model, 'tarikh_luput_kew') ?>

    <?php // echo $form->field($model, 'kod_kepala0') ?>

    <?php // echo $form->field($model, 'kod_kepala1') ?>

    <?php // echo $form->field($model, 'kod_kepala2') ?>

    <?php // echo $form->field($model, 'terima') ?>

    <?php // echo $form->field($model, 'cidb') ?>

    <?php // echo $form->field($model, 'pkk_elektrik') ?>

    <?php // echo $form->field($model, 'kepala_sub_kepala') ?>

    <?php // echo $form->field($model, 'kod_cukai') ?>

    <?php // echo $form->field($model, 'tarikh_jadi') ?>

    <?php // echo $form->field($model, 'tarikh_kemaskini') ?>

    <?php // echo $form->field($model, 'user') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
