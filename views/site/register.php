<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Jabatan;
use yii\captcha\Captcha;


/* @var $this yii\web\View */
/* @var $model app\models\Pengguna */

$this->title = Yii::t('app', 'Daftar Pengguna');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengguna-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_kp')->textInput(['maxlength' => true])->label('No. KP (Tanpa "-")') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Katalaluan') ?>

    <?= $form->field($model, 'password_ulang')->passwordInput(['maxlength' => true])->label('Ulang Katalaluan') ?>

    <?= $form->field($model, 'id_jabatan')->dropdownList(ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'), 
                                            ['prompt' => '- Sila Pilih -', 
                                            'onchange' => '$.get("'.Url::to(['pengguna/unit-list']).'", {id: this.value}, function(data){$("#register-id_unit").html(data);});'])->label('Jabatan'); ?>

    <?= $form->field($model, 'id_unit')->dropdownList([], [])->label('Unit') ?>

    <?= $form->field($model, 'emel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'captcha')->widget(Captcha::className()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Daftar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
