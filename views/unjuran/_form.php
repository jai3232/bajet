<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Jabatan;

/* @var $this yii\web\View */
/* @var $model app\models\Unjuran */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$currentYear = date("Y");
?>
<div class="unjuran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os')->textInput(['maxlength' => true])->label('OS') ?>

    <?= $form->field($model, 'ol')->textInput(['maxlength' => true])->label('OL') ?>

    <?= $form->field($model, 'id_jabatan')->dropdownList(ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'), ['prompt' => '- Sila Pilih -', 'onchange' => '$.get("'.Url::to(['pengguna/unit-list']).'", {id: this.value}, function(data){$("#unjuran-id_unit").html(data); $("#unjuran-id_unit").val('.$model->id_unit.');});'])->label('Jabatan'); ?>

    <?= $form->field($model, 'id_unit')->dropdownList([''])->label('Unit') ?>

    <?= $form->field($model, 'butiran')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kuantiti')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'kod')->dropdownList(['' => '- Sila Pilih -', 'B' => 'B', 'C' => 'C', 'D' => 'D']) ?>

    <?= $form->field($model, 'jumlah_unjuran')->textInput(['type' => 'number']) ?>

    <?php //= $form->field($model, 'kongsi')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'public')->textInput() ?>
    <?php
        $yearList = [];
        for($i = $currentYear; $i < $currentYear + 5; $i++) {
            $yearList[$i] = $i; 
        }
    ?>
    <?= $form->field($model, 'tahun')->dropdownList($yearList,  
                                                    ['prompt' => '- Sila Pilih -'],
                                                    ['options' => ['2020' => ['selected' => true]]]
                                                    ) ?>

    <?= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'sah')->textInput() ?>

    <?= $form->field($model, 'tarikh_jadi')->textInput() ?>

    <?= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
