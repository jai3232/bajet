<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OtSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ot-search">

    <?php $form = ActiveForm::begin([
        'id' => 'ot-form',
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="form-group">
        <div class="col-xs-4 form-inline">
            <label>Tahun </label>
            <?= Html::dropDownList('OtSearch[tahun]', $selectedYear, $yearList, 
                    ['class' => 'form-control', 'onchange' => '$("#ot-form").submit()']) 
            ?>
            <label>Bulan</label>
            <?= Html::dropDownList('OtSearch[bulan]', $selectedMonth, $months, 
                ['class' => 'form-control', 'onchange' => '$("#ot-form").submit()']) 
            ?>
        </div>
    </div>

    <?php //= $form->field($model, 'id') ?>

    <?php //= $form->field($model, 'kod_unjuran') ?>

    <?php //= $form->field($model, 'kod_id') ?>

    <?php //= $form->field($model, 'os') ?>

    <?php //= $form->field($model, 'bahagian') ?>

    <?php // echo $form->field($model, 'bahagian_asal') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'no_kp') ?>

    <?php // echo $form->field($model, 'no_hp') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'bulan') ?>

    <?php // echo $form->field($model, 'tahun') ?>

    <?php // echo $form->field($model, 'gred_jawatan') ?>

    <?php // echo $form->field($model, 'tanggung_kerja') ?>

    <?php // echo $form->field($model, 'jawatan') ?>

    <?php // echo $form->field($model, 'no_gaji') ?>

    <?php // echo $form->field($model, 'gaji_asas') ?>

    <?php // echo $form->field($model, 'kadar_sejam') ?>

    <?php // echo $form->field($model, 'bank') ?>

    <?php // echo $form->field($model, 'akaun_bank') ?>

    <?php // echo $form->field($model, 'jumlah_OT') ?>

    <?php // echo $form->field($model, 'jumlah_kew') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'tarikh_jadi') ?>

    <?php // echo $form->field($model, 'tarikh_kemaskini') ?>

    <div class="form-group">
        <?php //= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php //= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
