<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Konfigurasi */
/* @var $form ActiveForm */

$negeri = [
    'Johor' => 'Johor',
    'Kedah' => 'Kedah',
    'Kelantan' => 'Kelantan',
    'Melaka' => 'Melaka',
    'Negeri Sembilan' => 'Negeri Sembilan',
    'Pahang' => 'Pahang',
    'Perak' => 'Perak',
    'Perlis' => 'Perlis',
    'Pulau Pinang' => 'Pulau Pinang',
    'Sabah' => 'Sabah',
    'Sarawak' => 'Sarawak',
    'Selangor' => 'Selangor',
    'Terengganu' => 'Terengganu',
    'W.P. Kuala Lumpur' => 'W.P. Kuala Lumpur',
    'W.P. Labuan' => 'W.P. Labuan',
    'W.P. Putrajaya' => 'W.P. Putrajaya',
    ];
?>
<div class="site-konfigurasi">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'nama_agensi') ?>
        <?= $form->field($model, 'alamat1')->label('Alamat 1') ?>
        <?= $form->field($model, 'alamat2')->label('Alamat 2') ?>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'poskod') ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'bandar') ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'negeri')->dropdownList($negeri, ['prompt' => '-Sila Pilih-']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'no_telefon') ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'no_faks') ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'emel') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'smtp')->label('Emel SMTP') ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'port')->label('SMTP Port') ?>
            </div>
            <div class="col-sm-1">
                <?= $form->field($model, 'enkripsi') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'username')->label('SMTP Username') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'password')->passwordInput()->label('Katalaluan') ?>
            </div>
        </div>
                <?= $form->field($model, 'papar_logo')->checkbox(['label' => 'Papar Logo Agensi']) ?>
        <?php
            if(strlen($model->logo) > 0) {
        ?>
            <div class="form-group">
                <?= Html::img('uploads/'.$model->logo, ['width' => 200, 'height' => 200]) ?>
            </div>
        <?php
            }
        ?>

        <?= $form->field($model, 'file')->fileInput(['class' => 'form-control'])->label('Logo Agensi') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-konfigurasi -->
