<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerolehanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perolehan-search form-group">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php //= $form->field($model, 'id') ?>

    <?php //= $form->field($model, 'kod_id') ?>

    <?php //= $form->field($model, 'kod_unjuran') ?>

    <?php //= $form->field($model, 'id_jabatan') ?>

    <?php //= $form->field($model, 'id_jabatan_asal') ?>

    <?php // echo $form->field($model, 'id_unit') ?>

    <?php // echo $form->field($model, 'jenis_perolehan') ?>

    <?php // echo $form->field($model, 'kaedah_pembayaran') ?>

    <?php // echo $form->field($model, 'kontrak_pusat') ?>

    <?php // echo $form->field($model, 'id_syarikat') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'tarikh_lulus1') ?>

    <?php // echo $form->field($model, 'catatan1') ?>

    <?php // echo $form->field($model, 'lulus_perolehan') ?>

    <?php // echo $form->field($model, 'status_kewangan') ?>

    <?php // echo $form->field($model, 'tarikh_lulus2') ?>

    <?php // echo $form->field($model, 'nolo') ?>

    <?php // echo $form->field($model, 'tarikhlo') ?>

    <?php // echo $form->field($model, 'novoucher') ?>

    <?php // echo $form->field($model, 'tarikh_voucher') ?>

    <?php // echo $form->field($model, 'nilai_perolehan') ?>

    <?php // echo $form->field($model, 'catatan2') ?>

    <?php // echo $form->field($model, 'tahun') ?>
    <div class="form-group">
        <div class="col-xs-4 rowx form-inlinex">
                <label>Tahun </label>
        <?= Html::dropDownList('PerolehanSearch[tahun]', $selectedYear, $yearList, ['class' => 'form-control', 'onchange' => '$("#w0").submit()']) ?>
        </div>
    </div>

    <?php // echo $form->field($model, 'tarikh_jadi') ?>

    <?php // echo $form->field($model, 'tarikh_kemaskini') ?>

    <?php // echo $form->field($model, 'user') ?>

    <div class="form-group">
        <?php //= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php //= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
