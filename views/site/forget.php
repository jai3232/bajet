<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Personal */

$this->title = 'Lupa Katalaluan';
//$this->params['breadcrumbs'][] = ['label' => 'Personal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
    if($found == 1 && $status > 0) {
?>
    <div class="alert alert-info">
      <strong>Katalaluan telah dihantar ke emel yang didaftarkan. Sila periksa inbox dan spam box email anda . Berkemungkinan email dihantar dianggaap spam oleh server penerima.</strong></strong>
    </div>
<?php        
    return;
    }
?>
<div class="forgot-password">

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="personal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_kp')->textInput(['maxlength' => true, 'placeholder' => 'No. Kad Pengenalan'])->label('ID Pengguna') ?>

    <?= $form->field($model, 'emel')->textInput(['maxlength' => true, 'placeholder' => 'Emel'])->label('Emel yang didaftarkan') ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Set Katalaluan Baru', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
    if($found == '0')
    {
?>
    <div class="alert alert-warning">
      <strong>No KP / Emel tiada dalam sistem.</strong>
    </div>
<?php
    }
    else if($status == '0') {
?>
    <div class="alert alert-warning">
      <strong>Akaun anda tidak aktif. Sila hubungi sistem admin untuk status akaun anda.</strong>
    </div>
<?php
    }
	
?>

