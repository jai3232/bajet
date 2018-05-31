<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UnjuranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unjuran-search">

    <?php $form = ActiveForm::begin([
        'id' => 'unjuran_form',
        'action' => isset($all) ? ['index-all'] : ['index', 'id' => yii::$app->user->identity->id_jabatan],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php //= $form->field($model, 'id') ?>

    <?php //= $form->field($model, 'kod_id') ?>

    <?php //= $form->field($model, 'os') ?>

    <?php //= $form->field($model, 'ol') ?>

    <?php //= $form->field($model, 'id_jabatan') ?>

    <?php // echo $form->field($model, 'id_unit') ?>

    <?php // echo $form->field($model, 'butiran') ?>

    <?php // echo $form->field($model, 'kuantiti') ?>

    <?php // echo $form->field($model, 'kod') ?>

    <?php // echo $form->field($model, 'jumlah_unjuran') ?>

    <?php // echo $form->field($model, 'kongsi') ?>

    <?php // echo $form->field($model, 'public') ?>

    <?php // echo $form->field($model, 'tahun') ?>

    <div class="form-group">
        <div class="col-xs-4 form-inline">
            <label>Tahun </label>
            <?= Html::dropDownList('UnjuranSearch[tahun]', $selectedYear, $yearList, ['class' => 'form-control', 'onchange' => '$("#unjuran_form").submit()']) ?>
        </div>
    </div> 

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sah') ?>

    <?php // echo $form->field($model, 'tarikh_jadi') ?>

    <?php // echo $form->field($model, 'tarikh_kemaskini') ?>

    <?php // echo $form->field($model, 'user') ?>

    <div class="form-group">
        <?php //= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php //= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
