<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerjalananSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perjalanan-search">

    <?php $form = ActiveForm::begin([
        'id' => 'perjalanan_form',
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="form-group">
        <div class="col-xs-4 form-inline">
            <label>Tahun </label>
            <?= Html::dropDownList('PerjalananSearch[tahun]', $selectedYear, $yearList, 
                    ['class' => 'form-control', 'onchange' => '$("#perjalanan_form").submit()']) 
            ?>
            <label>Bulan</label>
            <?= Html::dropDownList('PerjalananSearch[bulan]', $selectedMonth, $months, 
                ['class' => 'form-control', 'onchange' => '$("#perjalanan_form").submit()']) 
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

    <?php // echo $form->field($model, 'jawatan') ?>

    <?php // echo $form->field($model, 'no_gaji') ?>

    <?php // echo $form->field($model, 'gaji_asas') ?>

    <?php // echo $form->field($model, 'elaun') ?>

    <?php // echo $form->field($model, 'elaun_mangku') ?>

    <?php // echo $form->field($model, 'bank') ?>

    <?php // echo $form->field($model, 'cawangan_bank') ?>

    <?php // echo $form->field($model, 'akaun_bank') ?>

    <?php // echo $form->field($model, 'model_kereta') ?>

    <?php // echo $form->field($model, 'no_plate') ?>

    <?php // echo $form->field($model, 'cc') ?>

    <?php // echo $form->field($model, 'kelas_tuntutan') ?>

    <?php // echo $form->field($model, 'alamat_pejabat') ?>

    <?php // echo $form->field($model, 'alamat_rumah') ?>

    <?php // echo $form->field($model, 'jumlah_jarak') ?>

    <?php // echo $form->field($model, 'jarak_telah_dituntut') ?>

    <?php // echo $form->field($model, 'kali_makan') ?>

    <?php // echo $form->field($model, 'kali_makan_sabah') ?>

    <?php // echo $form->field($model, 'kali_harian') ?>

    <?php // echo $form->field($model, 'kali_harian_sabah') ?>

    <?php // echo $form->field($model, 'kali_elaun_luar') ?>

    <?php // echo $form->field($model, 'elaun_makan') ?>

    <?php // echo $form->field($model, 'elaun_makan_sabah') ?>

    <?php // echo $form->field($model, 'elaun_harian') ?>

    <?php // echo $form->field($model, 'elaun_harian_sabah') ?>

    <?php // echo $form->field($model, 'elaun_luar') ?>

    <?php // echo $form->field($model, 'peratus_elaun_makan') ?>

    <?php // echo $form->field($model, 'peratus_elaun_makan_sabah') ?>

    <?php // echo $form->field($model, 'peratus_elaun_harian') ?>

    <?php // echo $form->field($model, 'peratus_elaun_harian_sabah') ?>

    <?php // echo $form->field($model, 'peratus_elaun_luar') ?>

    <?php // echo $form->field($model, 'kali_hotel') ?>

    <?php // echo $form->field($model, 'kali_hotel2') ?>

    <?php // echo $form->field($model, 'kali_hotel3') ?>

    <?php // echo $form->field($model, 'kali_hotel4') ?>

    <?php // echo $form->field($model, 'kali_hotel5') ?>

    <?php // echo $form->field($model, 'kali_hotel6') ?>

    <?php // echo $form->field($model, 'kali_lojing') ?>

    <?php // echo $form->field($model, 'hotel') ?>

    <?php // echo $form->field($model, 'hotel2') ?>

    <?php // echo $form->field($model, 'hotel3') ?>

    <?php // echo $form->field($model, 'hotel4') ?>

    <?php // echo $form->field($model, 'hotel5') ?>

    <?php // echo $form->field($model, 'hotel6') ?>

    <?php // echo $form->field($model, 'cukai') ?>

    <?php // echo $form->field($model, 'lojing') ?>

    <?php // echo $form->field($model, 'teksi') ?>

    <?php // echo $form->field($model, 'resit_teksi') ?>

    <?php // echo $form->field($model, 'bas') ?>

    <?php // echo $form->field($model, 'resit_bas') ?>

    <?php // echo $form->field($model, 'keretapi') ?>

    <?php // echo $form->field($model, 'resit_keretapi') ?>

    <?php // echo $form->field($model, 'terbang') ?>

    <?php // echo $form->field($model, 'resit_terbang') ?>

    <?php // echo $form->field($model, 'feri') ?>

    <?php // echo $form->field($model, 'resit_feri') ?>

    <?php // echo $form->field($model, 'lain') ?>

    <?php // echo $form->field($model, 'resit_lain') ?>

    <?php // echo $form->field($model, 'tol') ?>

    <?php // echo $form->field($model, 'resit_tol') ?>

    <?php // echo $form->field($model, 'no_tg') ?>

    <?php // echo $form->field($model, 'pakir') ?>

    <?php // echo $form->field($model, 'resit_pakir') ?>

    <?php // echo $form->field($model, 'dobi') ?>

    <?php // echo $form->field($model, 'resit_dobi') ?>

    <?php // echo $form->field($model, 'pos') ?>

    <?php // echo $form->field($model, 'resit_pos') ?>

    <?php // echo $form->field($model, 'telefon') ?>

    <?php // echo $form->field($model, 'resit_telefon') ?>

    <?php // echo $form->field($model, 'tukaran') ?>

    <?php // echo $form->field($model, 'resit_tukaran') ?>

    <?php // echo $form->field($model, 'pendahuluan') ?>

    <?php // echo $form->field($model, 'tuntutan_lain') ?>

    <?php // echo $form->field($model, 'jumlah_tuntutan') ?>

    <?php // echo $form->field($model, 'jumlah_kew') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'cetak') ?>

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
