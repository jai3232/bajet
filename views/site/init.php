<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Konfigurasi */
/* @var $form ActiveForm */

?>
<div class="site-konfigurasi">

    <?php $form = ActiveForm::begin(['action' => ['site/init']]); ?>
        <?= $form->field($model, 'emel') ?>
        <?= $form->field($model, 'sistem_ip')->textInput(['placeholder' => 'xxx.xxx.xxx.xxx'])->label('IP Sistem') ?>
        <?= $form->field($model, 'subnet_mask')->textInput(['placeholder' => 'xxx.xxx.xxx.xxx']) ?>
        <?= $form->field($model, 'gateway')->textInput(['placeholder' => 'xxx.xxx.xxx.xxx']) ?>
        <?= $form->field($model, 'lesen')->textarea() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-konfigurasi -->
