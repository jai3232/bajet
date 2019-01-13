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

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'readonly' => $model->level == 0 ? false : true]) ?>

    <?= $form->field($model, 'no_kp')->textInput(['maxlength' => true, 'readonly' => $model->level == 0 ? false : true])->label('No. KP (Tanpa "-")') ?>

    <?= $form->field($model, 'id_jabatan')->dropdownList(ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'), ['prompt' => '- Sila Pilih -', 'onchange' => '$.get("'.Url::to(['pengguna/unit-list']).'", {id: this.value}, function(data){$("#pengguna-id_unit").html(data); $("#pengguna-id_unit").val('.$model->id_unit.');$("#pengguna-id_unit").change();});', 'readonly' => Yii::$app->user->identity->accessLevel([0]) ? false : true])->label('Jabatan'); ?>

    <?= $form->field($model, 'id_unit')->dropdownList([], [])->label('Unit') ?>

    <?php if($model->isNewRecord) { ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Katalaluan') ?>

    <?= $form->field($model, 'password_ulang')->passwordInput(['maxlength' => true])->label('Ulang Katalaluan') ?>

    <?php } ?>

    <?= $form->field($model, 'emel')->textInput(['maxlength' => true]) ?>
    <?php
        if(strlen($model->photo) > 0) {
    ?>
        <div class="form-group">
            <?= Html::img('uploads/pengguna/'.$model->photo, ['width' => 200, 'height' => 200]) ?>
        </div>
    <?php
        }
    ?>
    <?= $form->field($model, 'photo_file')->fileInput(['class' => 'form-control'])->label('Photo Personal') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $this->registerJs('
        $("#pengguna-id_jabatan").trigger("change");
        ', \yii\web\View::POS_READY);

    $this->registerCss('
        div.required label.control-label:after {
            content: " *";
        }
    ');

?>