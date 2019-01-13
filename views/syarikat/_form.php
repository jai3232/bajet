<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Syarikat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="syarikat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_syarikat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'nama_pengurus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_telefon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_faks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emel')->textInput(['maxlength' => true])->label('Emel') ?>

    <?= $form->field($model, 'cawangan_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_akaun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_rujukan')->textInput(['maxlength' => true])->label('No. Rujukan Fail') ?>

    <?= $form->field($model, 'tarikh_daftar')->widget(yii\jui\DatePicker::class, [
        'language' => 'ms',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'readOnly' => true],
    ])  ?>

    <?= $form->field($model, 'pkk')->textInput(['maxlength' => true])->label('PKK') ?>

    <?= $form->field($model, 'kelas_F1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kelas_F2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kelas_F3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kelas_F4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kelas_F5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kelas_F6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kelas_F7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kew')->textInput(['maxlength' => true])->label('No. Sijil Kewangan') ?>

    <?= $form->field($model, 'tarikh_luput_kew')->label('Tarikh Luput Sijil')->widget(yii\jui\DatePicker::class, [
        'language' => 'ms',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'readOnly' => true],
    ])  ?>

    <?= $form->field($model, 'kod_kepala0')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kod_kepala1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kod_kepala2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'terima')->checkbox() ?>

    <?= $form->field($model, 'cidb')->textInput(['maxlength' => true])->label('CIDB') ?>

    <?= $form->field($model, 'pkk_elektrik')->textInput(['maxlength' => true])->label('PKK Elektrik') ?>

    <?= $form->field($model, 'kepala_sub_kepala')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kod_cukai')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    
?>
