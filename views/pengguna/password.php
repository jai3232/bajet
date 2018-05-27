<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;    
use app\models\Jabatan;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model app\models\Pengguna */
/* @var $form yii\widgets\ActiveForm */
?>

<label></label>
<?php
if(isset($msg)) {
    if($msg == 'OK') {

?>
    <div class="alert alert-info">
      <strong>Katalaluan telah berjaya ditukar.</strong>
    </div>
<?php
    }
    if($msg == 'MatchError') {
?>
    <div class="alert alert-warning">
      <strong>Katalaluan baru tidak sama.</strong>
    </div>
<?php
    }
    if($msg == 'PassError') {
?>
    <div class="alert alert-warning">
      <strong>Katalaluan semasa yang dimasukkan salah.</strong>
    </div>
<?php
    }
}
?>

<div class="personal-katalaluan">

    <?= Html::beginForm(['pengguna/password', 'id' => yii::$app->user->identity->id], 'post') ?>
    <div class="form-group">
        <label>Katalaluan Lama</label>
        <?= Html::passwordInput('katalaluan_lama', '', ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <label>Katalaluan Baru</label>
        <?= Html::passwordInput('katalaluan_baru', '', ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <label>Katalaluan Baru (Ulang)</label>
        <?= Html::passwordInput('katalaluan_baru_ulang', '', ['class' => 'form-control']) ?>
        <?= Html::hiddenInput('id', Yii::$app->user->identity->id, ['class' => 'form-control']) ?>
    </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Tukar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Padam', ['class' => 'btn btn-default']) ?>
    </div>

    <?= Html::endForm() ?>

</div>
