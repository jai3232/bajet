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

<div class="pengguna-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_kp')->textInput(['maxlength' => true])->label('No. KP (Tanpa "-")') ?>

    <?= $form->field($model, 'id_jabatan')->dropdownList(ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'), ['prompt' => '- Sila Pilih -', 'onchange' => '$.get("'.Url::to(['pengguna/unit-list']).'", {id: this.value}, function(data){$("#pengguna-id_unit").html(data); $("#pengguna-id_unit").val('.$model->id_unit.').change();});'])->label('Jabatan'); ?>

    <?= $form->field($model, 'id_unit')->dropdownList([], [])->label('Unit') ?>

    <?= $form->field($model, 'emel')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $this->registerJs('
        function getUnit(val) {
           
        }
    ', static::POS_END);
?>

<?php 
     $this->registerJs('
        $("#pengguna-id_jabatan").trigger("change");
        ', \yii\web\View::POS_END);
?>